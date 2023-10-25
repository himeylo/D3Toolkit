jQuery('.select2-filter').select2();

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
    textFilter = jQuery('.text-filter');

var whoOrig = whoFilter.val(),
    subtypeOrig = subtypeFilter.val();

jQuery('.filter-expand').on('click', function() {
  var $this = jQuery(this);
  filters.slideToggle();
  sort.slideToggle();
  reset.slideToggle();
  jQuery('#expand-icon').toggleClass('genericon-plus genericon-minus');

  if ($this.attr('aria-pressed')) {
    $this.attr('aria-pressed', 'true');
    filters.attr('aria-expanded', 'true');
    sort.attr('aria-hidden', 'false');
    reset.attr('aria-hidden', 'false');
  } else {
    $this.attr('aria-pressed', 'false');
    filters.attr('aria-expanded', 'false');
    sort.attr('aria-hidden', 'true');
    reset.attr('aria-hidden', 'true');
  }
});

var filterFunc = function(e) {
  var target = [];

  if (e.target.nodeName === 'LI') {
    target = jQuery(e.target);
  } else {
    target = jQuery(e.target).parent();
  }

  toggleActive(target);

  var values = filterValues();

  strategies.each(function() {
    var $this = jQuery(this);

    var cost = $this.data('cost'),
        time = $this.data('time'),
        impact = $this.data('impact'),
        who = $this.data('who'),
        type = $this.data('category'),
        subtype = $this.data('subcategory');
        phase = $this.data('phase');

    var costIntersect = arrayIntersect(values.cost, cost),
        impactIntersect = arrayIntersect(values.impact, impact),
        timeIntersect = arrayIntersect(values.time, time),
        whoIntersect = arrayIntersect(values.who, who),
        typeIntersect = arrayIntersect(values.type, type),
        subtypeIntersect = arrayIntersect(values.subtype, subtype),
        phaseIntersect = arrayIntersect(values.phase, phase),
        textVal = true;

    if (typeof textFilter !== 'undefined' && textFilter.val() !== '') {
      if ($this.data('title').toLowerCase().indexOf(textFilter.val().toLowerCase()) === -1) {
        textVal = false;
      }
    }
    console.log($this.data('title'), [costIntersect, impactIntersect, timeIntersect, whoIntersect, typeIntersect, subtypeIntersect, phaseIntersect]);
    if (costIntersect.length && impactIntersect.length && timeIntersect.length && whoIntersect.length && typeIntersect.length && subtypeIntersect.length && phaseIntersect.length && textVal) {
      if ($this.hasClass('hide')) {
        $this.removeClass('hide');
        $this.attr('aria-hidden', 'false');
      }
    } else {
      if (!$this.hasClass('hide')) {
        $this.addClass('hide');
        $this.attr('aria-hidden', 'true');
      }
    }
  });
};

whoFilter.on('change', filterFunc);
subtypeFilter.on('change', filterFunc);
filters.on('click', filterFunc);
textFilter.on('keyup', filterFunc);

sort.on('click', function(e) {
  var target = [];

  if (e.target.nodeName === 'LI') {
    target = jQuery(e.target);
  } else {
    target = jQuery(e.target).parent();
  }

  target.siblings().removeClass('active');
  target.siblings().children('.genericon').removeClass('genericon-downarrow').removeClass('genericon-uparrow');
  var toggle = toggleActive(target);

  if (toggle) {
    if (target.data('sort') === 'time') {
      strategies.sort(function(a, b) {
        var an = strategy.timeNumSingle(JSON.parse(a.getAttribute('data-time'))),
            bn = strategy.timeNumSingle(JSON.parse(b.getAttribute('data-time'))),
            aTitle = a.getElementsByClassName('title'),
            bTitle = b.getElementsByClassName('title');

        aTitle = aTitle[0].innerText.toLowerCase();
        bTitle = bTitle[0].innerText.toLowerCase();

        if (an === bn) {
          return (aTitle < bTitle) ? -1 : (aTitle > bTitle) ? 1 : 0;
        } else {
          return ((an < bn) ? -1 : ((an > bn) ? 1 : 0));
        }
      });
    } else if (target.data('sort') === 'cost') {
      strategies.sort(function(a, b) {
        var an = strategy.costNumSingle(JSON.parse(a.getAttribute('data-cost'))),
            bn = strategy.costNumSingle(JSON.parse(b.getAttribute('data-cost'))),
            aTitle = a.getElementsByClassName('title'),
            bTitle = b.getElementsByClassName('title');

        aTitle = aTitle[0].innerText.toLowerCase();
        bTitle = bTitle[0].innerText.toLowerCase();

        if (an === bn) {
          return (aTitle < bTitle) ? -1 : (aTitle > bTitle) ? 1 : 0;
        } else {
          return ((an < bn) ? -1 : ((an > bn) ? 1 : 0));
        }
      });
    } else if (target.data('sort') === 'type') {
      strategies.sort(function(a, b) {
        var an = strategy.categoryFilter(a.getAttribute('data-category')),
            bn = strategy.categoryFilter(b.getAttribute('data-category')),
            aTitle = a.getElementsByClassName('title'),
            bTitle = b.getElementsByClassName('title');

        aTitle = aTitle[0].innerText.toLowerCase();
        bTitle = bTitle[0].innerText.toLowerCase();

        if (an === bn) {
          return (aTitle < bTitle) ? -1 : (aTitle > bTitle) ? 1 : 0;
        } else {
          return ((an < bn) ? -1 : ((an > bn) ? 1 : 0));
        }
      });
    }
  } else {
    if (target.data('sort') === 'time') {
      strategies.sort(function(a, b) {
        var an = strategy.timeNumSingle(JSON.parse(a.getAttribute('data-time'))),
            bn = strategy.timeNumSingle(JSON.parse(b.getAttribute('data-time'))),
            aTitle = a.getElementsByClassName('title'),
            bTitle = b.getElementsByClassName('title');

        aTitle = aTitle[0].innerText.toLowerCase();
        bTitle = bTitle[0].innerText.toLowerCase();

        if (an === bn) {
          return (aTitle < bTitle) ? -1 : (aTitle > bTitle) ? 1 : 0;
        } else {
          return ((an > bn) ? -1 : ((an < bn) ? 1 : 0));
        }
      });
    } else if (target.data('sort') === 'cost') {
      strategies.sort(function(a, b) {
        var an = strategy.costNumSingle(JSON.parse(a.getAttribute('data-cost'))),
            bn = strategy.costNumSingle(JSON.parse(b.getAttribute('data-cost'))),
            aTitle = a.getElementsByClassName('title'),
            bTitle = b.getElementsByClassName('title');

        aTitle = aTitle[0].innerText.toLowerCase();
        bTitle = bTitle[0].innerText.toLowerCase();

        if (an === bn) {
          return (aTitle < bTitle) ? -1 : (aTitle > bTitle) ? 1 : 0;
        } else {
          return ((an > bn) ? -1 : ((an < bn) ? 1 : 0));
        }
      });
    } else if (target.data('sort') === 'type') {
      strategies.sort(function(a, b) {
        var an = strategy.categoryFilter(a.getAttribute('data-category')),
            bn = strategy.categoryFilter(b.getAttribute('data-category')),
            aTitle = a.getElementsByClassName('title'),
            bTitle = b.getElementsByClassName('title');

        aTitle = aTitle[0].innerText.toLowerCase();
        bTitle = bTitle[0].innerText.toLowerCase();

        if (an === bn) {
          return (aTitle < bTitle) ? -1 : (aTitle > bTitle) ? 1 : 0;
        } else {
          return ((an > bn) ? -1 : ((an < bn) ? 1 : 0));
        }
      });
    }
  }

  strategies.detach().appendTo(jQuery('#solutions'));
});

