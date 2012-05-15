Ext.data.JsonP.Ext_data_SortTypes({"subclasses":[],"files":[{"filename":"SortTypes.js","href":"SortTypes.html#Ext-data-SortTypes"}],"mixins":[],"code_type":"ext_define","inheritable":false,"uses":[],"meta":{"docauthor":["Evan Trimboli <evan@sencha.com>"]},"members":{"method":[{"meta":{"private":true},"tagname":"method","owner":"Ext.Base","name":"addInheritableStatics","id":"method-addInheritableStatics"},{"meta":{},"tagname":"method","owner":"Ext.data.SortTypes","name":"asDate","id":"method-asDate"},{"meta":{},"tagname":"method","owner":"Ext.data.SortTypes","name":"asFloat","id":"method-asFloat"},{"meta":{},"tagname":"method","owner":"Ext.data.SortTypes","name":"asInt","id":"method-asInt"},{"meta":{},"tagname":"method","owner":"Ext.data.SortTypes","name":"asText","id":"method-asText"},{"meta":{},"tagname":"method","owner":"Ext.data.SortTypes","name":"asUCString","id":"method-asUCString"},{"meta":{},"tagname":"method","owner":"Ext.data.SortTypes","name":"asUCText","id":"method-asUCText"},{"meta":{"protected":true},"tagname":"method","owner":"Ext.Base","name":"callOverridden","id":"method-callOverridden"},{"meta":{"protected":true},"tagname":"method","owner":"Ext.Base","name":"callParent","id":"method-callParent"},{"meta":{"protected":true},"tagname":"method","owner":"Ext.Base","name":"initConfig","id":"method-initConfig"},{"meta":{"private":true},"tagname":"method","owner":"Ext.Base","name":"mixin","id":"method-mixin"},{"meta":{},"tagname":"method","owner":"Ext.data.SortTypes","name":"none","id":"method-none"},{"meta":{"private":true},"tagname":"method","owner":"Ext.Base","name":"own","id":"method-own"},{"meta":{"private":true},"tagname":"method","owner":"Ext.Base","name":"ownMethod","id":"method-ownMethod"},{"meta":{"private":true},"tagname":"method","owner":"Ext.Base","name":"setConfig","id":"method-setConfig"},{"meta":{"protected":true},"tagname":"method","owner":"Ext.Base","name":"statics","id":"method-statics"}],"event":[],"property":[{"meta":{"private":true},"tagname":"property","owner":"Ext.Base","name":"applyConfig","id":"property-applyConfig"},{"meta":{"protected":true},"tagname":"property","owner":"Ext.Base","name":"self","id":"property-self"},{"meta":{},"tagname":"property","owner":"Ext.data.SortTypes","name":"stripTagsRE","id":"property-stripTagsRE"}],"css_var":[],"css_mixin":[],"cfg":[]},"html":"<div><pre class=\"hierarchy\"><h4>Hierarchy</h4><div class='subclass first-child'><a href='#!/api/Ext.Base' rel='Ext.Base' class='docClass'>Ext.Base</a><div class='subclass '><strong>Ext.data.SortTypes</strong></div></div><h4>Files</h4><div class='dependency'><a href='source/SortTypes.html#Ext-data-SortTypes' target='_blank'>SortTypes.js</a></div></pre><div class='doc-contents'><p>This class defines a series of static methods that are used on a\n<a href=\"#!/api/Ext.data.Field\" rel=\"Ext.data.Field\" class=\"docClass\">Ext.data.Field</a> for performing sorting. The methods cast the\nunderlying values into a data type that is appropriate for sorting on\nthat particular field.  If a <a href=\"#!/api/Ext.data.Field-cfg-type\" rel=\"Ext.data.Field-cfg-type\" class=\"docClass\">Ext.data.Field.type</a> is specified,\nthe sortType will be set to a sane default if the sortType is not\nexplicitly defined on the field. The sortType will make any necessary\nmodifications to the value and return it.</p>\n\n<ul>\n<li><b>asText</b> - Removes any tags and converts the value to a string</li>\n<li><b>asUCText</b> - Removes any tags and converts the value to an uppercase string</li>\n<li><b>asUCText</b> - Converts the value to an uppercase string</li>\n<li><b>asDate</b> - Converts the value into Unix epoch time</li>\n<li><b>asFloat</b> - Converts the value to a floating point number</li>\n<li><b>asInt</b> - Converts the value to an integer number</li>\n</ul>\n\n\n<p>\nIt is also possible to create a custom sortType that can be used throughout\nan application.\n<pre><code><a href=\"#!/api/Ext-method-apply\" rel=\"Ext-method-apply\" class=\"docClass\">Ext.apply</a>(<a href=\"#!/api/Ext.data.SortTypes\" rel=\"Ext.data.SortTypes\" class=\"docClass\">Ext.data.SortTypes</a>, {\n    asPerson: function(person){\n        // expects an object with a first and last name property\n        return person.lastName.toUpperCase() + person.firstName.toLowerCase();\n    }    \n});\n\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('Employee', {\n    extend: '<a href=\"#!/api/Ext.data.Model\" rel=\"Ext.data.Model\" class=\"docClass\">Ext.data.Model</a>',\n    fields: [{\n        name: 'person',\n        sortType: 'asPerson'\n    }, {\n        name: 'salary',\n        type: 'float' // sortType set to asFloat\n    }]\n});\n</code></pre>\n</p>\n\n</div><div class='members'><div class='members-section'><div class='definedBy'>Defined By</div><h3 class='members-title icon-property'>Properties</h3><div class='subsection'><div id='property-applyConfig' class='member first-child inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-property-applyConfig' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-property-applyConfig' class='name not-expandable'>applyConfig</a><span> : Object</span><strong class='private signature'>private</strong></div><div class='description'><div class='short'>\n</div><div class='long'>\n</div></div></div><div id='property-self' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-property-self' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-property-self' class='name expandable'>self</a><span> : <a href=\"#!/api/Ext.Class\" rel=\"Ext.Class\" class=\"docClass\">Ext.Class</a></span><strong class='protected signature'>protected</strong></div><div class='description'><div class='short'>Get the reference to the current class from which this object was instantiated. ...</div><div class='long'><p>Get the reference to the current class from which this object was instantiated. Unlike <a href=\"#!/api/Ext.Base-method-statics\" rel=\"Ext.Base-method-statics\" class=\"docClass\">statics</a>,\n<code>this.self</code> is scope-dependent and it's meant to be used for dynamic inheritance. See <a href=\"#!/api/Ext.Base-method-statics\" rel=\"Ext.Base-method-statics\" class=\"docClass\">statics</a>\nfor a detailed comparison</p>\n\n<pre><code><a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.Cat', {\n    statics: {\n        speciesName: 'Cat' // My.Cat.speciesName = 'Cat'\n    },\n\n    constructor: function() {\n        alert(this.self.speciesName); / dependent on 'this'\n\n        return this;\n    },\n\n    clone: function() {\n        return new this.self();\n    }\n});\n\n\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.SnowLeopard', {\n    extend: 'My.Cat',\n    statics: {\n        speciesName: 'Snow Leopard'         // My.SnowLeopard.speciesName = 'Snow Leopard'\n    }\n});\n\nvar cat = new My.Cat();                     // alerts 'Cat'\nvar snowLeopard = new My.SnowLeopard();     // alerts 'Snow Leopard'\n\nvar clone = snowLeopard.clone();\nalert(<a href=\"#!/api/Ext-method-getClassName\" rel=\"Ext-method-getClassName\" class=\"docClass\">Ext.getClassName</a>(clone));             // alerts 'My.SnowLeopard'\n</code></pre>\n</div></div></div><div id='property-stripTagsRE' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.data.SortTypes'>Ext.data.SortTypes</span><br/><a href='source/SortTypes.html#Ext-data-SortTypes-property-stripTagsRE' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.data.SortTypes-property-stripTagsRE' class='name expandable'>stripTagsRE</a><span> : RegExp</span></div><div class='description'><div class='short'>The regular expression used to strip tags ...</div><div class='long'><p>The regular expression used to strip tags</p>\n<p>Defaults to: <code>/&lt;\\/?[^&gt;]+&gt;/gi</code></p></div></div></div></div></div><div class='members-section'><div class='definedBy'>Defined By</div><h3 class='members-title icon-method'>Methods</h3><div class='subsection'><div id='method-addInheritableStatics' class='member first-child inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-addInheritableStatics' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-addInheritableStatics' class='name expandable'>addInheritableStatics</a>( <span class='pre'>Object members</span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'> ...</div><div class='long'>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>members</span> : Object<div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-asDate' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.data.SortTypes'>Ext.data.SortTypes</span><br/><a href='source/SortTypes.html#Ext-data-SortTypes-method-asDate' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.data.SortTypes-method-asDate' class='name expandable'>asDate</a>( <span class='pre'>Object s</span> ) : Number</div><div class='description'><div class='short'>Date sorting ...</div><div class='long'><p>Date sorting</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>s</span> : Object<div class='sub-desc'><p>The value being converted</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>Number</span><div class='sub-desc'><p>The comparison value</p>\n</div></li></ul></div></div></div><div id='method-asFloat' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.data.SortTypes'>Ext.data.SortTypes</span><br/><a href='source/SortTypes.html#Ext-data-SortTypes-method-asFloat' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.data.SortTypes-method-asFloat' class='name expandable'>asFloat</a>( <span class='pre'>Object s</span> ) : Number</div><div class='description'><div class='short'>Float sorting ...</div><div class='long'><p>Float sorting</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>s</span> : Object<div class='sub-desc'><p>The value being converted</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>Number</span><div class='sub-desc'><p>The comparison value</p>\n</div></li></ul></div></div></div><div id='method-asInt' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.data.SortTypes'>Ext.data.SortTypes</span><br/><a href='source/SortTypes.html#Ext-data-SortTypes-method-asInt' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.data.SortTypes-method-asInt' class='name expandable'>asInt</a>( <span class='pre'>Object s</span> ) : Number</div><div class='description'><div class='short'>Integer sorting ...</div><div class='long'><p>Integer sorting</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>s</span> : Object<div class='sub-desc'><p>The value being converted</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>Number</span><div class='sub-desc'><p>The comparison value</p>\n</div></li></ul></div></div></div><div id='method-asText' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.data.SortTypes'>Ext.data.SortTypes</span><br/><a href='source/SortTypes.html#Ext-data-SortTypes-method-asText' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.data.SortTypes-method-asText' class='name expandable'>asText</a>( <span class='pre'>Object s</span> ) : String</div><div class='description'><div class='short'>Strips all HTML tags to sort on text only ...</div><div class='long'><p>Strips all HTML tags to sort on text only</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>s</span> : Object<div class='sub-desc'><p>The value being converted</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>String</span><div class='sub-desc'><p>The comparison value</p>\n</div></li></ul></div></div></div><div id='method-asUCString' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.data.SortTypes'>Ext.data.SortTypes</span><br/><a href='source/SortTypes.html#Ext-data-SortTypes-method-asUCString' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.data.SortTypes-method-asUCString' class='name expandable'>asUCString</a>( <span class='pre'>Object s</span> ) : String</div><div class='description'><div class='short'>Case insensitive string ...</div><div class='long'><p>Case insensitive string</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>s</span> : Object<div class='sub-desc'><p>The value being converted</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>String</span><div class='sub-desc'><p>The comparison value</p>\n</div></li></ul></div></div></div><div id='method-asUCText' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.data.SortTypes'>Ext.data.SortTypes</span><br/><a href='source/SortTypes.html#Ext-data-SortTypes-method-asUCText' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.data.SortTypes-method-asUCText' class='name expandable'>asUCText</a>( <span class='pre'>Object s</span> ) : String</div><div class='description'><div class='short'>Strips all HTML tags to sort on text only - Case insensitive ...</div><div class='long'><p>Strips all HTML tags to sort on text only - Case insensitive</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>s</span> : Object<div class='sub-desc'><p>The value being converted</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>String</span><div class='sub-desc'><p>The comparison value</p>\n</div></li></ul></div></div></div><div id='method-callOverridden' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-callOverridden' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-callOverridden' class='name expandable'>callOverridden</a>( <span class='pre'>Array/Arguments args</span> ) : Object<strong class='protected signature'>protected</strong></div><div class='description'><div class='short'>Call the original method that was previously overridden with override\n\nExt.define('My.Cat', {\n    constructor: functi...</div><div class='long'><p>Call the original method that was previously overridden with <a href=\"#!/api/Ext.Base-static-method-override\" rel=\"Ext.Base-static-method-override\" class=\"docClass\">override</a></p>\n\n<pre><code><a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.Cat', {\n    constructor: function() {\n        alert(\"I'm a cat!\");\n\n        return this;\n    }\n});\n\nMy.Cat.override({\n    constructor: function() {\n        alert(\"I'm going to be a cat!\");\n\n        var instance = this.callOverridden();\n\n        alert(\"Meeeeoooowwww\");\n\n        return instance;\n    }\n});\n\nvar kitty = new My.Cat(); // alerts \"I'm going to be a cat!\"\n                          // alerts \"I'm a cat!\"\n                          // alerts \"Meeeeoooowwww\"\n</code></pre>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>args</span> : Array/Arguments<div class='sub-desc'><p>The arguments, either an array or the <code>arguments</code> object</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>Object</span><div class='sub-desc'><p>Returns the result after calling the overridden method</p>\n</div></li></ul></div></div></div><div id='method-callParent' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-callParent' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-callParent' class='name expandable'>callParent</a>( <span class='pre'>Array/Arguments args</span> ) : Object<strong class='protected signature'>protected</strong></div><div class='description'><div class='short'>Call the parent's overridden method. ...</div><div class='long'><p>Call the parent's overridden method. For example:</p>\n\n<pre><code><a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.own.A', {\n    constructor: function(test) {\n        alert(test);\n    }\n});\n\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.own.B', {\n    extend: 'My.own.A',\n\n    constructor: function(test) {\n        alert(test);\n\n        this.callParent([test + 1]);\n    }\n});\n\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.own.C', {\n    extend: 'My.own.B',\n\n    constructor: function() {\n        alert(\"Going to call parent's overriden constructor...\");\n\n        this.callParent(arguments);\n    }\n});\n\nvar a = new My.own.A(1); // alerts '1'\nvar b = new My.own.B(1); // alerts '1', then alerts '2'\nvar c = new My.own.C(2); // alerts \"Going to call parent's overriden constructor...\"\n                         // alerts '2', then alerts '3'\n</code></pre>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>args</span> : Array/Arguments<div class='sub-desc'><p>The arguments, either an array or the <code>arguments</code> object\nfrom the current method, for example: <code>this.callParent(arguments)</code></p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>Object</span><div class='sub-desc'><p>Returns the result from the superclass' method</p>\n</div></li></ul></div></div></div><div id='method-initConfig' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-initConfig' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-initConfig' class='name expandable'>initConfig</a>( <span class='pre'>Object config</span> ) : Object<strong class='protected signature'>protected</strong></div><div class='description'><div class='short'>Initialize configuration for this class. ...</div><div class='long'><p>Initialize configuration for this class. a typical example:</p>\n\n<pre><code><a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.awesome.Class', {\n    // The default config\n    config: {\n        name: 'Awesome',\n        isAwesome: true\n    },\n\n    constructor: function(config) {\n        this.initConfig(config);\n\n        return this;\n    }\n});\n\nvar awesome = new My.awesome.Class({\n    name: 'Super Awesome'\n});\n\nalert(awesome.getName()); // 'Super Awesome'\n</code></pre>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>config</span> : Object<div class='sub-desc'>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>Object</span><div class='sub-desc'><p>mixins The mixin prototypes as key - value pairs</p>\n</div></li></ul></div></div></div><div id='method-mixin' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-mixin' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-mixin' class='name expandable'>mixin</a>( <span class='pre'>Object name, Object cls</span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'>Used internally by the mixins pre-processor ...</div><div class='long'><p>Used internally by the mixins pre-processor</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>name</span> : Object<div class='sub-desc'>\n</div></li><li><span class='pre'>cls</span> : Object<div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-none' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.data.SortTypes'>Ext.data.SortTypes</span><br/><a href='source/SortTypes.html#Ext-data-SortTypes-method-none' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.data.SortTypes-method-none' class='name expandable'>none</a>( <span class='pre'>Object s</span> ) : Object</div><div class='description'><div class='short'>Default sort that does nothing ...</div><div class='long'><p>Default sort that does nothing</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>s</span> : Object<div class='sub-desc'><p>The value being converted</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>Object</span><div class='sub-desc'><p>The comparison value</p>\n</div></li></ul></div></div></div><div id='method-own' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-own' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-own' class='name expandable'>own</a>( <span class='pre'>Object name, Object value</span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'> ...</div><div class='long'>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>name</span> : Object<div class='sub-desc'>\n</div></li><li><span class='pre'>value</span> : Object<div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-ownMethod' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-ownMethod' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-ownMethod' class='name expandable'>ownMethod</a>( <span class='pre'>Object name, Object fn</span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'> ...</div><div class='long'>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>name</span> : Object<div class='sub-desc'>\n</div></li><li><span class='pre'>fn</span> : Object<div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-setConfig' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-setConfig' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-setConfig' class='name expandable'>setConfig</a>( <span class='pre'>Object config</span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'> ...</div><div class='long'>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>config</span> : Object<div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-statics' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-statics' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-statics' class='name expandable'>statics</a>( <span class='pre'></span> ) : <a href=\"#!/api/Ext.Class\" rel=\"Ext.Class\" class=\"docClass\">Ext.Class</a><strong class='protected signature'>protected</strong></div><div class='description'><div class='short'>Get the reference to the class from which this object was instantiated. ...</div><div class='long'><p>Get the reference to the class from which this object was instantiated. Note that unlike <a href=\"#!/api/Ext.Base-property-self\" rel=\"Ext.Base-property-self\" class=\"docClass\">self</a>,\n<code>this.statics()</code> is scope-independent and it always returns the class from which it was called, regardless of what\n<code>this</code> points to during run-time</p>\n\n<pre><code><a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.Cat', {\n    statics: {\n        totalCreated: 0,\n        speciesName: 'Cat' // My.Cat.speciesName = 'Cat'\n    },\n\n    constructor: function() {\n        var statics = this.statics();\n\n        alert(statics.speciesName);     // always equals to 'Cat' no matter what 'this' refers to\n                                        // equivalent to: My.Cat.speciesName\n\n        alert(this.self.speciesName);   // dependent on 'this'\n\n        statics.totalCreated++;\n\n        return this;\n    },\n\n    clone: function() {\n        var cloned = new this.self;                      // dependent on 'this'\n\n        cloned.groupName = this.statics().speciesName;   // equivalent to: My.Cat.speciesName\n\n        return cloned;\n    }\n});\n\n\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.SnowLeopard', {\n    extend: 'My.Cat',\n\n    statics: {\n        speciesName: 'Snow Leopard'     // My.SnowLeopard.speciesName = 'Snow Leopard'\n    },\n\n    constructor: function() {\n        this.callParent();\n    }\n});\n\nvar cat = new My.Cat();                 // alerts 'Cat', then alerts 'Cat'\n\nvar snowLeopard = new My.SnowLeopard(); // alerts 'Cat', then alerts 'Snow Leopard'\n\nvar clone = snowLeopard.clone();\nalert(<a href=\"#!/api/Ext-method-getClassName\" rel=\"Ext-method-getClassName\" class=\"docClass\">Ext.getClassName</a>(clone));         // alerts 'My.SnowLeopard'\nalert(clone.groupName);                 // alerts 'Cat'\n\nalert(My.Cat.totalCreated);             // alerts 3\n</code></pre>\n<h3 class='pa'>Returns</h3><ul><li><span class='pre'><a href=\"#!/api/Ext.Class\" rel=\"Ext.Class\" class=\"docClass\">Ext.Class</a></span><div class='sub-desc'>\n</div></li></ul></div></div></div></div></div></div></div>","html_meta":{"docauthor":null},"aliases":{},"superclasses":["Ext.Base"],"component":false,"tagname":"class","alternateClassNames":[],"inheritdoc":null,"mixedInto":[],"name":"Ext.data.SortTypes","extends":"Ext.Base","requires":[],"id":"class-Ext.data.SortTypes","parentMixins":[],"singleton":true,"statics":{"method":[],"property":[],"event":[],"css_var":[],"css_mixin":[],"cfg":[]}});