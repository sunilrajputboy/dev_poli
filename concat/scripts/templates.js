this["Polimapper"] = this["Polimapper"] || {};
this["Polimapper"]["templates"] = this["Polimapper"]["templates"] || {};

this["Polimapper"]["templates"]["src/templates/bigNumber.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  	<div class=\"result "
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showGraph : depth0),{"name":"if","hash":{},"fn":this.program(2, data, 0),"inverse":this.program(4, data, 0),"data":data})) != null ? stack1 : "")
    + "\">\n"
    + ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.icons : depth0),{"name":"each","hash":{},"fn":this.program(6, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.value : depth0),{"name":"if","hash":{},"fn":this.program(9, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n      <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showGraph : depth0),{"name":"if","hash":{},"fn":this.program(12, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "    </div>\n";
},"2":function(depth0,helpers,partials,data) {
    return "col-md-12";
},"4":function(depth0,helpers,partials,data) {
    return " result_graph col-xs-12 col-sm-12 ";
},"6":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,depth0,{"name":"if","hash":{},"fn":this.program(7, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "");
},"7":function(depth0,helpers,partials,data) {
    var helper, alias1=this.escapeExpression, alias2=helpers.helperMissing, alias3="function";

  return "          <span class=\"icon "
    + alias1(this.lambda(depth0, depth0))
    + "\" style=\"color: "
    + alias1(((helper = (helper = helpers.color || (depth0 != null ? depth0.color : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"color","hash":{},"data":data}) : helper)))
    + ";\" title=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\">\n          </span>\n";
},"9":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "    	  <h3 class=\"v\"><span>"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.total : depth0),{"name":"if","hash":{},"fn":this.program(10, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + alias3(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + "</span><span class=\"pretty-number\">"
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "</span></h3>\n";
},"10":function(depth0,helpers,partials,data) {
    return "<span class=\"xs\">Total </span>";
},"12":function(depth0,helpers,partials,data) {
    var stack1, helper;

  return ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.legend : depth0),{"name":"if","hash":{},"fn":this.program(13, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "        <canvas id=\""
    + this.escapeExpression(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\" width=\"400%\" height=\"150%\"></canvas>\n";
},"13":function(depth0,helpers,partials,data) {
    var stack1, helper;

  return "          <div class=\"graph-legend\">\n            "
    + ((stack1 = ((helper = (helper = helpers.legendHtml || (depth0 != null ? depth0.legendHtml : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"legendHtml","hash":{},"data":data}) : helper))) != null ? stack1 : "")
    + "\n          </div>\n";
},"15":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "    <div class=\"result result_graph col-xs-12 col-sm-12\">\n"
    + ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.icons : depth0),{"name":"each","hash":{},"fn":this.program(16, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "    	<h3 class=\"v\"><span>"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.total : depth0),{"name":"if","hash":{},"fn":this.program(10, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + alias3(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + "</span><span class=\"pretty-number\">"
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "</span></h3>\n      <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showGraph : depth0),{"name":"if","hash":{},"fn":this.program(18, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "    </div>\n";
},"16":function(depth0,helpers,partials,data) {
    var helper, alias1=this.escapeExpression, alias2=helpers.helperMissing, alias3="function";

  return "        <span class=\"icon "
    + alias1(this.lambda(depth0, depth0))
    + "\" style=\"color: "
    + alias1(((helper = (helper = helpers.color || (depth0 != null ? depth0.color : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"color","hash":{},"data":data}) : helper)))
    + ";\" title=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\">\n        </span>\n";
},"18":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.legend : depth0),{"name":"if","hash":{},"fn":this.program(13, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "        <canvas id=\""
    + alias3(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\" width=\"400%\" height=\"200%\"></canvas>\n        <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.program(15, data, 0),"data":data})) != null ? stack1 : "");
},"useData":true});

this["Polimapper"]["templates"]["src/templates/bigNumberNode.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  	<div class=\"result col-md-12\">\n"
    + ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.icons : depth0),{"name":"each","hash":{},"fn":this.program(2, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.value : depth0),{"name":"if","hash":{},"fn":this.program(5, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.legend : depth0),{"name":"if","hash":{},"fn":this.program(8, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <canvas id=\""
    + alias3(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\" width=\"400%\" height=\"150%\"></canvas>\n    </div>\n";
},"2":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,depth0,{"name":"if","hash":{},"fn":this.program(3, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "");
},"3":function(depth0,helpers,partials,data) {
    var helper, alias1=this.escapeExpression, alias2=helpers.helperMissing, alias3="function";

  return "          <span class=\"icon "
    + alias1(this.lambda(depth0, depth0))
    + "\" style=\"color: "
    + alias1(((helper = (helper = helpers.color || (depth0 != null ? depth0.color : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"color","hash":{},"data":data}) : helper)))
    + ";\" title=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\">\n          </span>\n";
},"5":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "    	  <h3 class=\"v\"><span>"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.total : depth0),{"name":"if","hash":{},"fn":this.program(6, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + alias3(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + "</span><span class=\"pretty-number\">"
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "</span> <span class=\"n\">in "
    + alias3(((helper = (helper = helpers.node || (depth0 != null ? depth0.node : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"node","hash":{},"data":data}) : helper)))
    + "</span></h3>\n";
},"6":function(depth0,helpers,partials,data) {
    return "<span class=\"xs\">Total </span>";
},"8":function(depth0,helpers,partials,data) {
    var stack1, helper;

  return "        <div class=\"graph-legend\">\n          "
    + ((stack1 = ((helper = (helper = helpers.legendHtml || (depth0 != null ? depth0.legendHtml : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"legendHtml","hash":{},"data":data}) : helper))) != null ? stack1 : "")
    + "\n        </div>\n";
},"10":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "    <div class=\"result result_graph col-xs-12 col-sm-12\">\n"
    + ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.icons : depth0),{"name":"each","hash":{},"fn":this.program(11, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n    	<h3 class=\"v\"><span>"
    + alias3(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + "</span><span class=\"pretty-number\">"
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + " </span> <span class=\"n\">in "
    + alias3(((helper = (helper = helpers.node || (depth0 != null ? depth0.node : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"node","hash":{},"data":data}) : helper)))
    + "</span></h3>\n\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.legend : depth0),{"name":"if","hash":{},"fn":this.program(8, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <canvas id=\""
    + alias3(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\" width=\"400%\" height=\"200%\"></canvas>\n      <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>\n    </div>\n";
},"11":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,depth0,{"name":"if","hash":{},"fn":this.program(12, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "");
},"12":function(depth0,helpers,partials,data) {
    var helper, alias1=this.escapeExpression, alias2=helpers.helperMissing, alias3="function";

  return "        <span class=\"icon "
    + alias1(this.lambda(depth0, depth0))
    + "\" style=\"color: "
    + alias1(((helper = (helper = helpers.color || (depth0 != null ? depth0.color : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"color","hash":{},"data":data}) : helper)))
    + ";\" title=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\">\n        </span>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.program(10, data, 0),"data":data})) != null ? stack1 : "");
},"useData":true});

this["Polimapper"]["templates"]["src/templates/datafields.handlebars"] = Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "<option data-name=\""
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "\" data-field-name=\""
    + alias3(((helper = (helper = helpers.fieldName || (depth0 != null ? depth0.fieldName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"fieldName","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "\" value=\""
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "\">\n    "
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + " </option>";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/desktopLayout.handlebars"] = Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "<div class=\"polimapper\">\n  <div class=\"topbar\">\n    <div class=\"container-fluid\">\n      <div class=\"custom-topbar\">\n        <div class=\"logo-sec\">\n          <a href=\"\" onclick=\"goBack()\">\n            <img class=\"logo\" src=\"img/polimapper-logo.jpg\" alt=\"Interactive Infographic\">\n          </a>\n        </div>\n        <div class=\"group-dropdown searchbox\">\n          <select name=\"\" id=\"select_group\">\n            <option selected disabled  value=\"\">Select a project</option>\n          </select>\n        </div>\n        <div class=\"searchbox postcodea\">\n          <select name=\"constituency\" form=\"\" id=\"sel_con\">\n          </select>\n        </div>\n        <div class=\"topbar-right\">\n          <div id=\"is_social_share\" class=\"social\">\n            <a id=\"is_email_friend\" class=\"sbm-email\" href=\"JavaScript:void(0);\">\n              <i class=\"fas fa-envelope\"></i>\n            </a>\n            <a href=\"JavaScript:void(0);\"  onclick=\"window.print()\">\n             <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"46.782\" height=\"46.258\" viewBox=\"0 0 46.782 46.258\"><g transform=\"translate(-757.197 -339.415)\"><g transform=\"translate(757.197 339.415)\"><g transform=\"translate(0 0)\"><path d=\"M793.242,385.672H767.921a2.087,2.087,0,0,1-1.275-2.267c.046-.822.009-1.648.009-2.473V377.5h-3.782a5.565,5.565,0,0,1-5.647-5.542q-.057-7.391,0-14.782a5.579,5.579,0,0,1,5.481-5.542c1.3-.042,2.6-.007,3.947-.007v-.692q0-4.745,0-9.491a1.8,1.8,0,0,1,2.019-2.028q11.909-.008,23.819,0a1.781,1.781,0,0,1,2.013,2.02q0,4.774,0,9.548v.643c1.372,0,2.656-.035,3.938.007a5.568,5.568,0,0,1,5.508,5.572q.05,7.362,0,14.725a5.558,5.558,0,0,1-5.675,5.569h-3.771v.622c0,1.783-.036,3.567.014,5.349A2.054,2.054,0,0,1,793.242,385.672Zm1.266-11.622h3.484a2.213,2.213,0,0,0,2.52-2.542q0-6.932,0-13.865a2.255,2.255,0,0,0-2.572-2.578q-17.35,0-34.7,0a2.274,2.274,0,0,0-2.579,2.578q0,5.063,0,10.125c0,1.381-.014,2.762.012,4.142a2.009,2.009,0,0,0,1.716,2.077c1.4.108,2.819.027,4.266.027v-.664c0-2.627,0-5.254,0-7.882a1.773,1.773,0,0,1,1.943-1.983q12-.009,24,0a1.747,1.747,0,0,1,1.911,1.944q0,3.969,0,7.939Zm-3.484,8.144v-15.22H770.138V382.2Zm0-39.287H770.153v8.676h20.875Z\" transform=\"translate(-757.197 -339.415)\" fill=\"#000\"/><path d=\"M870.668,498.965a1.676,1.676,0,0,1-1.7,1.707,1.706,1.706,0,0,1-1.739-1.688,1.729,1.729,0,0,1,1.749-1.744A1.692,1.692,0,0,1,870.668,498.965Z\" transform=\"translate(-854.535 -479.039)\" fill=\"#000\"/><path d=\"M825.022,500.673a1.706,1.706,0,0,1-1.707-1.718,1.728,1.728,0,0,1,1.719-1.714A1.707,1.707,0,0,1,826.758,499,1.689,1.689,0,0,1,825.022,500.673Z\" transform=\"translate(-815.69 -479.039)\" fill=\"#000\"/><path d=\"M894.7,608.243q-3.308,0-6.616,0a1.73,1.73,0,0,1-1.9-1.655,1.754,1.754,0,0,1,1.843-1.789q6.674-.024,13.347,0a1.727,1.727,0,1,1-.061,3.443Q898.006,608.246,894.7,608.243Z\" transform=\"translate(-871.308 -574.182)\" fill=\"#000\"/><path d=\"M894.654,661.124q-3.279,0-6.559,0a1.732,1.732,0,0,1-1.908-1.7,1.753,1.753,0,0,1,1.834-1.741q6.674-.025,13.348,0a1.727,1.727,0,1,1-.041,3.443Q897.99,661.127,894.654,661.124Z\" transform=\"translate(-871.311 -620.965)\" fill=\"#000\"/></g></g></g></svg>\n            </a>\n            <a id=\"is_facebook_modal\" href=\"\" target=\"_blank\">\n              <i class=\"fab fa-facebook\"></i>\n            </a>\n            <input type=\"hidden\" id=\"is_facebook\" value=\"\">\n            <a id=\"is_twitter_modal\" class=\"\" href=\"\">\n              <i class=\"fab fa-twitter\"></i>\n            </a>\n            <input type=\"hidden\" id=\"is_twitter\" value=\"\">\n            <input type=\"hidden\" id=\"is_linkedin\" value=\"\">\n            <a id=\"is_linkedin_modal\" href=\"\">\n              <i class=\"fab fa-linkedin\"></i>\n            </a>\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n  <div class=\"app_wrapper\">\n    <div class=\"container-fluid\">\n      <div class=\"row map-section map-desktop\">\n        <div id=\"data\" class=\"data col-md-6\">\n          <div class=\"showmap\"><img class=\"\" src=\""
    + alias3(((helper = (helper = helpers.resourcePrefix || (depth0 != null ? depth0.resourcePrefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"resourcePrefix","hash":{},"data":data}) : helper)))
    + "img/map.png\" /><span>SHOW MAP</span></div>\n          <div class=\"results\">\n            <div class=\"totals\">\n              <h2 id=\"name\"></h2>\n              <div id=\"description\"> </div>\n            </div>\n          </div>\n         <div class=\"node-description-wraper\">\n          <div class=\"node_description\">\n          </div>\n        </div>\n\n        </div>\n        <div class=\"map col-md-6\">\n          <div class=\"optionsa map-option\">\n            <div id=\"buttons\" class=\"buttons\">\n              <span class=\"zoom-in\">\n                <i class=\"fas fa-search-plus\"></i>\n              </span>\n              <span class=\"zoom-out\">\n                <i class=\"fas fa-search-minus\"></i>\n              </span>\n            </div>\n            <div id=\"data_selector\" class=\"text searchbox\">\n              <span class=\"select-datafield\">Select a datafield </span>\n              <label class=\"select-wrapper\">\n                <select name=\"dataFields\" form=\"\" id=\"data_con\">\n                </select>\n                <i class=\"fas fa-angle-down\"></i>\n              </label>\n            </div>\n            <span id=\"undefined\" style=\"display: none;\"></span>\n          </div>\n          <div class=\"showmap\"><img class=\"\" src=\""
    + alias3(((helper = (helper = helpers.resourcePrefix || (depth0 != null ? depth0.resourcePrefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"resourcePrefix","hash":{},"data":data}) : helper)))
    + "img/map.png\" /><span>HIDE MAP</span></div>\n          <div class=\"legend\">\n            <div class=\"dtfield\">\n              <h5 id=\"c_field\"></h5>\n              <h5>Map key</h5>\n            </div>\n            <div class=\"map-key\">\n            </div>\n            <div class=\"key\">\n            </div>\n          </div>\n          <div id=\"cons_name_overlay\"></div>\n          <div class=\"svg_wrapper\">\n            <!-- Insert SVG XML here -->\n          </div>\n          <div class=\"lightbox\" id=\"con_over\">\n            <div id=\"overlay\" class=\"modal-map\">\n            \n            <ul class=\"postal-wrapper\">\n              <li>\n                <span>Postal District:</span>\n                </li>\n                <li>\n                <span>Postal Town:</span></li>\n                <li><span>UK Region:</span></li> \n              </li>\n            </ul>\n              <svg width=\"100%\" version=\"1.1\">\n                <g id=\"ov_c\" x=\"0\" y=\"0\"> </g>\n              </svg>\n              <h3 id=\"con_name\"></h3>\n              <h4 id=\"ranking_title\"> </h4>\n              <div id=\"rankings\"></div>\n              <div class=\"modal-map-legend\">\n                <div class=\"left-box\"></div>\n                <div class=\"legend-desc\">\n                  <p id=\"mp_name\" class=\"mp-name\">Mp Name</p>\n                  <p class=\"link-bio\"><a id=\"mp_profile_url\" href=\"\" target=\"_blank\">Link to bio</a></p>\n                  <p id=\"email_mp_share\" class=\"email-mp c-pointer\">Email MP</p>\n                  <p id=\"email_mp_tweet\" class=\"tweet-mp sbm-twitter c-pointer\">Tweet MP</p>\n                  <p id=\"not_on_twitter\" style=\"cursor: no-drop;\"></p>\n                </div>\n              </div>\n            </div>\n          </div>\n          <div class=\"closes cus-close\" style=\"display: none;\">\n          <a href=\"\">Back to UK map</a>\n        </div>\n        </div>\n        \n      </div>\n    </div>\n    <div class=\"graph-section node-wrap\">\n      <div class=\"container-fluid\">\n        <div class=\"row graph-wrapper\">\n        </div>\n      </div>\n    </div>\n    <div class=\"graph-section footer-area\">\n      <div class=\"row\">\n        <div class=\"col-md-12\">\n          <ul class=\"social-link\">\n            <li>\n              <a href=\"\">Privacy policy</a>\n            </li>\n            <li>\n              <a href=\"JavaScript:void(0);\">\n                <span class=\"licensing\" data-toggle=\"modal\" data-target=\"#licensingModal\"> Licensing</span>\n              </a>\n            </li>\n          </ul>\n        </div>\n      </div>\n      <div class=\"row\">\n        <div class=\"com-md-12\">\n          <div class=\"footer-logo\">\n            <a href=\"\">\n              <img src=\"img/footer-logo.png\" alt=\"\">\n            </a>\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n  <div id=\"offline\" class=\"modal\">\n    <div class=\"modal-dialog modal-md\">\n      <span class=\"close\">X</span>\n      <h2>You are working offline</h2>\n    </div>\n  </div>\n  <div id=\"offline2\" class=\"modal\">\n    <div class=\"modal-dialog modal-md\">\n      <span class=\"close\">X</span>\n      <h2>This feature is not available in offline mode</h2>\n    </div>\n  </div>\n  <div id=\"myModal\" class=\"modal\">\n    <div class=\"modal-dialog modal-md\">\n      <span class=\"close\">X</span>\n      <h2>How to use this map</h2>\n      <p>You can use this map to view macro trends or to find information specific to a geographical location. Click on\n        the icons\n        in the top-right hand corner of the map to review macro trends across different data.</p>\n      <p>There are three ways to find the data for a specific geographical location.</p>\n      <ul>\n        <li>i) Hover over the map to reveal the location's name. When you find your location double click to access the\n          location-specific data.</li>\n        <li>ii) Alternatively use the location drop-down box which lists geographic locations alphabetically.</li>\n        <li>iii) Finally if you don't know the name of your geographical location, if possible enter your full postcode\n          in the \"Enter Your Postcode\"\n          box. Please note partial postcodes will not work.</li>\n        <ul>\n    </div>\n  </div>\n  <div id=\"licensingModal\" class=\"modal\">\n    <div class=\"modal-dialog modal-md\">\n      <span class=\"close\">X</span>\n      <h2>UK: licensing information</h2>\n      <p>Contains OS data © Crown copyright and database right [2014]. This information is licensed under the terms of\n        the Open Government License.</p>\n      <p>Pertains to UK maps including:</p>\n      <ul>\n        <li>Local authorities</li>\n        <li>European constituencies</li>\n        <li>Parliamentary constituencies</li>\n        <li>Scottish parliament regions and constituencies</li>\n        <li>Welsh Assembly electoral regions</li>\n        <li>Westminster constituencies</li>\n      </ul>\n      <h2>Europe: licensing information</h2>\n      <p>Creative Commons-Attribution Share Alike 3.0 Unported licence and 2.5 Generic license. Blank Map of Europe by\n        Maix / CC-BY-SA 2.5 based on © Julio Reis / <a\n          href=\"https://commons.wikimedia.org/wiki/File:Europe_countries.svg\" target=\"_blank\">Europe countries svg</a>\n        /CC-BY-SA 3.0</p>\n      <h2>Note on borders</h2>\n      <p>The presentation of material therein does not imply the expression of any opinion whatsoever on the part of\n        PoliMapper concerning the legal status of any country, area or territory or of its authorities, or concerning\n        the delimitation of its borders. The depiction and use of boundaries, geographic names and related data shown on\n        maps and included in lists, tables, documents, and databases on this website are not warranted to be error free\n        nor do they necessarily imply official endorsement or acceptance by the PoliMapper.</p>\n    </div>\n  </div>\n  <div class=\"modal fade center\" id=\"twitter\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\"\n    aria-hidden=\"true\">\n    <div class=\"modal-dialog modal-lg modal-dialog-centered\" role=\"document\">\n      <div class=\"modal-content\">\n        <span class=\"close sbm-close\">\n          <i class=\"far fa-times-circle\"></i>\n        </span>\n        <div class=\"sbm-modal-1\">\n          <div class=\"sbm-modal-body\">\n            <div class=\"sbm-modal-body-inr\">\n              <div class=\"sbm-modal-title\">\n                <h2>Tweet Your MP</h2>\n                <p>Here's a sample tweet to send to your local MP.</p>\n              </div>\n              <div class=\"row d-flex-wrap\">\n                <div class=\"col-md-6\">\n                  <form action=\"JavaScript:void(0);\">\n                    <input type=\"hidden\" id=\"mp_twitter_id\">\n                    <div class=\"bordered-box-1 \">\n                      <div class=\"twitter-modal-form\">\n                        <textarea class=\"form-field\" type=\"text\" id=\"is_twitter_text\"></textarea>\n                      </div>\n                    </div>\n                    <div class=\"text-center\">\n                      <button id=\"tweet_mp_msg\" class=\"sbm-btn-white\">Done</button>\n                    </div>\n                  </form>\n                </div>\n                <div class=\"col-md-6\">\n                  <div class=\"modal-right-content\">\n                    <p>Here's a sample tweet to send to your local MP.</p>\n                    <p>1. Make any edits to the tweet - if you want to.</p>\n                    <p>2. Make sure you don't delete the handle as it won't get to them.</p>\n                    <p>3. When you're ready, click done.</p>\n                  </div>\n                </div>\n              </div>\n            </div>\n          </div>\n          <div class=\"app_wrapper m-t-0\">\n            <div class=\"graph-section footer-area\">\n              <div class=\"\">\n                <div class=\"\">\n                  <ul class=\"social-link\">\n                    <li>\n                      <a href=\"\">Privacy policy</a>\n                    </li>\n                    <li>\n                      <a href=\"JavaScript:void(0);\">\n                        <span class=\"licensing\" data-toggle=\"modal\" data-target=\"#licensingModal\"> Licensing</span>\n                      </a>\n                    </li>\n                  </ul>\n                </div>\n              </div>\n              <div class=\"\">\n                <div class=\"\">\n                  <div class=\"footer-logo\">\n                    <a href=\"\">\n                      <img src=\"img/footer-logo.png\" alt=\"\">\n                    </a>\n                  </div>\n                </div>\n              </div>\n            </div>\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n  <div class=\"modal fade center\" id=\"email\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\"\n    aria-hidden=\"true\">\n    <div class=\"modal-dialog modal-dialog-centered modal-lg \" role=\"document\">\n      <div class=\"modal-content\">\n        <span class=\"close sbm-close\">\n          <i class=\"far fa-times-circle\"></i>\n        </span>\n        <div class=\"sbm-modal-1 m-design-2\">\n          <div class=\"sbm-modal-body pb-0\">\n            <div class=\"sbm-modal-body-inr\">\n              <div class=\"sbm-modal-title\">\n                <h2>Email Your Friend</h2>\n              </div>\n              <div class=\"sbm-modal-1-form\">\n                <div class=\"form-inner-wrap\">\n                  <form action=\"#\" method=\"post\">\n                    <div class=\"success-div\" id=\"success\">\n                  <span>Mail sent successfully.</span>\n                </div>\n                    <div class=\"form-f\">\n                      <div>\n                        <input type=\"text\" class=\"w-100 form-field\" id=\"email_friend\" value=\"\"\n                          placeholder=\"Enter Friend Email Address\">\n                        <span id=\"error\"></span>\n                      </div>\n                      <div>\n                        <input type=\"text\" class=\"w-100 form-field\" placeholder=\"Title\" id=\"email_friend_title\" value=\"\">\n                      </div>\n                    </div>\n                    <textarea placeholder=\"Enter Message\" name=\"\" class=\"w-100 form-field\" id=\"email_friend_text\" rows=\"10\">\n                     </textarea>\n                    <div class=\"text-center\">\n                      <button type=\"submit\" class=\"sbm-btn-white\" onclick=\"sendEmail()\">Send</button>\n                    </div>\n                     \n                  </form>\n                </div>\n              </div>\n            </div>\n          </div>\n          <div class=\"app_wrapper m-t-0\">\n            <div class=\"graph-section footer-area\">\n              <div class=\"\">\n                <div class=\"\">\n                  <ul class=\"social-link\">\n                    <li>\n                      <a href=\"\">Privacy policy</a>\n                    </li>\n                    <li>\n                      <a href=\"JavaScript:void(0);\">\n                        <span class=\"licensing\" data-toggle=\"modal\" data-target=\"#licensingModal\"> Licensing</span>\n                      </a>\n                    </li>\n                  </ul>\n                </div>\n              </div>\n              <div class=\"\">\n                <div class=\"\">\n                  <div class=\"footer-logo\">\n                    <a href=\"\">\n                      <img src=\"img/footer-logo.png\" alt=\"\">\n                    </a>\n                  </div>\n                </div>\n              </div>\n            </div>\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n  <div class=\"modal fade center\" id=\"emailMp\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\"\n    aria-hidden=\"true\">\n    <div class=\"modal-dialog modal-dialog-centered modal-lg \" role=\"document\">\n      <div class=\"modal-content\">\n        <span class=\"close sbm-close\">\n          <i class=\"far fa-times-circle\"></i>\n        </span>\n        <div class=\"sbm-modal-1 m-design-2\">\n          <div class=\"sbm-modal-body pb-0\">\n            <div class=\"sbm-modal-body-inr\">\n              <div class=\"sbm-modal-title\">\n                <h2>Email Your MP</h2>\n                <p>Here's a sample email to send to your local MP.</p>\n                <p>1. Make any edits to the tweet - if you want to.</p>\n                <p>2. Make sure you don't delete the link as this is where is your MP gets the letter to send to the\n                  minister.</p>\n                <p>3. When you're ready, click done.</p>\n              </div>\n              <div class=\"sbm-modal-1-form\">\n                <div class=\"form-inner-wrap\">\n                  <form action=\"JavaScript:void(0);\">\n                        <div class=\"success-div\" id=\"mp_success\">\n                <span>Mail sent successfully.</span>\n              </div>\n                    <input type=\"hidden\" id=\"mp_email\">\n                    <input type=\"text\" class=\"w-100 form-field\" id=\"email_mp_sub\" value=\"\">\n                    <textarea name=\"\" class=\"w-100 form-field\" id=\"email_mp_message\" rows=\"10\">\n                                    </textarea>\n                    <div class=\"text-center\">\n                      <a href=\"#\" class=\"sbm-btn-white\" onclick=\"EmailtoMp()\">\n                        Send\n                      </a>\n                    </div>\n                  </form>\n                </div>\n              </div>\n            </div>\n          </div>\n          <div class=\"app_wrapper m-t-0\">\n            <div class=\"graph-section footer-area\">\n              <div class=\"\">\n                <div class=\"\">\n                  <ul class=\"social-link\">\n                    <li>\n                      <a href=\"\">Privacy policy</a>\n                    </li>\n                    <li>\n                      <a href=\"JavaScript:void(0);\">\n                        <span class=\"licensing\" data-toggle=\"modal\" data-target=\"#licensingModal\"> Licensing</span>\n                      </a>\n                    </li>\n                  </ul>\n                </div>\n              </div>\n              <div class=\"\">\n                <div class=\"\">\n                  <div class=\"footer-logo\">\n                    <a href=\"\">\n                      <img src=\"img/footer-logo.png\" alt=\"\">\n                    </a>\n                  </div>\n                </div>\n              </div>\n            </div>\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>\n<input type=\"hidden\" id=\"project_password\">\n<input type=\"hidden\" id=\"project_key\">\n<div class=\"protected-project\"></div>\n<script src=\"https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js\"></script>\n\n<script>\n\n  //password_verify\n  function verifyPass() {\n    var project_password = $(\"#project_password\").val();\n    var project_key = $(\"#project_key\").val();\n    var input_password = $(\"#input_password\").val();\n    var converted = CryptoJS.MD5(input_password);\n    if (input_password == \"\") {\n      $(\"#password_error\").html(\"password is required.\");\n    }\n    else if (converted != project_password) {\n      $(\"#password_error\").html(\"incorrect password.\");\n    }\n    else {\n      $(\"#password_error\").html(\"success.\");\n      $(\"#password_error\").css(\"color\", \"green\");\n      localStorage.setItem('passKey', converted);\n      localStorage.setItem('projectKey', project_key);\n      location.reload();\n    }\n  };\n\n  function socialWindow(url) {\n    var left = (screen.width - 570) / 2;\n    var top = (screen.height - 570) / 2;\n    var params = \"menubar=no,toolbar=no,status=no,width=570,height=570,top=\" + top + \",left=\" + left;\n    window.open(url, \"NewWindow\", params);\n  }\n\n  document.getElementById('is_facebook_modal').onclick = function () {\n    var message = document.getElementById('is_facebook').value;\n    var project_key = $(\"#project_key\").val();\n//var pageUrl = Polimapper.baseUrl +'?dataSetKey='+project_key;\nvar pageUrl = \"https://visualisation.polimapper.co.uk/?dataSetKey=\"+project_key;\n    url = 'https://www.facebook.com/sharer/sharer.php?u='+pageUrl+'&quote=' + message, 'sharer', 'toolbar=0, status=0, width=626, height=436';\n    socialWindow(url);\n  }\n\n  document.getElementById('is_twitter_modal').onclick = function () {\n    var is_twitter = document.getElementById('is_twitter').value;\n    url = 'https://twitter.com/intent/tweet?text=' + is_twitter + encodeURIComponent(' ');\n    socialWindow(url);\n  }\n\n  $(\"#is_linkedin_modal\").on(\"click\", function () {\nvar project_key = $(\"#project_key\").val();\n//var pageUrl = Polimapper.baseUrl +'?dataSetKey='+project_key;\nvar pageUrl = \"https://visualisation.polimapper.co.uk/?dataSetKey=\"+project_key;\n    url = \"https://www.linkedin.com/sharing/share-offsite/?mini=true&url=\"+pageUrl+\"&source=CSS-Tricks\";\n    socialWindow(url);\n  })\n\n  //tweet direct message\n  $(\"#tweet_mp_msg\").on(\"click\", function () {\n    var mp_twitter_id = $(\"#mp_twitter_id\").val();\n    $.ajax({\n      url: 'https://tweeterid.com/ajax.php',\n      data: { input: mp_twitter_id },\n      type: 'post',\n      success: function (response) {\n        var tweet_id = response;\n        var message = document.getElementById('is_twitter_text').value;\n        tweet_msg = \"https://twitter.com/messages/compose?recipient_id=\" + tweet_id + \"&text=\" + message;\n        socialWindow(tweet_msg);\n      }\n    });\n\n  })\n\n  // mail a friend\n  function sendEmail() {\n    var email_friend = document.getElementById('email_friend').value;\n    var email_subject = document.getElementById('email_friend_title').value;\n    var email_message = document.getElementById('email_friend_text').value;\n    if (email_friend == '') {\n      document.getElementById('error').innerHTML = 'Email is required.';\n      Timeout();\n    }\n    else if (!/(.+)@(.+){2,}\\.(.+){2,}/.test(email_friend)) {\n      $(\"#error\").show();\n      document.getElementById('error').innerHTML = 'Invalid email address.';\n      //Timeout();\n    }\n    else {\n      Email.send({\n        SecureToken: \"1b74bd54-b7fe-4aab-848d-4a636eb5b9c4\",\n        To: email_friend,\n        From: \"rampatidar550@gmail.com\",\n        Subject: email_subject,\n        Body: email_message,\n      }).then(\n\n      );\n      $(\"#success\").css('display', 'block');\n      document.getElementById('email_friend').value = null;\n      Timeout()\n    }\n  }\n\n  // mail to mp\n  function EmailtoMp() {\n    //var mp_email = document.getElementById('mp_email').value;\n    var email_mp_sub = document.getElementById('email_mp_sub').value;\n    var email_mp_message = document.getElementById('email_mp_message').value;\n    Email.send({\n      SecureToken: \"1b74bd54-b7fe-4aab-848d-4a636eb5b9c4\",\n      To: 'belal@codeadigital.co.uk',\n      From: \"rampatidar550@gmail.com\",\n      Subject: email_mp_sub,\n      Body: email_mp_message,\n    }).then(\n\n    );\n    $(\"#mp_success\").css('display', 'block');\n    setTimeout(function () {\n      $(\"#mp_success\").hide();\n    }, 3000);\n  }\n\n  function Timeout() {\n    setTimeout(function () {\n      $(\"#error\").hide();\n      $(\"#success\").hide();\n    }, 3000);\n  }\n  // select 2\n  $(\"#sel_con\").select2({\n  });\n\n    function goBack() {\n      var url = window.location.href.split('#')[0];\n      window.location.href = url;\n    }\n</script>";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/link.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var helper;

  return "      <h3 class=\"n\">"
    + this.escapeExpression(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n";
},"3":function(depth0,helpers,partials,data) {
    var helper;

  return "      <h3 class=\"n no_padding\">"
    + this.escapeExpression(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  <div class=\"result result_text col-sm-12\">\n  	<span class=\"icon "
    + alias3(((helper = (helper = helpers.icon || (depth0 != null ? depth0.icon : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"icon","hash":{},"data":data}) : helper)))
    + "\" title=\""
    + alias3(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias3(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\"> </span>\n    <h3 class=\"v\"><a href=\""
    + alias3(((helper = (helper = helpers.url || (depth0 != null ? depth0.url : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"url","hash":{},"data":data}) : helper)))
    + "\">"
    + alias3(((helper = (helper = helpers.text || (depth0 != null ? depth0.text : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"text","hash":{},"data":data}) : helper)))
    + "</a></h3>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.icon : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.program(3, data, 0),"data":data})) != null ? stack1 : "")
    + "  </div>\n\n";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/minusNumberNode.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  	<div class=\"result col-md-12\">\n"
    + ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.icons : depth0),{"name":"each","hash":{},"fn":this.program(2, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.value : depth0),{"name":"if","hash":{},"fn":this.program(5, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.legend : depth0),{"name":"if","hash":{},"fn":this.program(8, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <canvas id=\""
    + alias3(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\" width=\"400%\" height=\"150%\"></canvas>\n    </div>\n";
},"2":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,depth0,{"name":"if","hash":{},"fn":this.program(3, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "");
},"3":function(depth0,helpers,partials,data) {
    var helper, alias1=this.escapeExpression, alias2=helpers.helperMissing, alias3="function";

  return "          <span class=\"icon "
    + alias1(this.lambda(depth0, depth0))
    + "\" style=\"color: "
    + alias1(((helper = (helper = helpers.color || (depth0 != null ? depth0.color : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"color","hash":{},"data":data}) : helper)))
    + ";\" title=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\">\n          </span>\n";
},"5":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "    	  <h3 class=\"v\">"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.total : depth0),{"name":"if","hash":{},"fn":this.program(6, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + alias3(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + " <span class=\"n\">in "
    + alias3(((helper = (helper = helpers.node || (depth0 != null ? depth0.node : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"node","hash":{},"data":data}) : helper)))
    + "</span></h3>\n";
},"6":function(depth0,helpers,partials,data) {
    return "<span class=\"xs\">Total </span>";
},"8":function(depth0,helpers,partials,data) {
    var stack1, helper;

  return "        <div class=\"graph-legend\">\n          "
    + ((stack1 = ((helper = (helper = helpers.legendHtml || (depth0 != null ? depth0.legendHtml : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"legendHtml","hash":{},"data":data}) : helper))) != null ? stack1 : "")
    + "\n        </div>\n";
},"10":function(depth0,helpers,partials,data) {
    var stack1, helper;

  return "    <div class=\"result result_graph col-xs-12 node-graph\">\n"
    + ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.icons : depth0),{"name":"each","hash":{},"fn":this.program(11, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <h3 class=\"n\">"
    + this.escapeExpression(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showGraph : depth0),{"name":"if","hash":{},"fn":this.program(13, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "    </div>\n";
},"11":function(depth0,helpers,partials,data) {
    var helper, alias1=this.escapeExpression, alias2=helpers.helperMissing, alias3="function";

  return "        <span class=\"icon "
    + alias1(this.lambda(depth0, depth0))
    + "\" style=\"color: "
    + alias1(((helper = (helper = helpers.color || (depth0 != null ? depth0.color : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"color","hash":{},"data":data}) : helper)))
    + ";\" title=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\">\n        </span>\n";
},"13":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=this.lambda, alias2=this.escapeExpression;

  return "      <div class=\"charts\">\n        <div class=\"chart-wrapper\">\n          <div class=\"chart-background\" style=\"background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.nodeDataset : depth0)) != null ? stack1.fillColor : stack1), depth0))
    + ";\">\n            <div class=\"chart-value node minus\" style=\"width:0px; background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.nodeDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\"></div>\n          </div>\n          <span style=\"color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.nodeDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\">"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.nodeDataset : depth0)) != null ? stack1.data : stack1), depth0))
    + "<span class=\"ref-max\"></span>\n        </div>\n        <span class=\"stat-name\">Node</span>\n\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showAvg : depth0),{"name":"if","hash":{},"fn":this.program(14, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "        <p class=\"description\">"
    + alias2(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>\n        </div>\n";
},"14":function(depth0,helpers,partials,data) {
    var stack1, alias1=this.lambda, alias2=this.escapeExpression;

  return "          <div class=\"chart-wrapper\">\n            <div class=\"chart-background\" style=\"background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.fillColor : stack1), depth0))
    + ";\">\n              <div class=\"chart-value avg minus\" style=\"width:0px; background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\"></div>\n            </div>\n            <span style=\"color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\">"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.data : stack1), depth0))
    + "<span class=\"ref-max\"></span>\n          </div>\n          <span class=\"stat-name\">Avg</span>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.program(10, data, 0),"data":data})) != null ? stack1 : "")
    + "\n\n\n";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/mobileLayout.handlebars"] = Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "<div class=\"polimapper-mobile\">\n  <div class=\"topbar\">\n    <img class=\"logo\" id=\"logo-mobile\" src=\""
    + alias3(((helper = (helper = helpers.resourcePrefix || (depth0 != null ? depth0.resourcePrefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"resourcePrefix","hash":{},"data":data}) : helper)))
    + "img/logo.png\" alt=\"Interactive Infographic\">\n  </div>\n  <div class=\"content-wrapper\">\n    <div class=\"map-nav-container\">\n      <div class=\"showmap\"><span>SHOW MAP</span><img class=\"\" src=\""
    + alias3(((helper = (helper = helpers.resourcePrefix || (depth0 != null ? depth0.resourcePrefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"resourcePrefix","hash":{},"data":data}) : helper)))
    + "img/map.png\" alt=\"Polimmapper Map\" title=\"Polimmapper Map\" /></div>\n      <div class=\"search-constituency\"><span class=\"icon icon-search\"></span>\n        <form><input type=\"search\" name=\"searchConstituency\" placeholder=\"\"></form>\n      </div>\n    </div>\n    <div class=\"app_wrapper\">\n      <span id=\"close-constituency\"><span class=\"icon icon-arrow-left8\"></span></span>\n      <div id=\"data\" class=\"data\">\n        <div class=\"lightbox\" id=\"con_over\" style=\"display: none;\">\n          <h4 id=\"ranking_title\">Rankings </h4>\n            <div id=\"rankings\">\n              <div>OUT OF "
    + alias3(((helper = (helper = helpers.nodesTotal || (depth0 != null ? depth0.nodesTotal : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"nodesTotal","hash":{},"data":data}) : helper)))
    + " (where no.1 is the best)</div>\n            </div>\n          </div>\n        <div class=\"results\">\n          <div class=\"col-xs-12 totals\">\n            <h2 id=\"name\"></h2>\n            <div id=\"description\" class=\"read-more-wrapper\"></div>\n          </div>\n        </div>\n      </div>\n      <div class=\"svg-modal\">\n        <div class=\"back-button\"><span class=\"icon icon-arrow-left8\"></span></div>\n        <div class=\"search-constituency\"><span class=\"icon icon-search\"></span>\n          <form><input type=\"search\" name=\"searchConstituency\" placeholder=\"\"></form>\n        </div>\n        <div class=\"options-mobile\">\n          <div id=\"data_selector\" class=\"icons\">\n          </div>\n          <div id=\"data_selector\" class=\"text\">\n            <div class=\"select-wrapper\">\n              <div name=\"dataFields\" form=\"\" id=\"data_con-mobile\">\n              </div>\n              <div class=\"data-field-controls\">\n                <div id=\"dots\">\n                </div>\n                <div id=\"swipe-for-more\"><span class=\"icon icon-arrow-left8\"></span>Swipe here for more<span class=\"icon icon-arrow-right8\"></span></div>\n              </div>\n            </div>\n          </div>\n        </div>\n        <div class=\"svg_wrapper\">\n          <!-- Insert SVG XML here -->\n        </div>\n        <div class=\"legend\">\n        <div class=\"dtfield\">\n          <h2 id=\"map-legend\">Map Legend</h2><span class=\"icon icon-arrow-down3\"></span>\n        </div>\n        <div class=\"bar\">\n\n        </div>\n        <div class=\"key\">\n          <span> <span id=\"q1\" class=\"pretty-number\"></span></span>\n          <span> <span id=\"q2\" class=\"pretty-number\"></span></span>\n          <span> <span id=\"q3\" class=\"pretty-number\"></span></span>\n          <span> <span id=\"q4\" class=\"pretty-number\"></span></span>\n          <span> <span id=\"q5\" class=\"pretty-number\"></span></span>\n          <span> <span id=\"q6\" class=\"pretty-number\"></span></span>\n          <span> <span id=\"q7\" class=\"pretty-number\"></span></span>\n          <span> <span id=\"q8\" class=\"pretty-number\"></span></span>\n          <span> <span id=\"q9\" class=\"pretty-number\"></span></span>\n          <span> <span id=\"q10\" class=\"pretty-number\"></span></span>\n          <span><span id=\"q11\"></span></span>\n        </div>\n      </div>\n    </div>\n  </div>\n  <div class=\"footer-take-over\">\n    <span class=\"close\">X</span>\n    <span class=\"icon icon-question\"> Help</span> | <span class=\"icon icon-exclamation\"> Licensing</span>\n    <div class=\"help-text\">\n      <h2>How to use this map</h2>\n      <p>You can use this map to view macro trends or to find information specific to a geographical location. Click on the icons\n        in the top-right hand corner of the map to review macro trends across different data.</p>\n      <p>There are three ways to find the data for a specific geographical location.</p>\n      <ul>\n        <li>i) Hover over the map to reveal the location's name. When you find your location double click to access the\n          location-specific data.</li>\n        <li>ii) Alternatively use the location drop-down box which lists geographic locations alphabetically.</li>\n        <li>iii) Finally if you don't know the name of your geographical location, if possible enter your full postcode in the \"Enter Your Postcode\"\n          box. Please note partial postcodes will not work.</li>\n      </ul>\n    </div>\n\n    <div class=\"licensing-text\">\n      <h2>UK: licensing information</h2>\n      <p>Contains OS data © Crown copyright and database right [2014]. This information is licensed under the terms of the Open Government License.</p>\n      <p>Pertains to UK maps including:</p>\n      <ul>\n        <li>Local authorities</li>\n        <li>European constituencies</li>\n        <li>Parliamentary constituencies</li>\n        <li>Scottish parliament regions and constituencies</li>\n        <li>Welsh Assembly electoral regions</li>\n        <li>Westminster constituencies</li>\n      </ul>\n      <h2>Europe: licensing information</h2>\n      <p>Creative Commons-Attribution Share Alike 3.0 Unported licence and 2.5 Generic license. Blank Map of Europe by Maix / CC-BY-SA 2.5 based on © Julio Reis / <a href=\"https://commons.wikimedia.org/wiki/File:Europe_countries.svg\" target=\"_blank\">Europe countries svg</a> /CC-BY-SA 3.0</p>\n      <h2>Note on borders</h2>\n      <p>The presentation of material therein does not imply the expression of any opinion whatsoever on the part of PoliMapper concerning the legal status of any country, area or territory or of its authorities, or concerning the delimitation of its borders. The depiction and use of boundaries, geographic names and related data shown on maps and included in lists, tables, documents, and databases on this website are not warranted to be error free nor do they necessarily imply official endorsement or acceptance by the PoliMapper.</p>\n    </div>\n\n    <div class=\"copy\">\n      <div class=\"content\">\n      </div>\n      <div class=\"social\">\n        <img class=\"fbshare\" src=\""
    + alias3(((helper = (helper = helpers.resourcePrefix || (depth0 != null ? depth0.resourcePrefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"resourcePrefix","hash":{},"data":data}) : helper)))
    + "img/facebook_w.png\" alt=\"Share this page on Facebook\" title=\"Share this page on Facebook\">\n        <img class=\"tweet\" src=\""
    + alias3(((helper = (helper = helpers.resourcePrefix || (depth0 != null ? depth0.resourcePrefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"resourcePrefix","hash":{},"data":data}) : helper)))
    + "img/twitter_w.png\" alt=\"Tweet this page\" title=\"Tweet this page\">\n        <img class=\"lkshare\" src=\""
    + alias3(((helper = (helper = helpers.resourcePrefix || (depth0 != null ? depth0.resourcePrefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"resourcePrefix","hash":{},"data":data}) : helper)))
    + "img/linkedin_w.png\" alt=\"Share this page on Linkedin\" title=\"Share this page on Linkedin\">\n        <div class=\"addthis_sharing_toolbox\"></div>\n        <script type=\"text/javascript\" src=\"//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5660326af404d926\" async=\"async\"></script>\n\n      </div>\n    </div>\n  </div>\n  <div class=\"more-info\">+</div>\n</div>\n</div>\n";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/mobileNumber.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  <div class=\"result result_graph col-xs-12 option-2\">\n    <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n    <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>\n    <div class=\"charts "
    + alias3(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\">\n";
},"3":function(depth0,helpers,partials,data) {
    var stack1;

  return "  <div class=\"result-wrapper "
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(4, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "\">\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(6, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "  <div class=\"graph-wrapper\">\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showMin : depth0),{"name":"if","hash":{},"fn":this.program(8, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showAvg : depth0),{"name":"if","hash":{},"fn":this.program(17, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showMax : depth0),{"name":"if","hash":{},"fn":this.program(20, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "  </div>\n  </div>\n";
},"4":function(depth0,helpers,partials,data) {
    return "multivalue";
},"6":function(depth0,helpers,partials,data) {
    var helper;

  return "      <p class=\"description\">"
    + this.escapeExpression(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "</p>\n";
},"8":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=this.lambda, alias2=this.escapeExpression;

  return "      <div class=\"chart-wrapper\">\n        <span class=\"n-value\" style=\"color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.minDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\">"
    + alias2(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.bigNumber : depth0),{"name":"if","hash":{},"fn":this.program(9, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.minDataset : depth0)) != null ? stack1.data : stack1), depth0))
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.bigNumber : depth0),{"name":"if","hash":{},"fn":this.program(11, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "<span class=\"ref-max\"></span></span>\n        <div class=\"chart-value min\" style=\"height:"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(13, data, 0),"inverse":this.program(15, data, 0),"data":data})) != null ? stack1 : "")
    + "; background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.minDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\"></div>\n        <span class=\"stat-name\">Min</span>\n      </div>\n";
},"9":function(depth0,helpers,partials,data) {
    return "<span class=\"pretty-number\">";
},"11":function(depth0,helpers,partials,data) {
    return "</span>";
},"13":function(depth0,helpers,partials,data) {
    var stack1;

  return this.escapeExpression(this.lambda(((stack1 = (depth0 != null ? depth0.setGraphBarWitdhMin : depth0)) != null ? stack1.getBarWidth : stack1), depth0));
},"15":function(depth0,helpers,partials,data) {
    return "0px";
},"17":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=this.lambda, alias2=this.escapeExpression;

  return "      <div class=\"chart-wrapper\">\n        <span class=\"n-value\" style=\"color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\">"
    + alias2(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.bigNumber : depth0),{"name":"if","hash":{},"fn":this.program(9, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.data : stack1), depth0))
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.bigNumber : depth0),{"name":"if","hash":{},"fn":this.program(11, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "<span class=\"ref-max\"></span></span>\n        <div class=\"chart-value avg\" style=\"height:"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(18, data, 0),"inverse":this.program(15, data, 0),"data":data})) != null ? stack1 : "")
    + "; background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\"></div>\n        <span class=\"stat-name\">Avg</span>\n      </div>\n";
},"18":function(depth0,helpers,partials,data) {
    var stack1;

  return this.escapeExpression(this.lambda(((stack1 = (depth0 != null ? depth0.setGraphBarWitdhAvg : depth0)) != null ? stack1.getBarWidth : stack1), depth0));
},"20":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=this.lambda, alias2=this.escapeExpression;

  return "      <div class=\"chart-wrapper\">\n        <span class=\"n-value\" style=\"color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.maxDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\">"
    + alias2(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.bigNumber : depth0),{"name":"if","hash":{},"fn":this.program(9, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.maxDataset : depth0)) != null ? stack1.data : stack1), depth0))
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.bigNumber : depth0),{"name":"if","hash":{},"fn":this.program(11, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "<span class=\"ref-max\"></span></span>\n        <div class=\"chart-value max\" style=\"height:"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(21, data, 0),"inverse":this.program(15, data, 0),"data":data})) != null ? stack1 : "")
    + "; background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.maxDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\"></div>\n        <span class=\"stat-name\">Max</span>\n      </div>\n";
},"21":function(depth0,helpers,partials,data) {
    var stack1;

  return this.escapeExpression(this.lambda(((stack1 = (depth0 != null ? depth0.setGraphBarWitdhMax : depth0)) != null ? stack1.getBarWidth : stack1), depth0));
},"23":function(depth0,helpers,partials,data) {
    var stack1;

  return "  </div>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(24, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "  </div>\n";
},"24":function(depth0,helpers,partials,data) {
    return "      <div class=\"swipe-for-more\"><span class=\"icon icon-arrow-left8\"></span>Swipe here for more<span class=\"icon icon-arrow-right8\"></span></div>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.firstColumn : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showGraph : depth0),{"name":"if","hash":{},"fn":this.program(3, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.lastColumn : depth0),{"name":"if","hash":{},"fn":this.program(23, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "\n\n";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/mobileNumberNode.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  <div class=\"result result_graph col-xs-12 node-graph option-2\">\n    <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n    <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>\n    <div class=\"charts "
    + alias3(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\">\n";
},"3":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=this.lambda, alias2=this.escapeExpression, alias3=helpers.helperMissing, alias4="function";

  return "  <div class=\"result-wrapper "
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(4, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "\">\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(6, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "  <div class=\"graph-wrapper\">\n      <div class=\"chart-wrapper\">\n        <span class=\"n-value\" style=\"color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.nodeDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\">"
    + alias2(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : alias3),(typeof helper === alias4 ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.bigNumber : depth0),{"name":"if","hash":{},"fn":this.program(8, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.nodeDataset : depth0)) != null ? stack1.data : stack1), depth0))
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.bigNumber : depth0),{"name":"if","hash":{},"fn":this.program(10, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "<span class=\"ref-max\"></span></span>\n        <div class=\"chart-value node\" style=\"height:"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(12, data, 0),"inverse":this.program(14, data, 0),"data":data})) != null ? stack1 : "")
    + "; background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.nodeDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\"></div>\n        <span class=\"stat-name\">"
    + alias2(((helper = (helper = helpers.node || (depth0 != null ? depth0.node : depth0)) != null ? helper : alias3),(typeof helper === alias4 ? helper.call(depth0,{"name":"node","hash":{},"data":data}) : helper)))
    + "</span>\n      </div>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showAvg : depth0),{"name":"if","hash":{},"fn":this.program(16, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "  </div>\n  </div>\n";
},"4":function(depth0,helpers,partials,data) {
    return "multivalue";
},"6":function(depth0,helpers,partials,data) {
    var helper;

  return "      <p class=\"description\">"
    + this.escapeExpression(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "</p>\n";
},"8":function(depth0,helpers,partials,data) {
    return "<span class=\"pretty-number\">";
},"10":function(depth0,helpers,partials,data) {
    return "</span>";
},"12":function(depth0,helpers,partials,data) {
    var stack1;

  return this.escapeExpression(this.lambda(((stack1 = (depth0 != null ? depth0.setGraphBarWitdhNodeValue : depth0)) != null ? stack1.getBarWidth : stack1), depth0));
},"14":function(depth0,helpers,partials,data) {
    return "0px";
},"16":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=this.lambda, alias2=this.escapeExpression;

  return "      <div class=\"chart-wrapper\">\n        <span class=\"n-value\" style=\"color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\">"
    + alias2(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.bigNumber : depth0),{"name":"if","hash":{},"fn":this.program(8, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.data : stack1), depth0))
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.bigNumber : depth0),{"name":"if","hash":{},"fn":this.program(10, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "<span class=\"ref-max\"></span></span>\n        <div class=\"chart-value avg\" style=\"height:"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(17, data, 0),"inverse":this.program(14, data, 0),"data":data})) != null ? stack1 : "")
    + "; background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\"></div>\n        <span class=\"stat-name\">Avg</span>\n      </div>\n";
},"17":function(depth0,helpers,partials,data) {
    var stack1;

  return this.escapeExpression(this.lambda(((stack1 = (depth0 != null ? depth0.setGraphBarWitdhAvg : depth0)) != null ? stack1.getBarWidth : stack1), depth0));
},"19":function(depth0,helpers,partials,data) {
    var stack1;

  return "  </div>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(20, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "  </div>\n";
},"20":function(depth0,helpers,partials,data) {
    return "      <div class=\"swipe-for-more\"><span class=\"icon icon-arrow-left8\"></span>Swipe here for more<span class=\"icon icon-arrow-right8\"></span></div>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.firstColumn : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showGraph : depth0),{"name":"if","hash":{},"fn":this.program(3, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.lastColumn : depth0),{"name":"if","hash":{},"fn":this.program(19, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "");
},"useData":true});

