/*
 * Define the data set for the Log class, reflects the view in the DB.
 */
Ext.define('Log', {
	extend: 'Ext.data.Model',
	fields: [
		{name: 'customerId', type: 'int'}, // Customer UID
		{name: 'clusterId', type: 'int'}, // cluster ID
		{name: 'clusterName', type: 'string'},
		{name: 'triggerName', type: 'string'},
		{name: 'triggerId', type: 'int'}, //trigger
		{name: 'message', type: 'string'} //Message of the 
	]
});
/*
 * Create a store to load the data from the DB, should only show this customer UID.
 */
Ext.create('Ext.data.Store', {
	model: 'Log',
	storeId : 'LogStore',
	proxy: {
		type: 'ajax',
		url : 'data.php?view=Log',
		reader: {
			type: 'json',
			root: 'logs'
		}
	},
	autoLoad: true
});