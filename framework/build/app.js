function offset(a) {
  var b = a.getBoundingClientRect(),
    c = window.pageXOffset || document.documentElement.scrollLeft,
    d = window.pageYOffset || document.documentElement.scrollTop;
  return { elTop: b.top + d, elLeft: b.left + c, top: d, left: c };
}
function debounce(a, b) {
  var c;
  return function () {
    clearTimeout(c),
      (c = setTimeout(function () {
        (c = null), a.call();
      }, b));
  };
}
function toggleActive(a) {
  return a.hasClass('active')
    ? (a.removeClass('active'),
      a.attr('aria-pressed', 'false'),
      a.hasClass('sort-button') &&
        a
          .children('.genericon')
          .toggleClass('genericon-downarrow')
          .toggleClass('genericon-uparrow'),
      a.hasClass('sort-button') ||
        a
          .children('span.genericon')
          .toggleClass('genericon-close')
          .toggleClass('genericon-plus'),
      !1)
    : (a.addClass('active'),
      a.attr('aria-pressed', 'true'),
      a.children('.genericon').hasClass('genericon-uparrow') ||
      a.children('.genericon').hasClass('genericon-downarrow') ||
      !a.hasClass('sort-button')
        ? a.hasClass('sort-button') &&
          a
            .children('.genericon')
            .toggleClass('genericon-uparrow')
            .toggleClass('genericon-downarrow')
        : a.children('.genericon').toggleClass('genericon-uparrow'),
      a.hasClass('sort-button') ||
        a
          .children('span.genericon')
          .toggleClass('genericon-close')
          .toggleClass('genericon-plus'),
      !0);
}
function filterValues() {
  for (
    var a = {
        cost: [],
        time: [],
        impact: [],
        who: [],
        type: [],
        subtype: [],
        objective: [],
        phase: []
      },
      b = costFilter.children(),
      c = 0;
    c < b.length;
    c++
  )
    b[c].className.indexOf('active') > -1 &&
      a.cost.push(b[c].getAttribute('data-value'));
  var d = timeFilter.children();
  for (c = 0; c < d.length; c++)
    d[c].className.indexOf('active') > -1 &&
      a.time.push(d[c].getAttribute('data-value'));
  var e = impactFilter.children();
  for (c = 0; c < e.length; c++)
    e[c].className.indexOf('active') > -1 &&
      a.impact.push(e[c].getAttribute('data-value'));
  var f = typeFilter.children();
  for (c = 0; c < f.length; c++)
    f[c].className.indexOf('active') > -1 &&
      a.type.push(f[c].getAttribute('data-value'));
  var g = phaseFilter.children();
  for (c = 0; c < g.length; c++)
    g[c].className.indexOf('active') > -1 &&
      a.phase.push(g[c].getAttribute('data-value'));
  return (
    (a.who = whoFilter.val()),
    (a.subtype = subtypeFilter.val()),
    (a.phase = phaseFilter.val()),
    a
  );
}
function arrayIntersect(a, b) {
  return void 0 === a || null === a
    ? []
    : jQuery.grep(a, function (a) {
        return jQuery.inArray(a, b) > -1;
      });
}
var strategy = (function () {
    var a = function (a) {
        var b = {
          2: '#eab840',
          3: '#99331c',
          1: '#0d2e5a',
          6: '#734136',
          5: '#577120',
          4: '#e37a30',
          7: '#2967a1',
          8: '#ca624d'
        };
        return b[f(a)];
      },
      b = function (a) {
        var b = {
          emissions: 'Less Emissions',
          connectivity: 'Connectivity and Inclusion',
          'healthy-destination': 'Healthy Destination',
          'active-transport': 'Active Transport',
          'green-space': 'Green Space',
          contamination: 'Less Contamination',
          violence: 'Less Traffic Violence',
          noise: 'Less Traffic Noise'
        };
        return b[a];
      },
      c = function (a) {
        var b = {
          sustainability: 'Sustainability Strategies',
          'smart-growth': 'Smart Growth Strategies',
          equity: 'Equity Strategies',
          'infrastructure-modification':
            'Infrastructure Modification Strategies',
          'transportation-demand-management':
            'Transportation Demand Management Strategies',
          'transportation-system-management':
            'Transportation System Management Strategies'
        };
        return 'object' == typeof a ? b[a[a.length - 1]] : b[a];
      },
      d = function (a) {
        var b = {
          'policy-and-planning': 'Policy and Planning',
          'project-development': 'Project Development',
          'material-selection': 'Material Selection',
          construction: 'Construction',
          operations: 'Operations',
          maintenance: 'Maintenance',
          'end-of-life': 'End of Life'
        };
        return 'object' == typeof a ? b[a[a.length - 1]] : b[a];
      },
      e = function (a) {
        var b = {
          automakers: 'Automakers',
          'automobile-repair-shops': 'Automobile repair shops',
          'car-owners': 'Car owners',
          'carsharing-and-ridesharing-apps': 'Carsharing and ridesharing apps',
          community: 'Local Community',
          'construction-companies': 'Construction companies',
          'drainage-engineers': 'Drainage engineers',
          employees: 'Employees',
          'employers-and-employees': 'Employers and employees',
          farmers: 'Farmers',
          federal: 'Federal Government Authorities',
          'federal-agencies': 'Federal agencies',
          'fleet-managers': 'Fleet managers',
          'healthcare-providers': 'Healthcare providers',
          'law-enforcement': 'Law enforcement',
          'local-businesses': 'Local businesses',
          'local-governments': 'Local governments',
          'local-health-departments': 'Local health departments',
          mpo: 'MPOs',
          ngo: 'NGOs',
          policymakers: 'Policymakers',
          'private-developers': 'Private developers',
          'school-boards': 'School boards',
          'software-developers': 'Software developers',
          'state-and-local': 'State and Local Government Authorities',
          'state-governments': 'State governments',
          suppliers: 'Suppliers',
          'technology-companies': 'Technology companies',
          'transit-agencies': 'Transit agencies',
          'vegetation-management-experts': 'Vegetation management experts',
          'vulnerable-road-users': 'Vulnerable road users',
          'waste-management-companies': 'Waste management companies'
        };
        return 'object' == typeof a ? b[a[a.length - 1]] : b[a];
      },
      f = function (a) {
        return a.indexOf('connectivity') > -1
          ? 2
          : a.indexOf('healthy-destination') > -1
          ? 3
          : a.indexOf('active-transport') > -1
          ? 4
          : a.indexOf('green-space') > -1
          ? 5
          : a.indexOf('contamination') > -1
          ? 6
          : a.indexOf('violence') > -1
          ? 7
          : a.indexOf('emissions') > -1
          ? 1
          : void 0;
      };
    return {
      color: a,
      category: b,
      subcategory: c,
      phase: d,
      who: e,
      categoryFilter: f
    };
  })(),
  tool = (function (a) {
    var b = function (a) {
        var b = {
          2: '#eab840',
          3: '#99331c',
          1: '#0d2e5a',
          6: '#734136',
          5: '#577120',
          4: '#e37a30',
          7: '#2967a1',
          8: '#ca624d'
        };
        return b[d(a)];
      },
      c = function (a) {
        var b = {
          emissions: 'Less Emissions',
          connectivity: 'Connectivity and Inclusion',
          'healthy-destination': 'Healthy Destination',
          'active-transport': 'Active Transport',
          'green-space': 'Green Space',
          contamination: 'Less Contamination',
          violence: 'Less Traffic Violence',
          noise: 'Less Traffic Noise'
        };
        return b[a];
      },
      d = function (a) {
        return a.indexOf('connectivity') > -1
          ? 2
          : a.indexOf('healthy-destination') > -1
          ? 3
          : a.indexOf('active-transport') > -1
          ? 4
          : a.indexOf('green-space') > -1
          ? 5
          : a.indexOf('contamination') > -1
          ? 6
          : a.indexOf('violence') > -1
          ? 7
          : a.indexOf('emissions') > -1
          ? 1
          : void 0;
      };
    return { color: b, category: c, categoryFilter: d };
  })(),
  cost = d3
    .select('.cost-container')
    .append('svg')
    .attr('class', 'cost three-fourths');
