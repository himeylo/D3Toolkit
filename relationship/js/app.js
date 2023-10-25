var pathArray = window.location.pathname.split('/'),
    base,
    baseLinks,
    strategies,
    maxZoom = 2;

var folder = pathArray[0] === "" ? pathArray[1] : pathArray[0];

if ( folder === 'carteeh' | folder === 'carteeh3' ) {
  // base = "/wp-content/plugins/d3js-circle-packing/relationship/json/";
  // baseLinks = "/wp-content/plugins/d3js-circle-packing/";
} else {
  base = "/wp-content/plugins/d3js-circle-packing/relationship/json/";
  baseLinks = "/wp-content/plugins/d3js-circle-packing/framework/";
  // base = "/wp-json/wp/v2/";
  // baseLinks = "/wp-json/wp/v2/strategy";
}

d3.select("#chart").append("svg");

d3.json(base + "strategies.json", function(error, root) {
  if (error) { throw error; }

  strategies = root;

  for (var i = 0; i < strategies.children.length; i++) {
    strategies.children[i].origChildren = strategies.children[i].children;
  }

  circles(strategies);
});

d3.json(base + "attributes.json", function(error, root) {
  if (error) { throw error; }
  attributes = root;
});

d3.json(baseLinks + "links.json", function(error, root) {
  if (error) { throw error; }
  pdfLinks = root[0];
});

var select2Fields = jQuery('.select2'),
    mapAreas = jQuery('.map-container a'),
    areaChildren = jQuery('#area .button'),
    back = jQuery('#back'),
    zoomOut = jQuery('#zoom-out'),
    strategies,
    attributes,
    pdfLinks,
    computedWidth = document.getElementById("chart").offsetWidth - 40,
    prevObj = [];

back.on('click', function() {
  if (prevObj.length > 1) {
    prevObj.shift();
  } else {
    circles(strategies);
    return;
  }

  tree(prevObj[0]);
});

zoomOut.on('click', function() {
  circles(strategies);
});

select2Fields.select2({
  allowClear: true,
  placeholder: function() {
    jQuery(this).data('placeholder');
  }
});

mapAreas.on("click", function() {
  jQuery(this).toggleClass('selected');
  jQuery('#' + this.id + '-button').toggleClass('active');

  filterExec();
});

areaChildren.on("click", function() {
  var $this = jQuery(this);
  jQuery('#' + $this.data('value')).toggleClass('selected');
  $this.toggleClass('active');

  filterExec();
});

jQuery('#reset').on("click", function() {
  resetValues();
});


select2Fields.on('change', filterExec);

function filterExec() {
  var values = filterValues();

  for (var i = 0; i < strategies.children.length; i++) {
    strategies.children[i].children = strategies.children[i].origChildren;

    if (typeof strategies.children[i].children !== "undefined") {
      strategies.children[i].children = strategies.children[i].children.filter(
        applyFilters.bind(null, [strategies.children[i].id-1, values])
      );
    }
  }

  circles(strategies);
}

