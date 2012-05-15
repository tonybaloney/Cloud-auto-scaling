Ext.data.JsonP.Ext_WindowManager({"subclasses":[],"files":[{"filename":"ZIndexManager.js","href":"ZIndexManager.html#Ext-WindowManager"}],"mixins":[],"code_type":"assignment","inheritable":false,"uses":[],"meta":{},"members":{"method":[{"meta":{"private":true},"tagname":"method","owner":"Ext.Base","name":"addInheritableStatics","id":"method-addInheritableStatics"},{"meta":{},"tagname":"method","owner":"Ext.ZIndexManager","name":"bringToFront","id":"method-bringToFront"},{"meta":{"protected":true},"tagname":"method","owner":"Ext.Base","name":"callOverridden","id":"method-callOverridden"},{"meta":{"protected":true},"tagname":"method","owner":"Ext.Base","name":"callParent","id":"method-callParent"},{"meta":{},"tagname":"method","owner":"Ext.ZIndexManager","name":"each","id":"method-each"},{"meta":{},"tagname":"method","owner":"Ext.ZIndexManager","name":"eachBottomUp","id":"method-eachBottomUp"},{"meta":{},"tagname":"method","owner":"Ext.ZIndexManager","name":"eachTopDown","id":"method-eachTopDown"},{"meta":{},"tagname":"method","owner":"Ext.ZIndexManager","name":"get","id":"method-get"},{"meta":{},"tagname":"method","owner":"Ext.ZIndexManager","name":"getActive","id":"method-getActive"},{"meta":{},"tagname":"method","owner":"Ext.ZIndexManager","name":"getBy","id":"method-getBy"},{"meta":{"private":true},"tagname":"method","owner":"Ext.ZIndexManager","name":"hide","id":"method-hide"},{"meta":{},"tagname":"method","owner":"Ext.ZIndexManager","name":"hideAll","id":"method-hideAll"},{"meta":{"protected":true},"tagname":"method","owner":"Ext.Base","name":"initConfig","id":"method-initConfig"},{"meta":{"private":true},"tagname":"method","owner":"Ext.Base","name":"mixin","id":"method-mixin"},{"meta":{"private":true},"tagname":"method","owner":"Ext.Base","name":"own","id":"method-own"},{"meta":{"private":true},"tagname":"method","owner":"Ext.Base","name":"ownMethod","id":"method-ownMethod"},{"meta":{},"tagname":"method","owner":"Ext.ZIndexManager","name":"register","id":"method-register"},{"meta":{},"tagname":"method","owner":"Ext.ZIndexManager","name":"sendToBack","id":"method-sendToBack"},{"meta":{"private":true},"tagname":"method","owner":"Ext.Base","name":"setConfig","id":"method-setConfig"},{"meta":{"private":true},"tagname":"method","owner":"Ext.ZIndexManager","name":"show","id":"method-show"},{"meta":{"protected":true},"tagname":"method","owner":"Ext.Base","name":"statics","id":"method-statics"},{"meta":{},"tagname":"method","owner":"Ext.ZIndexManager","name":"unregister","id":"method-unregister"}],"event":[],"property":[{"meta":{"private":true},"tagname":"property","owner":"Ext.Base","name":"applyConfig","id":"property-applyConfig"},{"meta":{"protected":true},"tagname":"property","owner":"Ext.Base","name":"self","id":"property-self"}],"css_var":[],"css_mixin":[],"cfg":[]},"html":"<div><pre class=\"hierarchy\"><h4>Hierarchy</h4><div class='subclass first-child'><a href='#!/api/Ext.Base' rel='Ext.Base' class='docClass'>Ext.Base</a><div class='subclass '><a href='#!/api/Ext.ZIndexManager' rel='Ext.ZIndexManager' class='docClass'>Ext.ZIndexManager</a><div class='subclass '><strong>Ext.WindowManager</strong></div></div></div><h4>Files</h4><div class='dependency'><a href='source/ZIndexManager.html#Ext-WindowManager' target='_blank'>ZIndexManager.js</a></div></pre><div class='doc-contents'><p>The default global floating Component group that is available automatically.</p>\n\n\n<p>This manages instances of floating Components which were rendered programatically without\nbeing added to a <a href=\"#!/api/Ext.container.Container\" rel=\"Ext.container.Container\" class=\"docClass\">Container</a>, and for floating Components which were added into non-floating Containers.</p>\n\n\n<p><i>Floating</i> Containers create their own instance of ZIndexManager, and floating Components added at any depth below\nthere are managed by that ZIndexManager.</p>\n\n</div><div class='members'><div class='members-section'><div class='definedBy'>Defined By</div><h3 class='members-title icon-property'>Properties</h3><div class='subsection'><div id='property-applyConfig' class='member first-child inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-property-applyConfig' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-property-applyConfig' class='name not-expandable'>applyConfig</a><span> : Object</span><strong class='private signature'>private</strong></div><div class='description'><div class='short'>\n</div><div class='long'>\n</div></div></div><div id='property-self' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-property-self' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-property-self' class='name expandable'>self</a><span> : <a href=\"#!/api/Ext.Class\" rel=\"Ext.Class\" class=\"docClass\">Ext.Class</a></span><strong class='protected signature'>protected</strong></div><div class='description'><div class='short'>Get the reference to the current class from which this object was instantiated. ...</div><div class='long'><p>Get the reference to the current class from which this object was instantiated. Unlike <a href=\"#!/api/Ext.Base-method-statics\" rel=\"Ext.Base-method-statics\" class=\"docClass\">statics</a>,\n<code>this.self</code> is scope-dependent and it's meant to be used for dynamic inheritance. See <a href=\"#!/api/Ext.Base-method-statics\" rel=\"Ext.Base-method-statics\" class=\"docClass\">statics</a>\nfor a detailed comparison</p>\n\n<pre><code><a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.Cat', {\n    statics: {\n        speciesName: 'Cat' // My.Cat.speciesName = 'Cat'\n    },\n\n    constructor: function() {\n        alert(this.self.speciesName); / dependent on 'this'\n\n        return this;\n    },\n\n    clone: function() {\n        return new this.self();\n    }\n});\n\n\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.SnowLeopard', {\n    extend: 'My.Cat',\n    statics: {\n        speciesName: 'Snow Leopard'         // My.SnowLeopard.speciesName = 'Snow Leopard'\n    }\n});\n\nvar cat = new My.Cat();                     // alerts 'Cat'\nvar snowLeopard = new My.SnowLeopard();     // alerts 'Snow Leopard'\n\nvar clone = snowLeopard.clone();\nalert(<a href=\"#!/api/Ext-method-getClassName\" rel=\"Ext-method-getClassName\" class=\"docClass\">Ext.getClassName</a>(clone));             // alerts 'My.SnowLeopard'\n</code></pre>\n</div></div></div></div></div><div class='members-section'><div class='definedBy'>Defined By</div><h3 class='members-title icon-method'>Methods</h3><div class='subsection'><div id='method-addInheritableStatics' class='member first-child inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-addInheritableStatics' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-addInheritableStatics' class='name expandable'>addInheritableStatics</a>( <span class='pre'>Object members</span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'> ...</div><div class='long'>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>members</span> : Object<div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-bringToFront' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.ZIndexManager' rel='Ext.ZIndexManager' class='defined-in docClass'>Ext.ZIndexManager</a><br/><a href='source/ZIndexManager.html#Ext-ZIndexManager-method-bringToFront' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.ZIndexManager-method-bringToFront' class='name expandable'>bringToFront</a>( <span class='pre'>String/Object comp</span> ) : Boolean</div><div class='description'><div class='short'>Brings the specified Component to the front of any other active Components in this ZIndexManager. ...</div><div class='long'><p>Brings the specified Component to the front of any other active Components in this ZIndexManager.</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>comp</span> : String/Object<div class='sub-desc'><p>The id of the Component or a <a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a> instance</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>Boolean</span><div class='sub-desc'><p>True if the dialog was brought to the front, else false\nif it was already in front</p>\n</div></li></ul></div></div></div><div id='method-callOverridden' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-callOverridden' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-callOverridden' class='name expandable'>callOverridden</a>( <span class='pre'>Array/Arguments args</span> ) : Object<strong class='protected signature'>protected</strong></div><div class='description'><div class='short'>Call the original method that was previously overridden with override\n\nExt.define('My.Cat', {\n    constructor: functi...</div><div class='long'><p>Call the original method that was previously overridden with <a href=\"#!/api/Ext.Base-static-method-override\" rel=\"Ext.Base-static-method-override\" class=\"docClass\">override</a></p>\n\n<pre><code><a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.Cat', {\n    constructor: function() {\n        alert(\"I'm a cat!\");\n\n        return this;\n    }\n});\n\nMy.Cat.override({\n    constructor: function() {\n        alert(\"I'm going to be a cat!\");\n\n        var instance = this.callOverridden();\n\n        alert(\"Meeeeoooowwww\");\n\n        return instance;\n    }\n});\n\nvar kitty = new My.Cat(); // alerts \"I'm going to be a cat!\"\n                          // alerts \"I'm a cat!\"\n                          // alerts \"Meeeeoooowwww\"\n</code></pre>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>args</span> : Array/Arguments<div class='sub-desc'><p>The arguments, either an array or the <code>arguments</code> object</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>Object</span><div class='sub-desc'><p>Returns the result after calling the overridden method</p>\n</div></li></ul></div></div></div><div id='method-callParent' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-callParent' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-callParent' class='name expandable'>callParent</a>( <span class='pre'>Array/Arguments args</span> ) : Object<strong class='protected signature'>protected</strong></div><div class='description'><div class='short'>Call the parent's overridden method. ...</div><div class='long'><p>Call the parent's overridden method. For example:</p>\n\n<pre><code><a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.own.A', {\n    constructor: function(test) {\n        alert(test);\n    }\n});\n\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.own.B', {\n    extend: 'My.own.A',\n\n    constructor: function(test) {\n        alert(test);\n\n        this.callParent([test + 1]);\n    }\n});\n\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.own.C', {\n    extend: 'My.own.B',\n\n    constructor: function() {\n        alert(\"Going to call parent's overriden constructor...\");\n\n        this.callParent(arguments);\n    }\n});\n\nvar a = new My.own.A(1); // alerts '1'\nvar b = new My.own.B(1); // alerts '1', then alerts '2'\nvar c = new My.own.C(2); // alerts \"Going to call parent's overriden constructor...\"\n                         // alerts '2', then alerts '3'\n</code></pre>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>args</span> : Array/Arguments<div class='sub-desc'><p>The arguments, either an array or the <code>arguments</code> object\nfrom the current method, for example: <code>this.callParent(arguments)</code></p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>Object</span><div class='sub-desc'><p>Returns the result from the superclass' method</p>\n</div></li></ul></div></div></div><div id='method-each' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.ZIndexManager' rel='Ext.ZIndexManager' class='defined-in docClass'>Ext.ZIndexManager</a><br/><a href='source/ZIndexManager.html#Ext-ZIndexManager-method-each' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.ZIndexManager-method-each' class='name expandable'>each</a>( <span class='pre'>Function fn, [Object scope]</span> )</div><div class='description'><div class='short'>Executes the specified function once for every Component in this ZIndexManager, passing each\nComponent as the only pa...</div><div class='long'><p>Executes the specified function once for every Component in this ZIndexManager, passing each\nComponent as the only parameter. Returning false from the function will stop the iteration.</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>fn</span> : Function<div class='sub-desc'><p>The function to execute for each item</p>\n</div></li><li><span class='pre'>scope</span> : Object (optional)<div class='sub-desc'><p>The scope (<code>this</code> reference) in which the function is executed. Defaults to the current Component in the iteration.</p>\n</div></li></ul></div></div></div><div id='method-eachBottomUp' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.ZIndexManager' rel='Ext.ZIndexManager' class='defined-in docClass'>Ext.ZIndexManager</a><br/><a href='source/ZIndexManager.html#Ext-ZIndexManager-method-eachBottomUp' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.ZIndexManager-method-eachBottomUp' class='name expandable'>eachBottomUp</a>( <span class='pre'>Function fn, [Object scope]</span> )</div><div class='description'><div class='short'>Executes the specified function once for every Component in this ZIndexManager, passing each\nComponent as the only pa...</div><div class='long'><p>Executes the specified function once for every Component in this ZIndexManager, passing each\nComponent as the only parameter. Returning false from the function will stop the iteration.\nThe components are passed to the function starting at the bottom and proceeding to the top.</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>fn</span> : Function<div class='sub-desc'><p>The function to execute for each item</p>\n</div></li><li><span class='pre'>scope</span> : Object (optional)<div class='sub-desc'><p>The scope (<code>this</code> reference) in which the function\nis executed. Defaults to the current Component in the iteration.</p>\n</div></li></ul></div></div></div><div id='method-eachTopDown' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.ZIndexManager' rel='Ext.ZIndexManager' class='defined-in docClass'>Ext.ZIndexManager</a><br/><a href='source/ZIndexManager.html#Ext-ZIndexManager-method-eachTopDown' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.ZIndexManager-method-eachTopDown' class='name expandable'>eachTopDown</a>( <span class='pre'>Function fn, [Object scope]</span> )</div><div class='description'><div class='short'>Executes the specified function once for every Component in this ZIndexManager, passing each\nComponent as the only pa...</div><div class='long'><p>Executes the specified function once for every Component in this ZIndexManager, passing each\nComponent as the only parameter. Returning false from the function will stop the iteration.\nThe components are passed to the function starting at the top and proceeding to the bottom.</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>fn</span> : Function<div class='sub-desc'><p>The function to execute for each item</p>\n</div></li><li><span class='pre'>scope</span> : Object (optional)<div class='sub-desc'><p>The scope (<code>this</code> reference) in which the function\nis executed. Defaults to the current Component in the iteration.</p>\n</div></li></ul></div></div></div><div id='method-get' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.ZIndexManager' rel='Ext.ZIndexManager' class='defined-in docClass'>Ext.ZIndexManager</a><br/><a href='source/ZIndexManager.html#Ext-ZIndexManager-method-get' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.ZIndexManager-method-get' class='name expandable'>get</a>( <span class='pre'>String/Object id</span> ) : <a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a></div><div class='description'><div class='short'>Gets a registered Component by id. ...</div><div class='long'><p>Gets a registered Component by id.</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>id</span> : String/Object<div class='sub-desc'><p>The id of the Component or a <a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a> instance</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'><a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a></span><div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-getActive' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.ZIndexManager' rel='Ext.ZIndexManager' class='defined-in docClass'>Ext.ZIndexManager</a><br/><a href='source/ZIndexManager.html#Ext-ZIndexManager-method-getActive' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.ZIndexManager-method-getActive' class='name expandable'>getActive</a>( <span class='pre'></span> ) : <a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a></div><div class='description'><div class='short'>Gets the currently-active Component in this ZIndexManager. ...</div><div class='long'><p>Gets the currently-active Component in this ZIndexManager.</p>\n<h3 class='pa'>Returns</h3><ul><li><span class='pre'><a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a></span><div class='sub-desc'><p>The active Component</p>\n</div></li></ul></div></div></div><div id='method-getBy' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.ZIndexManager' rel='Ext.ZIndexManager' class='defined-in docClass'>Ext.ZIndexManager</a><br/><a href='source/ZIndexManager.html#Ext-ZIndexManager-method-getBy' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.ZIndexManager-method-getBy' class='name expandable'>getBy</a>( <span class='pre'>Function fn, [Object scope]</span> ) : Array</div><div class='description'><div class='short'>Returns zero or more Components in this ZIndexManager using the custom search function passed to this method. ...</div><div class='long'><p>Returns zero or more Components in this ZIndexManager using the custom search function passed to this method.\nThe function should accept a single <a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a> reference as its only argument and should\nreturn true if the Component matches the search criteria, otherwise it should return false.</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>fn</span> : Function<div class='sub-desc'><p>The search function</p>\n</div></li><li><span class='pre'>scope</span> : Object (optional)<div class='sub-desc'><p>The scope (<code>this</code> reference) in which the function is executed. Defaults to the Component being tested.\nthat gets passed to the function if not specified)</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>Array</span><div class='sub-desc'><p>An array of zero or more matching windows</p>\n</div></li></ul></div></div></div><div id='method-hide' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.ZIndexManager' rel='Ext.ZIndexManager' class='defined-in docClass'>Ext.ZIndexManager</a><br/><a href='source/ZIndexManager.html#Ext-ZIndexManager-method-hide' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.ZIndexManager-method-hide' class='name expandable'>hide</a>( <span class='pre'></span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'>Temporarily hides all currently visible managed Components. ...</div><div class='long'><p>Temporarily hides all currently visible managed Components. This is for when\ndragging a Window which may manage a set of floating descendants in its ZIndexManager;\nthey should all be hidden just for the duration of the drag.</p>\n</div></div></div><div id='method-hideAll' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.ZIndexManager' rel='Ext.ZIndexManager' class='defined-in docClass'>Ext.ZIndexManager</a><br/><a href='source/ZIndexManager.html#Ext-ZIndexManager-method-hideAll' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.ZIndexManager-method-hideAll' class='name expandable'>hideAll</a>( <span class='pre'></span> )</div><div class='description'><div class='short'>Hides all Components managed by this ZIndexManager. ...</div><div class='long'><p>Hides all Components managed by this ZIndexManager.</p>\n</div></div></div><div id='method-initConfig' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-initConfig' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-initConfig' class='name expandable'>initConfig</a>( <span class='pre'>Object config</span> ) : Object<strong class='protected signature'>protected</strong></div><div class='description'><div class='short'>Initialize configuration for this class. ...</div><div class='long'><p>Initialize configuration for this class. a typical example:</p>\n\n<pre><code><a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.awesome.Class', {\n    // The default config\n    config: {\n        name: 'Awesome',\n        isAwesome: true\n    },\n\n    constructor: function(config) {\n        this.initConfig(config);\n\n        return this;\n    }\n});\n\nvar awesome = new My.awesome.Class({\n    name: 'Super Awesome'\n});\n\nalert(awesome.getName()); // 'Super Awesome'\n</code></pre>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>config</span> : Object<div class='sub-desc'>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>Object</span><div class='sub-desc'><p>mixins The mixin prototypes as key - value pairs</p>\n</div></li></ul></div></div></div><div id='method-mixin' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-mixin' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-mixin' class='name expandable'>mixin</a>( <span class='pre'>Object name, Object cls</span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'>Used internally by the mixins pre-processor ...</div><div class='long'><p>Used internally by the mixins pre-processor</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>name</span> : Object<div class='sub-desc'>\n</div></li><li><span class='pre'>cls</span> : Object<div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-own' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-own' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-own' class='name expandable'>own</a>( <span class='pre'>Object name, Object value</span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'> ...</div><div class='long'>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>name</span> : Object<div class='sub-desc'>\n</div></li><li><span class='pre'>value</span> : Object<div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-ownMethod' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-ownMethod' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-ownMethod' class='name expandable'>ownMethod</a>( <span class='pre'>Object name, Object fn</span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'> ...</div><div class='long'>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>name</span> : Object<div class='sub-desc'>\n</div></li><li><span class='pre'>fn</span> : Object<div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-register' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.ZIndexManager' rel='Ext.ZIndexManager' class='defined-in docClass'>Ext.ZIndexManager</a><br/><a href='source/ZIndexManager.html#Ext-ZIndexManager-method-register' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.ZIndexManager-method-register' class='name expandable'>register</a>( <span class='pre'><a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a> comp</span> )</div><div class='description'><div class='short'>Registers a floating Ext.Component with this ZIndexManager. ...</div><div class='long'><p>Registers a floating <a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a> with this ZIndexManager. This should not\nneed to be called under normal circumstances. Floating Components (such as Windows, BoundLists and Menus) are automatically registered\nwith a <a href=\"#!/api/Ext.Component-property-zIndexManager\" rel=\"Ext.Component-property-zIndexManager\" class=\"docClass\">zIndexManager</a> at render time.</p>\n\n\n<p>Where this may be useful is moving Windows between two ZIndexManagers. For example,\nto bring the <a href=\"#!/api/Ext.MessageBox\" rel=\"Ext.MessageBox\" class=\"docClass\">Ext.MessageBox</a> dialog under the same manager as the Desktop's\nZIndexManager in the desktop sample app:</p>\n\n\n<p><code></p>\n\n<pre>MyDesktop.getDesktop().getManager().register(<a href=\"#!/api/Ext.MessageBox\" rel=\"Ext.MessageBox\" class=\"docClass\">Ext.MessageBox</a>);\n</pre>\n\n\n<p></code></p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>comp</span> : <a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a><div class='sub-desc'><p>The Component to register.</p>\n</div></li></ul></div></div></div><div id='method-sendToBack' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.ZIndexManager' rel='Ext.ZIndexManager' class='defined-in docClass'>Ext.ZIndexManager</a><br/><a href='source/ZIndexManager.html#Ext-ZIndexManager-method-sendToBack' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.ZIndexManager-method-sendToBack' class='name expandable'>sendToBack</a>( <span class='pre'>String/Object comp</span> ) : <a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a></div><div class='description'><div class='short'>Sends the specified Component to the back of other active Components in this ZIndexManager. ...</div><div class='long'><p>Sends the specified Component to the back of other active Components in this ZIndexManager.</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>comp</span> : String/Object<div class='sub-desc'><p>The id of the Component or a <a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a> instance</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'><a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a></span><div class='sub-desc'><p>The Component</p>\n</div></li></ul></div></div></div><div id='method-setConfig' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-setConfig' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-setConfig' class='name expandable'>setConfig</a>( <span class='pre'>Object config</span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'> ...</div><div class='long'>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>config</span> : Object<div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-show' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.ZIndexManager' rel='Ext.ZIndexManager' class='defined-in docClass'>Ext.ZIndexManager</a><br/><a href='source/ZIndexManager.html#Ext-ZIndexManager-method-show' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.ZIndexManager-method-show' class='name expandable'>show</a>( <span class='pre'></span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'>Restores temporarily hidden managed Components to visibility. ...</div><div class='long'><p>Restores temporarily hidden managed Components to visibility.</p>\n</div></div></div><div id='method-statics' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.Base' rel='Ext.Base' class='defined-in docClass'>Ext.Base</a><br/><a href='source/Base3.html#Ext-Base-method-statics' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Base-method-statics' class='name expandable'>statics</a>( <span class='pre'></span> ) : <a href=\"#!/api/Ext.Class\" rel=\"Ext.Class\" class=\"docClass\">Ext.Class</a><strong class='protected signature'>protected</strong></div><div class='description'><div class='short'>Get the reference to the class from which this object was instantiated. ...</div><div class='long'><p>Get the reference to the class from which this object was instantiated. Note that unlike <a href=\"#!/api/Ext.Base-property-self\" rel=\"Ext.Base-property-self\" class=\"docClass\">self</a>,\n<code>this.statics()</code> is scope-independent and it always returns the class from which it was called, regardless of what\n<code>this</code> points to during run-time</p>\n\n<pre><code><a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.Cat', {\n    statics: {\n        totalCreated: 0,\n        speciesName: 'Cat' // My.Cat.speciesName = 'Cat'\n    },\n\n    constructor: function() {\n        var statics = this.statics();\n\n        alert(statics.speciesName);     // always equals to 'Cat' no matter what 'this' refers to\n                                        // equivalent to: My.Cat.speciesName\n\n        alert(this.self.speciesName);   // dependent on 'this'\n\n        statics.totalCreated++;\n\n        return this;\n    },\n\n    clone: function() {\n        var cloned = new this.self;                      // dependent on 'this'\n\n        cloned.groupName = this.statics().speciesName;   // equivalent to: My.Cat.speciesName\n\n        return cloned;\n    }\n});\n\n\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('My.SnowLeopard', {\n    extend: 'My.Cat',\n\n    statics: {\n        speciesName: 'Snow Leopard'     // My.SnowLeopard.speciesName = 'Snow Leopard'\n    },\n\n    constructor: function() {\n        this.callParent();\n    }\n});\n\nvar cat = new My.Cat();                 // alerts 'Cat', then alerts 'Cat'\n\nvar snowLeopard = new My.SnowLeopard(); // alerts 'Cat', then alerts 'Snow Leopard'\n\nvar clone = snowLeopard.clone();\nalert(<a href=\"#!/api/Ext-method-getClassName\" rel=\"Ext-method-getClassName\" class=\"docClass\">Ext.getClassName</a>(clone));         // alerts 'My.SnowLeopard'\nalert(clone.groupName);                 // alerts 'Cat'\n\nalert(My.Cat.totalCreated);             // alerts 3\n</code></pre>\n<h3 class='pa'>Returns</h3><ul><li><span class='pre'><a href=\"#!/api/Ext.Class\" rel=\"Ext.Class\" class=\"docClass\">Ext.Class</a></span><div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-unregister' class='member  inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><a href='#!/api/Ext.ZIndexManager' rel='Ext.ZIndexManager' class='defined-in docClass'>Ext.ZIndexManager</a><br/><a href='source/ZIndexManager.html#Ext-ZIndexManager-method-unregister' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.ZIndexManager-method-unregister' class='name expandable'>unregister</a>( <span class='pre'><a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a> comp</span> )</div><div class='description'><div class='short'>Unregisters a Ext.Component from this ZIndexManager. ...</div><div class='long'><p>Unregisters a <a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a> from this ZIndexManager. This should not\nneed to be called. Components are automatically unregistered upon destruction.\nSee <a href=\"#!/api/Ext.ZIndexManager-method-register\" rel=\"Ext.ZIndexManager-method-register\" class=\"docClass\">register</a>.</p>\n\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>comp</span> : <a href=\"#!/api/Ext.Component\" rel=\"Ext.Component\" class=\"docClass\">Ext.Component</a><div class='sub-desc'><p>The Component to unregister.</p>\n</div></li></ul></div></div></div></div></div></div></div>","html_meta":{},"aliases":{},"superclasses":["Ext.Base","Ext.ZIndexManager"],"component":false,"tagname":"class","alternateClassNames":[],"inheritdoc":null,"mixedInto":[],"name":"Ext.WindowManager","extends":"Ext.ZIndexManager","requires":[],"id":"class-Ext.WindowManager","parentMixins":[],"singleton":true,"statics":{"method":[],"property":[],"event":[],"css_var":[],"css_mixin":[],"cfg":[]}});