cost
  .append('rect')
  .attr('class', 'dollar cost1')
  .attr('fill', '#c1c1c1')
  .attr('x', 0)
  .attr('y', '80%')
  .attr('width', '17%')
  .attr('height', '20%'),
  cost
    .append('svg:image')
    .attr(
      'xlink:href',
      '../../wp-content/plugins/d3-toolkit/framework/images/dollar-sign.svg'
    )
    .attr('x', 0)
    .attr('y', '80%')
    .attr('width', '17%')
    .attr('height', '20%'),
  cost
    .append('rect')
    .attr('class', 'dollar cost2')
    .attr('fill', '#c1c1c1')
    .attr('x', '21%')
    .attr('y', '60%')
    .attr('width', '18%')
    .attr('height', '40%'),
  cost
    .append('svg:image')
    .attr(
      'xlink:href',
      '../../wp-content/plugins/d3-toolkit/framework/images/dollar-sign.svg'
    )
    .attr('x', '21%')
    .attr('y', '65%')
    .attr('width', '18%')
    .attr('height', '30%'),
  cost
    .append('rect')
    .attr('class', 'dollar cost3')
    .attr('fill', '#c1c1c1')
    .attr('x', '42%')
    .attr('y', '40%')
    .attr('width', '18%')
    .attr('height', '60%'),
  cost
    .append('svg:image')
    .attr(
      'xlink:href',
      '../../wp-content/plugins/d3-toolkit/framework/images/dollar-sign.svg'
    )
    .attr('x', '43%')
    .attr('y', '50%')
    .attr('width', '16%')
    .attr('height', '45%'),
  cost
    .append('rect')
    .attr('class', 'dollar cost4')
    .attr('fill', '#c1c1c1')
    .attr('x', '63%')
    .attr('y', '20%')
    .attr('width', '18%')
    .attr('height', '80%'),
  cost
    .append('svg:image')
    .attr(
      'xlink:href',
      '../../wp-content/plugins/d3-toolkit/framework/images/dollar-sign.svg'
    )
    .attr('x', '63%')
    .attr('y', '22%')
    .attr('width', '18%')
    .attr('height', '80%'),
  cost
    .append('rect')
    .attr('class', 'dollar cost5')
    .attr('fill', '#c1c1c1')
    .attr('x', '84%')
    .attr('y', 0)
    .attr('width', '17%')
    .attr('height', '100%'),
  cost
    .append('svg:image')
    .attr(
      'xlink:href',
      '../../wp-content/plugins/d3-toolkit/framework/images/dollar-sign.svg'
    )
    .attr('x', '81%')
    .attr('y', 0)
    .attr('width', '22%')
    .attr('height', '100%');