this["Polimapper"]["templates"]["src/templates/number.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  	<div class=\"result "
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showGraph : depth0),{"name":"if","hash":{},"fn":this.program(2, data, 0),"inverse":this.program(4, data, 0),"data":data})) != null ? stack1 : "")
    + "\">\n"
    + ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.icons : depth0),{"name":"each","hash":{},"fn":this.program(6, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.value : depth0),{"name":"if","hash":{},"fn":this.program(9, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n      <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>  \n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showGraph : depth0),{"name":"if","hash":{},"fn":this.program(12, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "    </div>\n";
},"2":function(depth0,helpers,partials,data) {
    return "col-md-12";
},"4":function(depth0,helpers,partials,data) {
    return " result_graph col-xs-12 col-sm-12 ";
},"6":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,depth0,{"name":"if","hash":{},"fn":this.program(7, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "");
},"7":function(depth0,helpers,partials,data) {
    var helper, alias1=this.escapeExpression, alias2=helpers.helperMissing, alias3="function";

  return "          <span class=\"icon "
    + alias1(this.lambda(depth0, depth0))
    + "\" style=\"color: "
    + alias1(((helper = (helper = helpers.color || (depth0 != null ? depth0.color : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"color","hash":{},"data":data}) : helper)))
    + ";\" title=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\">\n          </span>\n";
},"9":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "    	  <h3 class=\"v\">"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.total : depth0),{"name":"if","hash":{},"fn":this.program(10, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + alias3(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "</h3>\n";
},"10":function(depth0,helpers,partials,data) {
    return "<span class=\"xs\">Total </span>";
},"12":function(depth0,helpers,partials,data) {
    var stack1, helper;

  return ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.legend : depth0),{"name":"if","hash":{},"fn":this.program(13, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "        <canvas id=\""
    + this.escapeExpression(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\" width=\"400%\" height=\"150%\"></canvas>\n";
},"13":function(depth0,helpers,partials,data) {
    var stack1, helper;

  return "          <div class=\"graph-legend\">\n            "
    + ((stack1 = ((helper = (helper = helpers.legendHtml || (depth0 != null ? depth0.legendHtml : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"legendHtml","hash":{},"data":data}) : helper))) != null ? stack1 : "")
    + "\n          </div>\n";
},"15":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "    <div class=\"result result_graph col-xs-12 col-sm-12\">\n"
    + ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.icons : depth0),{"name":"each","hash":{},"fn":this.program(16, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "    	<h3 class=\"v\">"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.total : depth0),{"name":"if","hash":{},"fn":this.program(10, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + alias3(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "</h3>\n      <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showGraph : depth0),{"name":"if","hash":{},"fn":this.program(18, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "    </div>\n";
},"16":function(depth0,helpers,partials,data) {
    var helper, alias1=this.escapeExpression, alias2=helpers.helperMissing, alias3="function";

  return "        <span class=\"icon "
    + alias1(this.lambda(depth0, depth0))
    + "\" style=\"color: "
    + alias1(((helper = (helper = helpers.color || (depth0 != null ? depth0.color : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"color","hash":{},"data":data}) : helper)))
    + ";\" title=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\">\n        </span>\n";
},"18":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.legend : depth0),{"name":"if","hash":{},"fn":this.program(13, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "        <canvas id=\""
    + alias3(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\" width=\"400%\" height=\"200%\"></canvas>\n        <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.program(15, data, 0),"data":data})) != null ? stack1 : "")
    + "   	\n";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/numberNode.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  	<div class=\"result col-md-12\">\n"
    + ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.icons : depth0),{"name":"each","hash":{},"fn":this.program(2, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.value : depth0),{"name":"if","hash":{},"fn":this.program(5, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>  \n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.legend : depth0),{"name":"if","hash":{},"fn":this.program(8, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <canvas id=\""
    + alias3(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\" width=\"400%\" height=\"150%\"></canvas> \n    </div>\n";
},"2":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,depth0,{"name":"if","hash":{},"fn":this.program(3, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "");
},"3":function(depth0,helpers,partials,data) {
    var helper, alias1=this.escapeExpression, alias2=helpers.helperMissing, alias3="function";

  return "          <span class=\"icon "
    + alias1(this.lambda(depth0, depth0))
    + "\" style=\"color: "
    + alias1(((helper = (helper = helpers.color || (depth0 != null ? depth0.color : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"color","hash":{},"data":data}) : helper)))
    + ";\" title=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\">\n          </span>\n";
},"5":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "    	  <h3 class=\"v\">"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.total : depth0),{"name":"if","hash":{},"fn":this.program(6, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + alias3(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + " <span class=\"n\">in "
    + alias3(((helper = (helper = helpers.node || (depth0 != null ? depth0.node : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"node","hash":{},"data":data}) : helper)))
    + "</span></h3>\n";
},"6":function(depth0,helpers,partials,data) {
    return "<span class=\"xs\">Total </span>";
},"8":function(depth0,helpers,partials,data) {
    var stack1, helper;

  return "        <div class=\"graph-legend\">\n          "
    + ((stack1 = ((helper = (helper = helpers.legendHtml || (depth0 != null ? depth0.legendHtml : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"legendHtml","hash":{},"data":data}) : helper))) != null ? stack1 : "")
    + "\n        </div>\n";
},"10":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "    <div class=\"result result_graph col-xs-12 col-sm-12\">\n"
    + ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.icons : depth0),{"name":"each","hash":{},"fn":this.program(11, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n    	<h3 class=\"v\">"
    + alias3(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + " <span class=\"n\">in "
    + alias3(((helper = (helper = helpers.node || (depth0 != null ? depth0.node : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"node","hash":{},"data":data}) : helper)))
    + "</span></h3>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.legend : depth0),{"name":"if","hash":{},"fn":this.program(8, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <canvas id=\""
    + alias3(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\" width=\"400%\" height=\"200%\"></canvas>\n      <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>\n    </div>\n";
},"11":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,depth0,{"name":"if","hash":{},"fn":this.program(12, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "");
},"12":function(depth0,helpers,partials,data) {
    var helper, alias1=this.escapeExpression, alias2=helpers.helperMissing, alias3="function";

  return "        <span class=\"icon "
    + alias1(this.lambda(depth0, depth0))
    + "\" style=\"color: "
    + alias1(((helper = (helper = helpers.color || (depth0 != null ? depth0.color : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"color","hash":{},"data":data}) : helper)))
    + ";\" title=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\">\n        </span>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.program(10, data, 0),"data":data})) != null ? stack1 : "")
    + "   	\n";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/numberTextNode.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  	<div class=\"result col-md-6 col-sm-6\">\n       <div class=\"graph-text-inr\">\n"
    + ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.icons : depth0),{"name":"each","hash":{},"fn":this.program(2, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.value : depth0),{"name":"if","hash":{},"fn":this.program(5, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>  \n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.legend : depth0),{"name":"if","hash":{},"fn":this.program(8, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "       </div>\n       </div>\n";
},"2":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,depth0,{"name":"if","hash":{},"fn":this.program(3, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "");
},"3":function(depth0,helpers,partials,data) {
    var helper, alias1=this.escapeExpression, alias2=helpers.helperMissing, alias3="function";

  return "          <span class=\"icon "
    + alias1(this.lambda(depth0, depth0))
    + "\" style=\"color: "
    + alias1(((helper = (helper = helpers.color || (depth0 != null ? depth0.color : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"color","hash":{},"data":data}) : helper)))
    + ";\" title=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\">\n          </span>\n";
},"5":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "    	  <h3 class=\"v\">"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.total : depth0),{"name":"if","hash":{},"fn":this.program(6, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + alias3(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + " <span class=\"n\">in "
    + alias3(((helper = (helper = helpers.node || (depth0 != null ? depth0.node : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"node","hash":{},"data":data}) : helper)))
    + "</span></h3>\n";
},"6":function(depth0,helpers,partials,data) {
    return "<span class=\"xs\">Total </span>";
},"8":function(depth0,helpers,partials,data) {
    var stack1, helper;

  return "        <div class=\"graph-legend\">\n          "
    + ((stack1 = ((helper = (helper = helpers.legendHtml || (depth0 != null ? depth0.legendHtml : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"legendHtml","hash":{},"data":data}) : helper))) != null ? stack1 : "")
    + "\n        </div>\n";
},"10":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "    <div class=\"result result_graph col-xs-12 col-sm-6 graph-text\">\n      <div class=\"graph-text-inr\">\n"
    + ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.icons : depth0),{"name":"each","hash":{},"fn":this.program(11, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "\n      <h3 class=\"n\"><span>"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</span>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.description : depth0),{"name":"if","hash":{},"fn":this.program(14, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "</h3>\n    	<h3 class=\"v\">"
    + alias3(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + " <span class=\"n\">in "
    + alias3(((helper = (helper = helpers.node || (depth0 != null ? depth0.node : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"node","hash":{},"data":data}) : helper)))
    + "</span></h3>\n      </div>\n      </div>\n";
},"11":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,depth0,{"name":"if","hash":{},"fn":this.program(12, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "");
},"12":function(depth0,helpers,partials,data) {
    var helper, alias1=this.escapeExpression, alias2=helpers.helperMissing, alias3="function";

  return "        <span class=\"icon "
    + alias1(this.lambda(depth0, depth0))
    + "\" style=\"color: "
    + alias1(((helper = (helper = helpers.color || (depth0 != null ? depth0.color : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"color","hash":{},"data":data}) : helper)))
    + ";\" title=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\">\n        </span>\n";
},"14":function(depth0,helpers,partials,data) {
    var helper;

  return "        <div class=\"mytooltip\">\n          <svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" version=\"1.1\" x=\"0px\" y=\"0px\" viewBox=\"0 0 100 125\" enable-background=\"new 0 0 100 100\" xml:space=\"preserve\">\n	<path d=\"M49.991,90.844C26.881,90.752,8.518,71.828,9.188,48.774C9.828,26.748,27.862,8.999,50.317,9.155  C72.932,9.313,91.052,27.79,90.828,50.33C90.604,72.801,72.187,91.072,49.991,90.844z M50.857,44.186  c-4.139,0.136-7.84,1.569-11.257,3.828c-0.289,0.191-0.566,0.427-0.785,0.694c-0.78,0.952-0.513,1.758,0.663,2.065  c0.452,0.118,0.916,0.199,1.36,0.341c1.878,0.599,2.384,1.52,1.908,3.467c-1.158,4.733-2.339,9.461-3.477,14.199  c-0.844,3.516,0.937,6.391,4.312,6.652c4.995,0.385,9.453-1.263,13.463-4.157c0.425-0.306,0.754-1.068,0.709-1.582  c-0.027-0.312-0.85-0.569-1.332-0.819c-0.203-0.105-0.449-0.125-0.675-0.186c-2.234-0.597-2.815-1.531-2.274-3.76  c1.12-4.622,2.311-9.227,3.357-13.866c0.248-1.098,0.265-2.36-0.013-3.443C56.193,45.207,54.082,44.092,50.857,44.186z   M61.249,30.029c0.006-4.266-3.291-7.632-7.504-7.66c-4.284-0.029-7.724,3.377-7.688,7.61c0.036,4.219,3.389,7.531,7.64,7.545  C57.842,37.538,61.242,34.163,61.249,30.029z\" />\n</svg>\n <span>"
    + this.escapeExpression(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</span>\n        </div>   \n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.program(10, data, 0),"data":data})) != null ? stack1 : "")
    + "   	\n";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/percentage.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  	  <span class=\"icon "
    + alias3(((helper = (helper = helpers.icon || (depth0 != null ? depth0.icon : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"icon","hash":{},"data":data}) : helper)))
    + "\" title=\""
    + alias3(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias3(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\"> </span>\n";
},"3":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "      <canvas id=\""
    + alias3(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\" width=\"400%\" height=\"200%\"></canvas>\n      <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  <div class=\"result result_graph col-xs-12 col-sm-6 col-md-6\">\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.icon : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "    <h3 class=\"v\">"
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "%</h3>\n    <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showGraph : depth0),{"name":"if","hash":{},"fn":this.program(3, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "  </div>\n";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/percentageMobile.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  <div class=\"result result_graph col-xs-12 option-1\">\n"
    + ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.icons : depth0),{"name":"each","hash":{},"fn":this.program(2, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "    "
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.value : depth0),{"name":"if","hash":{},"fn":this.program(4, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "\n    <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n    <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>\n    <div class=\"charts "
    + alias3(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\">\n";
},"2":function(depth0,helpers,partials,data) {
    var helper, alias1=this.escapeExpression, alias2=helpers.helperMissing, alias3="function";

  return "      <span class=\"icon "
    + alias1(this.lambda(depth0, depth0))
    + "\" style=\"color: "
    + alias1(((helper = (helper = helpers.color || (depth0 != null ? depth0.color : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"color","hash":{},"data":data}) : helper)))
    + ";\" title=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias1(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\">\n      </span>\n";
},"4":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "<h3 class=\"v\">"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.total : depth0),{"name":"if","hash":{},"fn":this.program(5, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + alias3(((helper = (helper = helpers.currency || (depth0 != null ? depth0.currency : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"currency","hash":{},"data":data}) : helper)))
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "</h3>";
},"5":function(depth0,helpers,partials,data) {
    return "<span class=\"xs\">Total </span>";
},"7":function(depth0,helpers,partials,data) {
    var stack1;

  return "  <div class=\"result-wrapper "
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(8, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "\">\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(10, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "  <div class=\"\">\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showMin : depth0),{"name":"if","hash":{},"fn":this.program(12, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showAvg : depth0),{"name":"if","hash":{},"fn":this.program(17, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showMax : depth0),{"name":"if","hash":{},"fn":this.program(20, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "  </div>\n  </div>\n";
},"8":function(depth0,helpers,partials,data) {
    return "multivalue";
},"10":function(depth0,helpers,partials,data) {
    var helper;

  return "      <p class=\"description\">"
    + this.escapeExpression(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "</p>\n";
},"12":function(depth0,helpers,partials,data) {
    var stack1, alias1=this.lambda, alias2=this.escapeExpression;

  return "      <div class=\"chart-wrapper\">\n        <div class=\"chart-background\" style=\"background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.minDataset : depth0)) != null ? stack1.fillColor : stack1), depth0))
    + ";\">\n          <div class=\"chart-value min\" style=\"width:"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(13, data, 0),"inverse":this.program(15, data, 0),"data":data})) != null ? stack1 : "")
    + "; background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.minDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\"></div>\n        </div>\n        <span style=\"color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.minDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\">"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.minDataset : depth0)) != null ? stack1.data : stack1), depth0))
    + "%<span class=\"ref-max\"></span>\n      </div>\n      <span class=\"stat-name\">Min</span>\n";
},"13":function(depth0,helpers,partials,data) {
    var stack1;

  return this.escapeExpression(this.lambda(((stack1 = (depth0 != null ? depth0.setGraphBarWitdhMin : depth0)) != null ? stack1.getBarWidth : stack1), depth0));
},"15":function(depth0,helpers,partials,data) {
    return "0px";
},"17":function(depth0,helpers,partials,data) {
    var stack1, alias1=this.lambda, alias2=this.escapeExpression;

  return "      <div class=\"chart-wrapper\">\n        <div class=\"chart-background\" style=\"background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.fillColor : stack1), depth0))
    + ";\">\n          <div class=\"chart-value avg\" style=\"width:"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(18, data, 0),"inverse":this.program(15, data, 0),"data":data})) != null ? stack1 : "")
    + "; background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\"></div>\n        </div>\n        <span style=\"color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\">"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.data : stack1), depth0))
    + "%<span class=\"ref-max\"></span>\n      </div>\n      <span class=\"stat-name\">Avg</span>\n";
},"18":function(depth0,helpers,partials,data) {
    var stack1;

  return this.escapeExpression(this.lambda(((stack1 = (depth0 != null ? depth0.setGraphBarWitdhAvg : depth0)) != null ? stack1.getBarWidth : stack1), depth0));
},"20":function(depth0,helpers,partials,data) {
    var stack1, alias1=this.lambda, alias2=this.escapeExpression;

  return "      <div class=\"chart-wrapper\">\n        <div class=\"chart-background\" style=\"background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.maxDataset : depth0)) != null ? stack1.fillColor : stack1), depth0))
    + ";\">\n          <div class=\"chart-value max\" style=\"width:"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(21, data, 0),"inverse":this.program(15, data, 0),"data":data})) != null ? stack1 : "")
    + "; background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.maxDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\"></div>\n        </div>\n        <span style=\"color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.maxDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\">"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.maxDataset : depth0)) != null ? stack1.data : stack1), depth0))
    + "%<span class=\"ref-max\"></span>\n      </div>\n      <span class=\"stat-name\">Max</span>\n";
},"21":function(depth0,helpers,partials,data) {
    var stack1;

  return this.escapeExpression(this.lambda(((stack1 = (depth0 != null ? depth0.setGraphBarWitdhMax : depth0)) != null ? stack1.getBarWidth : stack1), depth0));
},"23":function(depth0,helpers,partials,data) {
    var stack1;

  return "  </div>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(24, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "  </div>\n";
},"24":function(depth0,helpers,partials,data) {
    return "      <div class=\"swipe-for-more\"><span class=\"icon icon-arrow-left8\"></span>Swipe here for more<span class=\"icon icon-arrow-right8\"></span></div>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.firstColumn : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showGraph : depth0),{"name":"if","hash":{},"fn":this.program(7, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.lastColumn : depth0),{"name":"if","hash":{},"fn":this.program(23, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "");
},"useData":true});

