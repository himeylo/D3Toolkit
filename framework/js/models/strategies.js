/* 
1. emissions
2. connectivity
3. healthy-destination
4. active-transport
5. green-space
6. contamination
7. violence
8. noise 
*/


var strategy = (function () {
  var color = function(c) {
    var colors = {
      2: "#eab840", // connectivity
      3: "#99331c", // healthy-destination
      1: "#0d2e5a", // congestion --> emissions
      6: "#734136", // contamination
      5: "#577120", // green-space
      4: "#e37a30", // active-transport
      7: "#2967a1", // violence
      8: "#ca624d" // noise
    };

    return colors[categoryFilter(c)];
  },

  category = function(s){
    var categories = {
      'emissions': 'Less Emissions',
      'connectivity': 'Connectivity and Inclusion',
      'healthy-destination': 'Healthy Destination',
      'active-transport': 'Active Transport',
      'green-space': 'Green Space',
      'contamination': 'Less Contamination',
      'violence': 'Less Traffic Violence',
      'noise': 'Less Traffic Noise'
    };

    return categories[s];
  },

  subcategory = function(s) {
    var subcategories = {
      'sustainability': 'Sustainability Strategies',
      'smart-growth': 'Smart Growth Strategies',
      'equity': 'Equity Strategies',
      'infrastructure-modification': 'Infrastructure Modification Strategies',
      'transportation-demand-management': 'Transportation Demand Management Strategies',
      'transportation-system-management': 'Transportation System Management Strategies'
    };

    if (typeof s === 'object') {
      return subcategories[s[s.length - 1]];
    }

    return subcategories[s];
  },

  phase = function(s) {
    var phases = {
      "policy-and-planning": "Policy and Planning",
      "project-development": "Project Development",
      "material-selection": "Material Selection",
      "construction": "Construction",
      "operations": "Operations",
      "maintenance": "Maintenance",
      "end-of-life": "End of Life"
    };

    if (typeof s === 'object') {
      return phases[s[s.length - 1]];
    }

    return phases[s];
  },

  who = function(s) {
    var whom = {
      "automakers": "Automakers",
      "automobile-repair-shops": "Automobile repair shops",
      "car-owners": "Car owners",
      "carsharing-and-ridesharing-apps": "Carsharing and ridesharing apps",
      "community": "Local Community",
      "construction-companies": "Construction companies",
      "drainage-engineers": "Drainage engineers",
      "employees": "Employees",
      "employers-and-employees": "Employers and employees",
      "farmers": "Farmers",
      "federal": "Federal Government Authorities",
      "federal-agencies": "Federal agencies",
      "fleet-managers": "Fleet managers",
      "healthcare-providers": "Healthcare providers",
      "law-enforcement": "Law enforcement",
      "local-businesses": "Local businesses",
      "local-governments": "Local governments",
      "local-health-departments": "Local health departments",
      "mpo": "MPOs",
      "ngo": "NGOs",
      "policymakers": "Policymakers",
      "private-developers": "Private developers",
      "school-boards": "School boards",
      "software-developers": "Software developers",
      "state-and-local": "State and Local Government Authorities",
      "state-governments": "State governments",
      "suppliers": "Suppliers",
      "technology-companies": "Technology companies",
      "transit-agencies": "Transit agencies",
      "vegetation-management-experts": "Vegetation management experts",
      "vulnerable-road-users": "Vulnerable road users",
      "waste-management-companies": "Waste management companies"
    };

    if (typeof s === 'object') {
      return whom[s[s.length - 1]];
    }

    return whom[s];
  },

  categoryFilter = function(t) {
    if (t.indexOf('connectivity') > -1 ) {
      return 2;
    }
    if (t.indexOf('healthy-destination') > -1) {
      return 3;
    }
    if (t.indexOf('active-transport') > -1) {
      return 4;
    }
    if (t.indexOf('green-space') > -1) {
      return 5;
    }
    if (t.indexOf('contamination') > -1) {
      return 6;
    }
    if (t.indexOf('violence') > -1) {
      return 7;
    }
    // if (t.indexOf('noise') > -1) {
    //   return 8;
    // }
    if (t.indexOf('emissions') > -1) {
      return 1;
    }
  };

  return {
    color: color,
    category: category,
    subcategory: subcategory,
    phase: phase,
    who: who,
    categoryFilter: categoryFilter
  };
})();