function circles(strats) {
  back.addClass('hide');
  zoomOut.addClass('hide');
  d3.select(".legend svg").remove();
  var margin = 20,
    diameter = computedWidth;

  var pack = d3.layout.pack()
      .padding(2)
      .size([diameter - margin, diameter - margin])
      .value(function() { return 1; });
      //.sort(function(a, b) { return a.id > b.id ? 1 : a.id < b.id ? -1 : 0; });

  d3.selectAll("#chart>svg").remove();
  var svg = d3.select("#chart").append("svg")
      .attr('class', 'chart')
      .attr("width", "100%")
    .append("g")
      .attr("id", "chartg");


  var focus = strats,
      nodes = pack.nodes(strats),
      view;

  var circle = svg.selectAll("circle")
      .data(nodes)
    .enter().append("circle")
      .filter(function(d){ return d.parent; })
      .attr("id", function(d) { return slugify(d.name); })
      .attr("class", function(d) { return d.parent ? d.children ? "node" : "node node-leaf parent-" + d.parent.id : "node node-root"; })
      .attr("data-id", function(d) { return d.id; })
      .attr("data-parent-id", function(d) { if (typeof d.parent !== 'undefined') { return d.parent.id; } })
      .style("fill", function(d) {
        if (d.depth === 1) {
          return color(d.name);
        } else if (d.depth === 0) {
          return "#f9f9f9";
        } else {
          return color2(d.parent.name);
        } })
      .on("click", function(d) {
        d3.selectAll('.node-leaf').classed("focused", false);
        d3.selectAll('.node-leaf.parent-' + d.id).classed("focused", true);

        if (focus !== d) { zoom(d); }
        d3.event.stopPropagation();
      })
      .on('mouseover', function(d) {
        if (typeof d.parent !== 'undefined' && typeof d.parent.id !== 'undefined') {
          var classes = "label depth" + d.depth + " id-" + d.id + " parent-" + d.parent.id;
          if (d.depth > 1) {
            classes += ' allow-pointer-events';
          }
          d3.select("foreignObject.id-" + d.id + ".parent-" + d.parent.id)
            .attr('class', classes + ' hover-text');
        }
      })
      .on('mouseout', function(d) {
        if (typeof d.parent !== 'undefined' && typeof d.parent.id !== 'undefined') {
          var classes = "label depth" + d.depth + " id-" + d.id + " parent-" + d.parent.id;
          if (d.depth > 1) {
            classes += ' allow-pointer-events';
          }
          d3.select("foreignObject.id-" + d.id + ".parent-" + d.parent.id)
            .attr('class', classes);
        }
      })
      // .on('mouseup', function(d) { if (d.depth === 2) { tree(d); } });
      // .on('mouseup', function(d) {
      //   // Disable the lower-level views as requested.
      //   if (d.depth >= maxZoom) {
      //     return;
      //   }
      //   if (d.depth === 2) {
      //     tree(d);
      //   }
      // });

  svg.selectAll("foreignObject")
      .data(nodes)
    .enter().append("foreignObject")
      .attr("class", function(d) {
        var classes = "label depth" + d.depth + " id-" + d.id;
        if (typeof d.parent !== 'undefined' && typeof d.parent.id !== 'undefined') {
          classes = classes + ' parent-' + d.parent.id;
        }
        if (d.depth > 1) {
          classes += ' allow-pointer-events';
        }
        return classes;
      })
      .style("fill-opacity", function(d) { return d.parent === strats ? 1 : 0; })
      .style("display", function(d) { return d.parent === strats ? "inline" : "none"; })
      .append("xhtml:body")
      .html(function(d) {
        var content = "<div class='text-box'>";
        if (d.depth > 1) {
          var link = d.link || '/strategy/' + slugify(d.name);
          content += "<a class=\"depth" + d.depth + "\" href=\"" + link + "\">";
        } else {
          content += "<p class='depth" + d.depth + " bgtext'>";
        }
        content += d.name.split('/').join('/ ');
        if (d.depth > 1) {
          content += "</a>";
        } else {
          content += "</p>";
        }
        content += "</div>";
        return content;
      });

  // Allow links to disable other event handlers.
  document.querySelector('.chart').addEventListener('click', function(e){
    if ('A' === e.target.tagName) {
      e.stopPropagation();
      e.stopImmediatePropagation();
    }
  });

  var node = svg.selectAll("foreignObject");

  d3.select(".chart")
    .on("click", function() {
      d3.selectAll('.node-leaf').classed("focused", false);
      zoom(strats);
    });

  d3.selectAll(".node-leaf")
    .on("click", function(d) {
      if (focus !== d.parent) { zoom(d.parent); }

      d3.event.stopPropagation();
    });

  zoomTo([strats.x, strats.y, strats.r * 2 + margin]);
  setHeightCir(false);

  function zoom(d) {
    zoomOut.removeClass('hide');
    var focus = d;

    var transition = d3.transition()
      .duration(d3.event.altKey ? 7500 : 750)
      .tween("zoom", function() {
        var i = d3.interpolateZoom(view, [focus.x, focus.y, focus.r * 2 + margin]);
        return function(t) { zoomTo(i(t)); };
      });

    transition.selectAll("foreignObject.label")
      .filter(function(d) { return d.parent === focus || this.style.display === "inline"; })
      .style("fill-opacity", function(d) { return d.parent === focus ? 1 : 0; })
      .each("start", function(d) { if (d.parent === focus) { this.style.display = "inline"; } })
      .each("end", function(d) { if (d.parent !== focus) { this.style.display = "none"; } });

    transition.each('end', function() {
      setHeightCir(focus);
    });

    circle.style("fill", function(d) {
      var childColor = color3(d.parent.name);
      if (focus.depth === 0) {
        childColor = color2(d.parent.name);
      }
      if (d.depth === 1) {
        return color(d.name);
      } else if (d.depth === 0) {
        return "#f9f9f9";
      } else {
        return childColor;
      }
    });
  }

  function zoomTo(v) {
    var k = diameter / v[2];
    view = v;

    node.attr("transform", function(d) {
      var side = d.r * k * Math.cos(Math.PI / 4);
      return "translate(" + ((d.x - v[0]) * k - side) + "," + ((d.y - v[1]) * k - side) + ")";
    })
      .attr("width", function(d) { return 2 * d.r * k * Math.cos(Math.PI / 4); })
      .attr("height", function(d) {
        var side =  d.r * k * Math.cos(Math.PI / 4);
        if (d.depth < 2) {
          jQuery(".id-" + d.id + " p").css('font-size', Math.ceil(side / 3));
        } else {
          jQuery(".id-" + d.id + " div.text-box").css('font-size', Math.round(side / 3.2));
        }
        return 2 * side;
      });
    circle.attr("transform", function(d) { return "translate(" + (d.x - v[0]) * k + "," + (d.y - v[1]) * k + ")"; })
      .attr("r", function(d) { if (d.parent.children.length === 1) { return d.r * k * 0.8; } else { return d.r * k; } });
  }

  function setHeightCir(focus) {
    if (focus === false) {
      focus = {name: 'chartg'};
    } else if (focus.name === 'Strategies') {
      focus = {name: 'chartg'};
    }
    else {
      focus = {name: slugify(focus.name)};
     }

    var box = jQuery("#" + focus.name)[0].getBoundingClientRect();

    d3.transition()
      .select("#chart>svg").attr("height", box.height)
      .select("#chartg").attr("transform", "translate(" + computedWidth / 2 + "," + box.height / 2 + ")");
  }
}