this["Polimapper"]["templates"]["src/templates/percentageNode.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "      <span class=\"polimapper-canvas icon "
    + alias3(((helper = (helper = helpers.icon || (depth0 != null ? depth0.icon : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"icon","hash":{},"data":data}) : helper)))
    + "\" title=\""
    + alias3(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias3(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\"> </span>\n";
},"3":function(depth0,helpers,partials,data) {
    var helper;

  return "        <div class=\"mytooltip\">\n          <svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" version=\"1.1\" x=\"0px\" y=\"0px\" viewBox=\"0 0 100 125\" enable-background=\"new 0 0 100 100\" xml:space=\"preserve\">\n	<path d=\"M49.991,90.844C26.881,90.752,8.518,71.828,9.188,48.774C9.828,26.748,27.862,8.999,50.317,9.155  C72.932,9.313,91.052,27.79,90.828,50.33C90.604,72.801,72.187,91.072,49.991,90.844z M50.857,44.186  c-4.139,0.136-7.84,1.569-11.257,3.828c-0.289,0.191-0.566,0.427-0.785,0.694c-0.78,0.952-0.513,1.758,0.663,2.065  c0.452,0.118,0.916,0.199,1.36,0.341c1.878,0.599,2.384,1.52,1.908,3.467c-1.158,4.733-2.339,9.461-3.477,14.199  c-0.844,3.516,0.937,6.391,4.312,6.652c4.995,0.385,9.453-1.263,13.463-4.157c0.425-0.306,0.754-1.068,0.709-1.582  c-0.027-0.312-0.85-0.569-1.332-0.819c-0.203-0.105-0.449-0.125-0.675-0.186c-2.234-0.597-2.815-1.531-2.274-3.76  c1.12-4.622,2.311-9.227,3.357-13.866c0.248-1.098,0.265-2.36-0.013-3.443C56.193,45.207,54.082,44.092,50.857,44.186z   M61.249,30.029c0.006-4.266-3.291-7.632-7.504-7.66c-4.284-0.029-7.724,3.377-7.688,7.61c0.036,4.219,3.389,7.531,7.64,7.545  C57.842,37.538,61.242,34.163,61.249,30.029z\" />\n</svg>\n <span>"
    + this.escapeExpression(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</span>\n        </div>   \n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  <div class=\"result result_graph col-xs-12 col-sm-6 col-md-6 \">\n     <div class=\"graph-text-inr\">\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.icon : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "       \n    <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.description : depth0),{"name":"if","hash":{},"fn":this.program(3, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "    </h3>\n     \n    <h3 class=\"v\">"
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "%</h3>\n    <canvas id=\""
    + alias3(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\" width=\"400%\" height=\"200%\" class=\"polimapper-canvas\"></canvas>\n  </div>\n  </div>\n";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/percentageNodeMobile.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  <div class=\"result result_graph col-xs-12 node-graph option-1\">\n    <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n    <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>\n    <div class=\"charts "
    + alias3(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\">\n";
},"3":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=this.lambda, alias2=this.escapeExpression;

  return "  <div class=\"result-wrapper "
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(4, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "\">\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(6, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "  <div class=\"\">\n      <div class=\"chart-wrapper\">\n        <div class=\"chart-background\" style=\"background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.nodeDataset : depth0)) != null ? stack1.fillColor : stack1), depth0))
    + ";\">\n          <div class=\"chart-value node\" style=\"width:"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(8, data, 0),"inverse":this.program(10, data, 0),"data":data})) != null ? stack1 : "")
    + "; background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.nodeDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\"></div>\n        </div>\n        <span style=\"color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.nodeDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\">"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.nodeDataset : depth0)) != null ? stack1.data : stack1), depth0))
    + "%<span class=\"ref-max\"></span>\n      </div>\n      <span class=\"stat-name\">"
    + alias2(((helper = (helper = helpers.node || (depth0 != null ? depth0.node : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"node","hash":{},"data":data}) : helper)))
    + "</span>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showAvg : depth0),{"name":"if","hash":{},"fn":this.program(12, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "  </div>\n  </div>\n";
},"4":function(depth0,helpers,partials,data) {
    return "multivalue";
},"6":function(depth0,helpers,partials,data) {
    var helper;

  return "      <p class=\"description\">"
    + this.escapeExpression(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "</p>\n";
},"8":function(depth0,helpers,partials,data) {
    var stack1;

  return this.escapeExpression(this.lambda(((stack1 = (depth0 != null ? depth0.setGraphBarWitdhNodeValue : depth0)) != null ? stack1.getBarWidth : stack1), depth0));
},"10":function(depth0,helpers,partials,data) {
    return "0px";
},"12":function(depth0,helpers,partials,data) {
    var stack1, alias1=this.lambda, alias2=this.escapeExpression;

  return "      <div class=\"chart-wrapper\">\n        <div class=\"chart-background\" style=\"background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.fillColor : stack1), depth0))
    + ";\">\n          <div class=\"chart-value avg\" style=\"width:"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(13, data, 0),"inverse":this.program(10, data, 0),"data":data})) != null ? stack1 : "")
    + "; background-color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\"></div>\n        </div>\n        <span style=\"color:"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.highlightFill : stack1), depth0))
    + ";\">"
    + alias2(alias1(((stack1 = (depth0 != null ? depth0.avgDataset : depth0)) != null ? stack1.data : stack1), depth0))
    + "%<span class=\"ref-max\"></span>\n      </div>\n      <span class=\"stat-name\">Avg</span>\n";
},"13":function(depth0,helpers,partials,data) {
    var stack1;

  return this.escapeExpression(this.lambda(((stack1 = (depth0 != null ? depth0.setGraphBarWitdhAvg : depth0)) != null ? stack1.getBarWidth : stack1), depth0));
},"15":function(depth0,helpers,partials,data) {
    var stack1;

  return "  </div>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.multivalued : depth0),{"name":"if","hash":{},"fn":this.program(16, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "  </div>\n";
},"16":function(depth0,helpers,partials,data) {
    return "      <div class=\"swipe-for-more\"><span class=\"icon icon-arrow-left8\"></span>Swipe here for more<span class=\"icon icon-arrow-right8\"></span></div>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.firstColumn : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.showGraph : depth0),{"name":"if","hash":{},"fn":this.program(3, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.lastColumn : depth0),{"name":"if","hash":{},"fn":this.program(15, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "");
},"useData":true});

