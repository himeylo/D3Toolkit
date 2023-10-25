var cost = d3
  .select('.cost-container')
  .append('svg')
  .attr('class', 'cost three-fourths');

// low
cost
  .append('rect')
  .attr('class', 'dollar cost1')
  .attr('fill', '#c1c1c1')
  .attr('x', 0)
  .attr('y', '80%')
  .attr('width', '17%')
  .attr('height', '20%');

cost
  .append('svg:image')
  .attr(
    'xlink:href',
    '../../wp-content/plugins/d3-toolkit/framework/images/dollar-sign.svg'
  )
  .attr('x', 0)
  .attr('y', '80%')
  .attr('width', '17%')
  .attr('height', '20%');

// low moderate
cost
  .append('rect')
  .attr('class', 'dollar cost2')
  .attr('fill', '#c1c1c1')
  .attr('x', '21%')
  .attr('y', '60%')
  .attr('width', '18%')
  .attr('height', '40%');

cost
  .append('svg:image')
  .attr(
    'xlink:href',
    '../../wp-content/plugins/d3-toolkit/framework/images/dollar-sign.svg'
  )
  .attr('x', '21%')
  .attr('y', '65%')
  .attr('width', '18%')
  .attr('height', '30%');

// moderate
cost
  .append('rect')
  .attr('class', 'dollar cost3')
  .attr('fill', '#c1c1c1')
  .attr('x', '42%')
  .attr('y', '40%')
  .attr('width', '18%')
  .attr('height', '60%');

cost
  .append('svg:image')
  .attr(
    'xlink:href',
    '../../wp-content/plugins/d3-toolkit/framework/images/dollar-sign.svg'
  )
  .attr('x', '43%')
  .attr('y', '50%')
  .attr('width', '16%')
  .attr('height', '45%');

// moderate high
cost
  .append('rect')
  .attr('class', 'dollar cost4')
  .attr('fill', '#c1c1c1')
  .attr('x', '63%')
  .attr('y', '20%')
  .attr('width', '18%')
  .attr('height', '80%');

cost
  .append('svg:image')
  .attr(
    'xlink:href',
    '../../wp-content/plugins/d3-toolkit/framework/images/dollar-sign.svg'
  )
  .attr('x', '63%')
  .attr('y', '22%')
  .attr('width', '18%')
  .attr('height', '80%');

// high
cost
  .append('rect')
  .attr('class', 'dollar cost5')
  .attr('fill', '#c1c1c1')
  .attr('x', '84%')
  .attr('y', 0)
  .attr('width', '17%')
  .attr('height', '100%');

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
  .attr('height', 25);

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
  impactCont = d3.select('.impact-container');

var impact = impactCont.append('svg').attr('class', 'impact three-fourths');

if (!isNaN((impact.style('width').replace('px', '') / 2) * 0.9)) {
  impact.attr('height', (impact.style('width').replace('px', '') / 2) * 0.9);
}

// state
impact
  .append('circle')
  .attr('class', 'impact state')
  .attr('fill', '#c1c1c1')
  .attr('cx', ewidth)
  .attr('cy', eheight)
  .attr('r', rBase + 48 + '%');

// regional
impact
  .append('circle')
  .attr('fill', 'white')
  .attr('cx', ewidth)
  .attr('cy', eheight)
  .attr('r', rBase + 40 + '%');

impact
  .append('circle')
  .attr('class', 'impact regional')
  .attr('fill', '#c1c1c1')
  .attr('cx', ewidth)
  .attr('cy', eheight)
  .attr('r', rBase + 36 + '%');

// local
impact
  .append('circle')
  .attr('fill', 'white')
  .attr('cx', ewidth)
  .attr('cy', eheight)
  .attr('r', rBase + 28 + '%');

impact
  .append('circle')
  .attr('class', 'impact local')
  .attr('fill', '#c1c1c1')
  .attr('cx', ewidth)
  .attr('cy', eheight)
  .attr('r', rBase + 24 + '%');