function applyFilters(arg, o) {
  var p = arg[0],
      values = arg[1];

  var attr = attributes.children[p].children[o.id-1];

  if (values.length === 0) {
    return true;
  }

  for (var i = 0; i < values.length; i++) {
    if (attr[values[i]] !== 1) {
      return false;
    }
  }

  return true;
}

function filterValues() {
  var values = [];

  for (var i = 0; i < select2Fields.length; i++) {
    var $this = jQuery(select2Fields[i]);
    if ($this.val()) {
      values.push($this.val());
    }
  }

  for (i = 0; i < areaChildren.length; i++) {
    if (areaChildren[i].className.indexOf('active') > -1) {
      values.push(areaChildren[i].getAttribute('data-value'));
    }
  }

  return values;
}

function resetValues() {
  for (var i = 0; i < select2Fields.length; i++)  {
    jQuery(select2Fields[i]).select2("val", "");
  }

  mapAreas.removeClass('selected');
  areaChildren.removeClass('active');

  for (i = 0; i < strategies.children.length; i++) {
    strategies.children[i].children = strategies.children[i].origChildren;
  }

  circles(strategies);
}

function color(name) {
  var color = {
    "Less Emissions": "#0d2e5a",
    "Connectivity and Inclusion": "#eab840",
    "Healthy Destination": "#99331c",
    "Active Transport": "#e37a30",
    "Green Space": "#577120",
    "Less Contamination": "#734136",
    "Less Traffic Violence": "#2967a1",
    "Less Traffic Noise": "#ca624d"
  };

  return color[name];
}