this["Polimapper"]["templates"]["src/templates/rankings.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var helper;

  return "	  	<span class=\"name\">"
    + this.escapeExpression(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</span>\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "<div>\n	<span class=\"icon icon-test "
    + alias3(((helper = (helper = helpers.icon || (depth0 != null ? depth0.icon : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"icon","hash":{},"data":data}) : helper)))
    + "\" data-name=\""
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "\" data-field-name=\""
    + alias3(((helper = (helper = helpers.fieldName || (depth0 != null ? depth0.fieldName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"fieldName","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "\" title=\""
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "\"> </span>\n	<span><span class=\"hash\">#</span>"
    + alias3(((helper = (helper = helpers.ranking || (depth0 != null ? depth0.ranking : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"ranking","hash":{},"data":data}) : helper)))
    + "</span>\n"
    + ((stack1 = helpers.unless.call(depth0,(depth0 != null ? depth0.icon : depth0),{"name":"unless","hash":{},"fn":this.program(1, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "</div>\n";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/result.handlebars"] = Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  <div class=\"result result_graph col-xs-12 col-sm-6 col-md-6\">\n  	<span class=\"icon "
    + alias3(((helper = (helper = helpers.icon || (depth0 != null ? depth0.icon : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"icon","hash":{},"data":data}) : helper)))
    + "\" title=\""
    + alias3(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias3(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\"> </span>\n    <h3 class=\"v\">"
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "</h3>\n    <h3 class=\"n\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</h3>\n    <canvas id=\""
    + alias3(((helper = (helper = helpers.escapedName || (depth0 != null ? depth0.escapedName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"escapedName","hash":{},"data":data}) : helper)))
    + "\" width=\"100%\" height=\"100%\"></canvas>\n    <p class=\"description\">"
    + alias3(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</p>\n  </div>\n";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/select.handlebars"] = Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "<option value=\""
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</option>";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/selectDatafields.handlebars"] = Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "<option value=\""
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "\" data-field-name=\""
    + alias3(((helper = (helper = helpers.fieldName || (depth0 != null ? depth0.fieldName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"fieldName","hash":{},"data":data}) : helper)))
    + "\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</option>";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/selectDatafieldsChild.handlebars"] = Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "<option data-class=\"childdata\" value=\""
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "\" data-field-name=\""
    + alias3(((helper = (helper = helpers.fieldName || (depth0 != null ? depth0.fieldName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"fieldName","hash":{},"data":data}) : helper)))
    + "\">----"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</option>";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/selectDatafieldsMobile.handlebars"] = Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "<div class=\"data-field-mobile\" data-value=\""
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "\" data-field-name=\""
    + alias3(((helper = (helper = helpers.fieldName || (depth0 != null ? depth0.fieldName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"fieldName","hash":{},"data":data}) : helper)))
    + "\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/selectDatafieldsParent.handlebars"] = Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "<option value=\""
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "\" data-field-name=\""
    + alias3(((helper = (helper = helpers.fieldName || (depth0 != null ? depth0.fieldName : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"fieldName","hash":{},"data":data}) : helper)))
    + "\" disabled >"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</option>";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/selectMobile.handlebars"] = Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "<div data-value=\""
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "\">"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</div>\n";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/text.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "      <span class=\"icon "
    + alias3(((helper = (helper = helpers.icon || (depth0 != null ? depth0.icon : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"icon","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias3(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" title=\""
    + alias3(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\"> </span>\n";
},"3":function(depth0,helpers,partials,data) {
    var helper;

  return "        <div class=\"mytooltip\">\n          <svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" version=\"1.1\" x=\"0px\" y=\"0px\" viewBox=\"0 0 100 125\" enable-background=\"new 0 0 100 100\" xml:space=\"preserve\">\n	<path d=\"M49.991,90.844C26.881,90.752,8.518,71.828,9.188,48.774C9.828,26.748,27.862,8.999,50.317,9.155  C72.932,9.313,91.052,27.79,90.828,50.33C90.604,72.801,72.187,91.072,49.991,90.844z M50.857,44.186  c-4.139,0.136-7.84,1.569-11.257,3.828c-0.289,0.191-0.566,0.427-0.785,0.694c-0.78,0.952-0.513,1.758,0.663,2.065  c0.452,0.118,0.916,0.199,1.36,0.341c1.878,0.599,2.384,1.52,1.908,3.467c-1.158,4.733-2.339,9.461-3.477,14.199  c-0.844,3.516,0.937,6.391,4.312,6.652c4.995,0.385,9.453-1.263,13.463-4.157c0.425-0.306,0.754-1.068,0.709-1.582  c-0.027-0.312-0.85-0.569-1.332-0.819c-0.203-0.105-0.449-0.125-0.675-0.186c-2.234-0.597-2.815-1.531-2.274-3.76  c1.12-4.622,2.311-9.227,3.357-13.866c0.248-1.098,0.265-2.36-0.013-3.443C56.193,45.207,54.082,44.092,50.857,44.186z   M61.249,30.029c0.006-4.266-3.291-7.632-7.504-7.66c-4.284-0.029-7.724,3.377-7.688,7.61c0.036,4.219,3.389,7.531,7.64,7.545  C57.842,37.538,61.242,34.163,61.249,30.029z\" />\n</svg>\n <span>"
    + this.escapeExpression(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</span>\n        </div>   \n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  <div class=\"result result_graph col-xs-12 col-sm-6 graph-text\">\n    <div class=\"graph-text-inr\">\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.icon : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <h3 class=\"n\"><span>"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</span>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.description : depth0),{"name":"if","hash":{},"fn":this.program(3, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "</h3>\n    <h3 class=\"v\">"
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "</h3> \n  </div>\n    </div>\n";
},"useData":true});

this["Polimapper"]["templates"]["src/templates/textMobile.handlebars"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "      <span class=\"icon "
    + alias3(((helper = (helper = helpers.icon || (depth0 != null ? depth0.icon : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"icon","hash":{},"data":data}) : helper)))
    + "\" alt=\""
    + alias3(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\" title=\""
    + alias3(((helper = (helper = helpers.label || (depth0 != null ? depth0.label : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"label","hash":{},"data":data}) : helper)))
    + "\"> </span>\n";
},"3":function(depth0,helpers,partials,data) {
    var helper;

  return "        <div class=\"mytooltip\">\n          <svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" version=\"1.1\" x=\"0px\" y=\"0px\" viewBox=\"0 0 100 125\" enable-background=\"new 0 0 100 100\" xml:space=\"preserve\">\n	<path d=\"M49.991,90.844C26.881,90.752,8.518,71.828,9.188,48.774C9.828,26.748,27.862,8.999,50.317,9.155  C72.932,9.313,91.052,27.79,90.828,50.33C90.604,72.801,72.187,91.072,49.991,90.844z M50.857,44.186  c-4.139,0.136-7.84,1.569-11.257,3.828c-0.289,0.191-0.566,0.427-0.785,0.694c-0.78,0.952-0.513,1.758,0.663,2.065  c0.452,0.118,0.916,0.199,1.36,0.341c1.878,0.599,2.384,1.52,1.908,3.467c-1.158,4.733-2.339,9.461-3.477,14.199  c-0.844,3.516,0.937,6.391,4.312,6.652c4.995,0.385,9.453-1.263,13.463-4.157c0.425-0.306,0.754-1.068,0.709-1.582  c-0.027-0.312-0.85-0.569-1.332-0.819c-0.203-0.105-0.449-0.125-0.675-0.186c-2.234-0.597-2.815-1.531-2.274-3.76  c1.12-4.622,2.311-9.227,3.357-13.866c0.248-1.098,0.265-2.36-0.013-3.443C56.193,45.207,54.082,44.092,50.857,44.186z   M61.249,30.029c0.006-4.266-3.291-7.632-7.504-7.66c-4.284-0.029-7.724,3.377-7.688,7.61c0.036,4.219,3.389,7.531,7.64,7.545  C57.842,37.538,61.242,34.163,61.249,30.029z\" />\n</svg>\n <span>"
    + this.escapeExpression(((helper = (helper = helpers.description || (depth0 != null ? depth0.description : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"description","hash":{},"data":data}) : helper)))
    + "</span>\n        </div>   \n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "  <div class=\"result result_graph col-xs-12 col-sm-6 graph-text\">\n    <div class=\"graph-text-inr\">\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.icon : depth0),{"name":"if","hash":{},"fn":this.program(1, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "      <h3 class=\"n\"><span>"
    + alias3(((helper = (helper = helpers.name || (depth0 != null ? depth0.name : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"name","hash":{},"data":data}) : helper)))
    + "</span>\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.description : depth0),{"name":"if","hash":{},"fn":this.program(3, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "</h3>\n    <h3 class=\"v\">"
    + alias3(((helper = (helper = helpers.value || (depth0 != null ? depth0.value : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"value","hash":{},"data":data}) : helper)))
    + "</h3> \n  </div>\n    </div>\n";
},"useData":true});