// corridor
impact
  .append('circle')
  .attr('fill', 'white')
  .attr('cx', ewidth)
  .attr('cy', eheight)
  .attr('r', rBase + 16 + '%');

impact
  .append('circle')
  .attr('class', 'impact corridor')
  .attr('fill', '#c1c1c1')
  .attr('cx', ewidth)
  .attr('cy', eheight)
  .attr('r', rBase + 12 + '%');

// spot
impact
  .append('circle')
  .attr('fill', 'white')
  .attr('cx', ewidth)
  .attr('cy', eheight)
  .attr('r', rBase + 4 + '%');

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
  function (e) {
    if (typeof e.target.classList[1] === 'undefined') {
      return false;
    }
    var delay = setTimeout(function () {
      var id = e.target.classList[1];
      var strat = jQuery('.solution.' + id);

      // Set topic text.
      d3.select('.topic-text')
        .text(strategy.subcategory(strat.data('subcategory')))
        .classed('hidden', false);
      d3.select('.topic-angle').classed('hidden', false);

      // Set title.
      d3.select('.chart-title')
        .text(strat.data('title'))
        .classed('hidden', false);

      var chartIcon =
        typeof strat.data('category') !== 'undefined'
          ? strat.data('category').join(' ')
          : '';
      // Set icon class.
      d3.select('.chart-icon')
        .classed('hidden', false)
        .classed(chartIcon, true);

      // Set image.
      d3.select('.chart-image')
        .attr('src', strat.data('chart-img'))
        .classed('hidden', false);
      if (strat.data('desc') !== '') {
        d3.select('.desc').append('p').text(strat.data('desc'));
      }

      // Change cost color.
      for (var i = 1; i <= 5; i++) {
        var d3Cost = d3.select('.cost' + i);
        if (i <= strategy.costNumSingle(strat.data('cost'))) {
          d3Cost
            .transition()
            .style('fill', strategy.color(strat.data('category')));
        } else {
          d3Cost.transition().style('fill', '#c1c1c1');
        }
      }

      // Change time color.
      var d3Time = d3.select('.time-value'),
        timeCont = d3.select('.time-container');

      if (strategy.timeNumSingle(strat.data('time')) === 0) {
        timeCont.append('p').text(strategy.timeText(strat.data('time')));
      } else if (strategy.timeNumSingle(strat.data('time')) === 1) {
        d3Time
          .transition()
          .attr('width', '10%')
          .style('fill', strategy.color(strat.data('category')));
        timeCont.append('p').text(strategy.timeText(strat.data('time')));
      } else if (strategy.timeNumSingle(strat.data('time')) === 2) {
        d3Time
          .transition()
          .attr('width', '20%')
          .style('fill', strategy.color(strat.data('category')));
        timeCont.append('p').text(strategy.timeText(strat.data('time')));
      } else if (strategy.timeNumSingle(strat.data('time')) === 3) {
        d3Time
          .transition()
          .attr('width', '60%')
          .style('fill', strategy.color(strat.data('category')));
        timeCont.append('p').text(strategy.timeText(strat.data('time')));
      } else if (strategy.timeNumSingle(strat.data('time')) === 4) {
        d3Time
          .transition()
          .attr('width', '80%')
          .style('fill', strategy.color(strat.data('category')));
        timeCont.append('p').text(strategy.timeText(strat.data('time')));
      } else if (strategy.timeNumSingle(strat.data('time')) === 5) {
        d3Time
          .transition()
          .attr('width', '100%')
          .style('fill', strategy.color(strat.data('category')));
        timeCont.append('p').text(strategy.timeText(strat.data('time')));
      }

      // Change impact color.
      var impacts = strat.data('impact');
      var impactCount = impacts.length,
        impactCont = d3.select('.impact-container');

      for (i = 0; i < impactCount; i++) {
        d3.select('.' + impacts[i].toLowerCase())
          .transition()
          .style('fill', strategy.color(strat.data('category')));
      }

      // Add impact text.
      impactCont.append('p').text(strategy.impactText(strat.data('impact')));

      // Add who icons & text.
      var who = strat.data('who'),
        hurdle = strat.data('hurdle');
      var whoCount = who.length,
        whoCont = d3.select('.who-container'),
        hurdleCount = hurdle.length,
        hurdleCont = d3.select('.hurdles-container');

      for (i = 0; i < whoCount; i++) {
        if (who[i] !== 'none') {
          var divW = whoCont.append('div').attr('class', 'who-icon');
          divW
            .append('img')
            .attr(
              'src',
              '../../wp-content/plugins/d3-toolkit/framework/who-hurdle-icons/' +
                who[i] +
                '.svg'
            )
            .attr('class', 'who-hurdle-icon');
          divW
            .append('p')
            .attr('class', strat.data('category'))
            .text(who[i].replace(/-/g, ' ').toUpperCase());
        }
      }

      // Add hurdle icons & text.
      for (i = 0; i < hurdleCount; i++) {
        if (hurdle[i] !== 'none') {
          var divH = hurdleCont.append('div').attr('class', 'hurdle-icon');
          divH
            .append('img')
            .attr(
              'src',
              '../../wp-content/plugins/d3-toolkit/framework/who-hurdle-icons/' +
                hurdle[i] +
                '.svg'
            )
            .attr('class', 'who-hurdle-icon');
          divH
            .append('p')
            .attr('class', strat.data('category'))
            .text(hurdle[i].replace(/-/g, ' ').toUpperCase());
        }
      }
    }, 500);

    // Reset colors.
    this.onmouseout = function () {
      d3.selectAll('.dollar').transition().style('fill', '#c1c1c1');
      d3.select('.time-value')
        .transition()
        .style('fill', '#c1c1c1')
        .attr('width', '100%');
      d3.select('.time-container p').remove();
      d3.selectAll('.impact').transition().style('fill', '#c1c1c1');
      d3.select('.impact-container p').remove();
      d3.select('.topic-text').text('area').classed('hidden', true);
      d3.select('.topic-angle').classed('hidden', true);
      d3.select('.chart-title').text('title').classed('hidden', true);
      d3.select('.chart-image').classed('hidden', true);
      d3.select('.desc p').remove();
      d3.select('.chart-icon').property('className', 'chart-icon hidden');
      d3.selectAll('.who-icon').remove();
      d3.selectAll('.hurdle-icon').remove();
      clearTimeout(delay);
    };
  },
  false
);

var sticky = document.getElementById('framework-tool'),
  chart = document.getElementById('chart-filters'),
  origCoords;

setTimeout(function () {
  origCoords = offset(chart);
}, 10);

function offset(el) {
  var rect = el.getBoundingClientRect(),
    scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
    scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  return {
    elTop: rect.top + scrollTop,
    elLeft: rect.left + scrollLeft,
    top: scrollTop,
    left: scrollLeft
  };
}

function debounce(callback, wait) {
  var time;
  return function () {
    clearTimeout(time);
    time = setTimeout(function () {
      time = null;
      callback.call();
    }, wait);
  };
}

var stickyChart = debounce(function () {
  if (solutionDiv.clientHeight <= chart.clientHeight) {
    if (sticky.className.indexOf('sticky') >= 0) {
      sticky.className = sticky.className.replace(' sticky', '');
    }

    return false;
  }

  var coords = offset(chart);

  if (sticky.className.indexOf('sticky') === -1) {
    if (coords.top > coords.elTop) {
      sticky.className += ' sticky';
    }
  } else if (coords.elTop <= origCoords.elTop) {
    sticky.className = sticky.className.replace(' sticky', '');
  }
}, 10);

window.onscroll = stickyChart;