function color2(name) {
  var color = {
    "Less Emissions": "#134587",
    "Connectivity and Inclusion": "#efc96e",
    "Healthy Destination": "#c44124",
    "Active Transport": "#e9975d",
    "Green Space": "#76992b",
    "Less Contamination": "#965546",
    "Less Traffic Violence": "#3381ca",
    "Less Traffic Noise": "#d68574"
  };

  return color[name];
}

function color3(name) {
  var color = {
    "Less Emissions": "#1c67ca",
    "Connectivity and Inclusion": "#f7e3b3",
    "Healthy Destination": "#e06e55",
    "Active Transport": "#f2c2a0",
    "Green Space": "#a0cb46",
    "Less Contamination": "#bb7c6d",
    "Less Traffic Violence": "#6fa7db",
    "Less Traffic Noise": "#e7b9af"
  };

  return color[name];
}

function tree(obj) {
  var diameter = computedWidth,
      width = diameter,
      height = diameter,
      factor = width / 1024 > 1 ? 1 : width / 1024,
      i = 0,
      duration = 350,
      root;

  var tree = d3.layout.tree()
      .size([360, diameter / 2 - 80])
      .separation(function(a, b) { return (a.parent === b.parent ? 1 : 10) / a.depth; });

  var diagonal = d3.svg.diagonal.radial()
      .projection(function(d) { return [d.y * factor, d.x / 180 * Math.PI]; });

  back.removeClass('hide');
  zoomOut.addClass('hide');
  d3.select(".legend svg").remove();
  update(obj);

  var legend = d3.select(".legend").append("svg")
    .attr("width", 225)
    .attr("height", 50)
    .append("g");
  legend.append("circle")
    .attr("cx", 10)
    .attr("cy", 10)
    .attr("r", 8)
    .attr("class", "legend-req")
    .style("fill", function() {
      return color2(obj.parent.name);
    })
    .style("stroke", function() {
      return color(obj.parent.name);
    });
  legend.append("text")
    .attr("x", 25)
    .attr("dy", 18)
    .attr("text-anchor", "start")
    .text("Same strategy theme");
  legend.append("circle")
    .attr("cx", 10)
    .attr("cy", 35)
    .attr("r", 8)
    .attr("class", "legend-opt")
    .style("fill", "#fff")
    .style("stroke", function() {
      return color(obj.parent.name);
    });
  legend.append("text")
    .attr("x", 25)
    .attr("dy", 42)
    .attr("text-anchor", "start")
    .text("Different strategy theme");

  function update(source) {
    d3.select(".legend-req")
      .style("fill", function() {
        return color2(source.parent.name);
      })
      .style("stroke", function() {
        return color(source.parent.name);
      });
    d3.select(".legend-opt")
      .style("stroke", function() {
        return color(source.parent.name);
      });

    d3.selectAll("#chart>svg").remove();
    var svg = d3.select("#chart").append("svg")
        .attr("class", "tree chart")
        .attr("width", width)
        .attr("height", height)
      .append("g")
        .attr("transform", "translate(" + diameter / 2 + "," + diameter / 2 + ")");

    var data = {
      "name": source.name,
      "children": source.related,
      "parent": source.parent
    };

    root = data;
    source.x0 = height / 2;
    source.y0 = 0;

    // Compute the new tree layout.
    var nodes = tree.nodes(root),
        links = tree.links(nodes);

    // Normalize for fixed-depth.
    nodes.forEach(function(d) { d.y = d.depth * 220; });

    // Update the nodes…
    var node = svg.selectAll("g.node")
      .data(nodes, function(d) { return d.id || (d.id = ++i); });

    // Enter any new nodes at the parent's previous position.
    var nodeEnter = node.enter().append("g")
      .attr("class", "node");

    nodeEnter.append("circle")
      .attr("r", 1e-6)
      .style("fill", function(d) { if (d.value === 2) {
          return color2(d.parent.parent.name);
        } else if(d.children) {
          return color2(d.parent.name);
        } else {
          return  "#fff";
        }
      })
      .style("stroke", function(d) {
        if (d.children) {
          return color(d.parent.name);
        } else {
          return color(d.parent.parent.name);
        }
      });

    nodeEnter.append("text")
      .attr("x", function(d) { if (d.depth === 0) { return; } return 10; })
      .attr("dy", ".35em")
      .attr("text-anchor", "start")
      .attr("class", function(d) {
        if (d.depth === 0) {
          if (typeof pdfLinks[slugify(d.name)] !== "undefined" && pdfLinks[slugify(d.name)].href) {
            return "middle tree-text clickable";
          }
          return "middle tree-text";
        }
        return "tree-text"; })
      .style("text-anchor", function(d) { if (d.depth === 0) { return "middle"; }})
      .text(function(d) { return d.name; });

    // Transition nodes to their new position.
    var nodeUpdate = node.transition()
      .duration(duration)
      .attr("transform", function(d) {
        if (d.depth === 0) { return; }
        return d.y > 0 ?  "rotate(" + (d.x - 90) + ")translate(" + d.y * factor + ")": "rotate(180)";
      });

    nodeUpdate.select("circle")
      .attr("r", function(d) { return d.depth ? 10 * factor : 50 * factor; })
      .style("fill", function(d) {
        if (d.value === 2) {
          return color2(d.parent.parent.name);
        } else if(d.children) {
          return color2(d.parent.name);
        } else {
          return  "#fff";
        }
      })
      .style("stroke", function(d) {
        if (d.children) {
          return color(d.parent.name);
        } else {
          return color(d.parent.parent.name);
        }
      });

    nodeUpdate.select("text")
      .style("fill-opacity", 1)
      .attr("transform", function(d) {
        if (d.depth === 0) { return; }
        var box = this.getBBox();
        return d.x < 179.99999999999997 ? "translate(5,0)" : "rotate(180)translate(-" + (box.width + 25)  + ")";
      });

    // Update the links…
    var link = svg.selectAll("path.link")
      .data(links, function(d) { return d.target.id; });

    // Enter any new links at the parent's previous position.
    link.enter().insert("path", "g")
      .attr("class", "link")
      .attr("d", function() {
        var o = {x: source.x0, y: source.y0};
        return diagonal({source: o, target: o});
      });

    // Transition links to their new position.
    link.transition()
      .duration(duration)
      .attr("d", diagonal)
      .each('end', function() {
        setHeight();
      });

    // Transition exiting nodes to the parent's new position.
    link.exit().transition()
      .duration(duration)
      .attr("d", function() {
        var o = {x: source.x, y: source.y};
        return diagonal({source: o, target: o});
      })
      .remove();

    // Stash the old positions for transition.
    nodes.forEach(function(d) {
      d.x0 = d.x;
      d.y0 = d.y;
    });

    svg.selectAll("text")
      .on('mouseup', function(d) {
        if (!d.children) {
          for (var i = 0; i < strategies.children.length; i++) {
            for (var ii = 0; ii < strategies.children[i].origChildren.length; ii++) {
              if (strategies.children[i].origChildren[ii].name === d.name) {
                update(strategies.children[i].origChildren[ii]);
              }
            }
          }
        } else {
          var href = typeof pdfLinks[slugify(d.name)] !== "undefined" ? pdfLinks[slugify(d.name)].href : false;
          if (href) {
            window.open(href, '_blank');
          }
        }
      });

    function setHeight() {
      var box = jQuery("#chart>svg>g")[0].getBoundingClientRect(),
          height = box.height + 25;
      d3.transition()
        .select("#chart>svg").attr("height", height)
        .select("#chart>svg>g").attr("transform", "translate(" + computedWidth / 2 + "," + (height / 2 + 10) + ")");
    }

    if (prevObj[0] !== source) {
      prevObj.unshift(source);
    }
  }
}

function slugify(text) {
  return text.toString().toLowerCase()
    .replace(/\s+/g, '-')           // Replace spaces with -
    .replace( /\//g, '-' )          // Replace forward-slash with single -
    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
    .replace(/^-+/, '')             // Trim - from start of text
    .replace(/-+$/, '');            // Trim - from end of text
}