var time = d3
  .select('.time-container')
  .append('svg')
  .attr('class', 'time three-fourths')
  .attr('fill', '#c1c1c1')
  .attr('height', 50);
time
  .append('rect')
  .attr('class', 'time-base')
  .attr('x', 0)
  .attr('y', 12.5)
  .attr('rx', '12')
  .attr('ry', '12')
  .attr('width', '100%')
  .attr('height', 25),
  time
    .append('rect')
    .attr('class', 'time-value')
    .attr('x', 0)
    .attr('y', 12.5)
    .attr('rx', '12')
    .attr('ry', '12')
    .attr('width', '100%')
    .attr('height', 25);
var eheight = '100%',
  ewidth = '50%',
  rBase = 8,
  impactCont = d3.select('.impact-container'),
  impact = impactCont.append('svg').attr('class', 'impact three-fourths');
isNaN((impact.style('width').replace('px', '') / 2) * 0.9) ||
  impact.attr('height', (impact.style('width').replace('px', '') / 2) * 0.9),
  impact
    .append('circle')
    .attr('class', 'impact state')
    .attr('fill', '#c1c1c1')
    .attr('cx', ewidth)
    .attr('cy', eheight)
    .attr('r', rBase + 48 + '%'),
  impact
    .append('circle')
    .attr('fill', 'white')
    .attr('cx', ewidth)
    .attr('cy', eheight)
    .attr('r', rBase + 40 + '%'),
  impact
    .append('circle')
    .attr('class', 'impact regional')
    .attr('fill', '#c1c1c1')
    .attr('cx', ewidth)
    .attr('cy', eheight)
    .attr('r', rBase + 36 + '%'),
  impact
    .append('circle')
    .attr('fill', 'white')
    .attr('cx', ewidth)
    .attr('cy', eheight)
    .attr('r', rBase + 28 + '%'),
  impact
    .append('circle')
    .attr('class', 'impact local')
    .attr('fill', '#c1c1c1')
    .attr('cx', ewidth)
    .attr('cy', eheight)
    .attr('r', rBase + 24 + '%'),
  impact
    .append('circle')
    .attr('fill', 'white')
    .attr('cx', ewidth)
    .attr('cy', eheight)
    .attr('r', rBase + 16 + '%'),
  impact
    .append('circle')
    .attr('class', 'impact corridor')
    .attr('fill', '#c1c1c1')
    .attr('cx', ewidth)
    .attr('cy', eheight)
    .attr('r', rBase + 12 + '%'),
  impact
    .append('circle')
    .attr('fill', 'white')
    .attr('cx', ewidth)
    .attr('cy', eheight)
    .attr('r', rBase + 4 + '%'),
  impact
    .append('circle')
    .attr('class', 'impact spot')
    .attr('fill', '#c1c1c1')
    .attr('cx', ewidth)
    .attr('cy', eheight)
    .attr('r', rBase + '%');