reset.on('click', function() {
  filters.find('.button').each(function() {
    jQuery(this).addClass('active');
  });
  strategies.each(function() {
    jQuery(this).removeClass('hide');
  });

  whoFilter.val(whoOrig);
  subtypeFilter.val(subtypeOrig);
  jQuery('.select2-filter').select2();
});

function toggleActive(target) {
  if (!target.hasClass('active')) {
    target.addClass('active');
    target.attr('aria-pressed', 'true');

    if (!target.children('.genericon').hasClass('genericon-uparrow') && !target.children('.genericon').hasClass('genericon-downarrow') && target.hasClass('sort-button')) {
      target.children('.genericon').toggleClass('genericon-uparrow');
    } else if (target.hasClass('sort-button')) {
      target.children('.genericon').toggleClass('genericon-uparrow').toggleClass('genericon-downarrow');
    }

    if (!target.hasClass('sort-button')) {
      target.children('span.genericon').toggleClass('genericon-close').toggleClass('genericon-plus');
    }

    return true;
  } else {
    target.removeClass('active');
    target.attr('aria-pressed', 'false');

    if (target.hasClass('sort-button')) {
      target.children('.genericon').toggleClass('genericon-downarrow').toggleClass('genericon-uparrow');
    }

    if (!target.hasClass('sort-button')) {
      target.children('span.genericon').toggleClass('genericon-close').toggleClass('genericon-plus');
    }

    return false;
  }
}

function filterValues() {
  var values = {
    cost: [],
    time: [],
    impact: [],
    who: [],
    type: [],
    subtype: [],
    objective: [],
    phase: []
  };

  var costFilterChildren = costFilter.children();
  for (var i = 0; i < costFilterChildren.length; i++) {
    if (costFilterChildren[i].className.indexOf('active') > -1) {
      values.cost.push(costFilterChildren[i].getAttribute('data-value'));
    }
  }

  var timeFilterChildren = timeFilter.children();
  for (i = 0; i < timeFilterChildren.length; i++) {
    if (timeFilterChildren[i].className.indexOf('active') > -1) {
      values.time.push(timeFilterChildren[i].getAttribute('data-value'));
    }
  }

  var impactFilterChildren = impactFilter.children();
  for (i = 0; i < impactFilterChildren.length; i++) {
    if (impactFilterChildren[i].className.indexOf('active') > -1) {
      values.impact.push(impactFilterChildren[i].getAttribute('data-value'));
    }
  }

  var typeFilterChildren = typeFilter.children();
  for (i = 0; i < typeFilterChildren.length; i++) {
    if (typeFilterChildren[i].className.indexOf('active') > -1) {
      values.type.push(typeFilterChildren[i].getAttribute('data-value'));
    }
  }

  var phaseFilterChildren = phaseFilter.children();
  for (i = 0; i < phaseFilterChildren.length; i++) {
    if (phaseFilterChildren[i].className.indexOf('active') > -1) {
      values.phase.push(phaseFilterChildren[i].getAttribute('data-value'));
    }
  }

  values.who = whoFilter.val();
  values.subtype = subtypeFilter.val();
  values.phase = phaseFilter.val();

  return values;
}

function arrayIntersect (a, b) {
  if (a === undefined || a === null) {
    return [];
  }

  return jQuery.grep(a, function(i) {
    return jQuery.inArray(i, b) > -1;
  });
}