var solutionDiv = document.getElementById('solutions');
solutionDiv.addEventListener(
  'mouseover',
  function (a) {
    if ('undefined' == typeof a.target.classList[1]) return !1;
    var b = setTimeout(function () {
      var b = a.target.classList[1],
        c = jQuery('.solution.' + b);
      d3
        .select('.topic-text')
        .text(strategy.subcategory(c.data('subcategory')))
        .classed('hidden', !1),
        d3.select('.topic-angle').classed('hidden', !1),
        d3.select('.chart-title').text(c.data('title')).classed('hidden', !1);
      var d =
        'undefined' != typeof c.data('category')
          ? c.data('category').join(' ')
          : '';
      d3.select('.chart-icon').classed('hidden', !1).classed(d, !0),
        d3
          .select('.chart-image')
          .attr('src', c.data('chart-img'))
          .classed('hidden', !1),
        '' !== c.data('desc') &&
          d3.select('.desc').append('p').text(c.data('desc'));
      for (var e = 1; e <= 5; e++) {
        var f = d3.select('.cost' + e);
        e <= strategy.costNumSingle(c.data('cost'))
          ? f.transition().style('fill', strategy.color(c.data('category')))
          : f.transition().style('fill', '#c1c1c1');
      }
      var g = d3.select('.time-value'),
        h = d3.select('.time-container');
      0 === strategy.timeNumSingle(c.data('time'))
        ? h.append('p').text(strategy.timeText(c.data('time')))
        : 1 === strategy.timeNumSingle(c.data('time'))
        ? (g
            .transition()
            .attr('width', '10%')
            .style('fill', strategy.color(c.data('category'))),
          h.append('p').text(strategy.timeText(c.data('time'))))
        : 2 === strategy.timeNumSingle(c.data('time'))
        ? (g
            .transition()
            .attr('width', '20%')
            .style('fill', strategy.color(c.data('category'))),
          h.append('p').text(strategy.timeText(c.data('time'))))
        : 3 === strategy.timeNumSingle(c.data('time'))
        ? (g
            .transition()
            .attr('width', '60%')
            .style('fill', strategy.color(c.data('category'))),
          h.append('p').text(strategy.timeText(c.data('time'))))
        : 4 === strategy.timeNumSingle(c.data('time'))
        ? (g
            .transition()
            .attr('width', '80%')
            .style('fill', strategy.color(c.data('category'))),
          h.append('p').text(strategy.timeText(c.data('time'))))
        : 5 === strategy.timeNumSingle(c.data('time')) &&
          (g
            .transition()
            .attr('width', '100%')
            .style('fill', strategy.color(c.data('category'))),
          h.append('p').text(strategy.timeText(c.data('time'))));
      var i = c.data('impact'),
        j = i.length,
        k = d3.select('.impact-container');
      for (e = 0; e < j; e++)
        d3.select('.' + i[e].toLowerCase())
          .transition()
          .style('fill', strategy.color(c.data('category')));
      k.append('p').text(strategy.impactText(c.data('impact')));
      var l = c.data('who'),
        m = c.data('hurdle'),
        n = l.length,
        o = d3.select('.who-container'),
        p = m.length,
        q = d3.select('.hurdles-container');
      for (e = 0; e < n; e++)
        if ('none' !== l[e]) {
          var r = o.append('div').attr('class', 'who-icon');
          r
            .append('img')
            .attr(
              'src',
              '../../wp-content/plugins/d3-toolkit/framework/who-hurdle-icons/' +
                l[e] +
                '.svg'
            )
            .attr('class', 'who-hurdle-icon'),
            r
              .append('p')
              .attr('class', c.data('category'))
              .text(l[e].replace(/-/g, ' ').toUpperCase());
        }
      for (e = 0; e < p; e++)
        if ('none' !== m[e]) {
          var s = q.append('div').attr('class', 'hurdle-icon');
          s
            .append('img')
            .attr(
              'src',
              '../../wp-content/plugins/d3-toolkit/framework/who-hurdle-icons/' +
                m[e] +
                '.svg'
            )
            .attr('class', 'who-hurdle-icon'),
            s
              .append('p')
              .attr('class', c.data('category'))
              .text(m[e].replace(/-/g, ' ').toUpperCase());
        }
    }, 500);
    this.onmouseout = function () {
      d3.selectAll('.dollar').transition().style('fill', '#c1c1c1'),
        d3
          .select('.time-value')
          .transition()
          .style('fill', '#c1c1c1')
          .attr('width', '100%'),
        d3.select('.time-container p').remove(),
        d3.selectAll('.impact').transition().style('fill', '#c1c1c1'),
        d3.select('.impact-container p').remove(),
        d3.select('.topic-text').text('area').classed('hidden', !0),
        d3.select('.topic-angle').classed('hidden', !0),
        d3.select('.chart-title').text('title').classed('hidden', !0),
        d3.select('.chart-image').classed('hidden', !0),
        d3.select('.desc p').remove(),
        d3.select('.chart-icon').property('className', 'chart-icon hidden'),
        d3.selectAll('.who-icon').remove(),
        d3.selectAll('.hurdle-icon').remove(),
        clearTimeout(b);
    };
  },
  !1
);
var sticky = document.getElementById('framework-tool'),
  chart = document.getElementById('chart-filters'),
  origCoords;
setTimeout(function () {
  origCoords = offset(chart);
}, 10);
var stickyChart = debounce(function () {
  if (solutionDiv.clientHeight <= chart.clientHeight)
    return (
      sticky.className.indexOf('sticky') >= 0 &&
        (sticky.className = sticky.className.replace(' sticky', '')),
      !1
    );
  var a = offset(chart);
  sticky.className.indexOf('sticky') === -1
    ? a.top > a.elTop && (sticky.className += ' sticky')
    : a.elTop <= origCoords.elTop &&
      (sticky.className = sticky.className.replace(' sticky', ''));
}, 10);
(window.onscroll = stickyChart), jQuery('.select2-filter').select2();
var filters = jQuery('#filters'),
  costFilter = jQuery('#cost-filter'),
  timeFilter = jQuery('#time-filter'),
  impactFilter = jQuery('#impact-filter'),
  whoFilter = jQuery('.who'),
  typeFilter = jQuery('#type-filter'),
  subtypeFilter = jQuery('.subtype'),
  sort = jQuery('#sort'),
  reset = jQuery('#reset'),
  strategies = jQuery('.solution'),
  textFilter = jQuery('.text-filter'),
  whoOrig = whoFilter.val(),
  subtypeOrig = subtypeFilter.val();
jQuery('.filter-expand').on('click', function () {
  var a = jQuery(this);
  filters.slideToggle(),
    sort.slideToggle(),
    reset.slideToggle(),
    jQuery('#expand-icon').toggleClass('genericon-plus genericon-minus'),
    a.attr('aria-pressed')
      ? (a.attr('aria-pressed', 'true'),
        filters.attr('aria-expanded', 'true'),
        sort.attr('aria-hidden', 'false'),
        reset.attr('aria-hidden', 'false'))
      : (a.attr('aria-pressed', 'false'),
        filters.attr('aria-expanded', 'false'),
        sort.attr('aria-hidden', 'true'),
        reset.attr('aria-hidden', 'true'));
});
var filterFunc = function (a) {
  var b = [];
  (b =
    'LI' === a.target.nodeName ? jQuery(a.target) : jQuery(a.target).parent()),
    toggleActive(b);
  var c = filterValues();
  strategies.each(function () {
    var a = jQuery(this),
      b = a.data('cost'),
      d = a.data('time'),
      e = a.data('impact'),
      f = a.data('who'),
      g = a.data('category'),
      h = a.data('subcategory');
    phase = a.data('phase');
    var i = arrayIntersect(c.cost, b),
      j = arrayIntersect(c.impact, e),
      k = arrayIntersect(c.time, d),
      l = arrayIntersect(c.who, f),
      m = arrayIntersect(c.type, g),
      n = arrayIntersect(c.subtype, h),
      o = arrayIntersect(c.phase, phase),
      p = !0;
    'undefined' != typeof textFilter &&
      '' !== textFilter.val() &&
      a.data('title').toLowerCase().indexOf(textFilter.val().toLowerCase()) ===
        -1 &&
      (p = !1),
      console.log(a.data('title'), [i, j, k, l, m, n, o]),
      i.length &&
      j.length &&
      k.length &&
      l.length &&
      m.length &&
      n.length &&
      o.length &&
      p
        ? a.hasClass('hide') &&
          (a.removeClass('hide'), a.attr('aria-hidden', 'false'))
        : a.hasClass('hide') ||
          (a.addClass('hide'), a.attr('aria-hidden', 'true'));
  });
};
whoFilter.on('change', filterFunc),
  subtypeFilter.on('change', filterFunc),
  filters.on('click', filterFunc),
  textFilter.on('keyup', filterFunc),
  sort.on('click', function (a) {
    var b = [];
    (b =
      'LI' === a.target.nodeName
        ? jQuery(a.target)
        : jQuery(a.target).parent()),
      b.siblings().removeClass('active'),
      b
        .siblings()
        .children('.genericon')
        .removeClass('genericon-downarrow')
        .removeClass('genericon-uparrow');
    var c = toggleActive(b);
    c
      ? 'time' === b.data('sort')
        ? strategies.sort(function (a, b) {
            var c = strategy.timeNumSingle(
                JSON.parse(a.getAttribute('data-time'))
              ),
              d = strategy.timeNumSingle(
                JSON.parse(b.getAttribute('data-time'))
              ),
              e = a.getElementsByClassName('title'),
              f = b.getElementsByClassName('title');
            return (
              (e = e[0].innerText.toLowerCase()),
              (f = f[0].innerText.toLowerCase()),
              c === d
                ? e < f
                  ? -1
                  : e > f
                  ? 1
                  : 0
                : c < d
                ? -1
                : c > d
                ? 1
                : 0
            );
          })
        : 'cost' === b.data('sort')
        ? strategies.sort(function (a, b) {
            var c = strategy.costNumSingle(
                JSON.parse(a.getAttribute('data-cost'))
              ),
              d = strategy.costNumSingle(
                JSON.parse(b.getAttribute('data-cost'))
              ),
              e = a.getElementsByClassName('title'),
              f = b.getElementsByClassName('title');
            return (
              (e = e[0].innerText.toLowerCase()),
              (f = f[0].innerText.toLowerCase()),
              c === d
                ? e < f
                  ? -1
                  : e > f
                  ? 1
                  : 0
                : c < d
                ? -1
                : c > d
                ? 1
                : 0
            );
          })
        : 'type' === b.data('sort') &&
          strategies.sort(function (a, b) {
            var c = strategy.categoryFilter(a.getAttribute('data-category')),
              d = strategy.categoryFilter(b.getAttribute('data-category')),
              e = a.getElementsByClassName('title'),
              f = b.getElementsByClassName('title');
            return (
              (e = e[0].innerText.toLowerCase()),
              (f = f[0].innerText.toLowerCase()),
              c === d
                ? e < f
                  ? -1
                  : e > f
                  ? 1
                  : 0
                : c < d
                ? -1
                : c > d
                ? 1
                : 0
            );
          })
      : 'time' === b.data('sort')
      ? strategies.sort(function (a, b) {
          var c = strategy.timeNumSingle(
              JSON.parse(a.getAttribute('data-time'))
            ),
            d = strategy.timeNumSingle(JSON.parse(b.getAttribute('data-time'))),
            e = a.getElementsByClassName('title'),
            f = b.getElementsByClassName('title');
          return (
            (e = e[0].innerText.toLowerCase()),
            (f = f[0].innerText.toLowerCase()),
            c === d ? (e < f ? -1 : e > f ? 1 : 0) : c > d ? -1 : c < d ? 1 : 0
          );
        })
      : 'cost' === b.data('sort')
      ? strategies.sort(function (a, b) {
          var c = strategy.costNumSingle(
              JSON.parse(a.getAttribute('data-cost'))
            ),
            d = strategy.costNumSingle(JSON.parse(b.getAttribute('data-cost'))),
            e = a.getElementsByClassName('title'),
            f = b.getElementsByClassName('title');
          return (
            (e = e[0].innerText.toLowerCase()),
            (f = f[0].innerText.toLowerCase()),
            c === d ? (e < f ? -1 : e > f ? 1 : 0) : c > d ? -1 : c < d ? 1 : 0
          );
        })
      : 'type' === b.data('sort') &&
        strategies.sort(function (a, b) {
          var c = strategy.categoryFilter(a.getAttribute('data-category')),
            d = strategy.categoryFilter(b.getAttribute('data-category')),
            e = a.getElementsByClassName('title'),
            f = b.getElementsByClassName('title');
          return (
            (e = e[0].innerText.toLowerCase()),
            (f = f[0].innerText.toLowerCase()),
            c === d ? (e < f ? -1 : e > f ? 1 : 0) : c > d ? -1 : c < d ? 1 : 0
          );
        }),
      strategies.detach().appendTo(jQuery('#solutions'));
  }),
  reset.on('click', function () {
    filters.find('.button').each(function () {
      jQuery(this).addClass('active');
    }),
      strategies.each(function () {
        jQuery(this).removeClass('hide');
      }),
      whoFilter.val(whoOrig),
      subtypeFilter.val(subtypeOrig),
      jQuery('.select2-filter').select2();
  });
