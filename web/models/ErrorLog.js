/*
 * Define the data set for the Log class, reflects the view in the DB.
 */
Ext.define('ErrorLog', {
	extend: 'Ext.data.Model',
	fields: [
		{name: 'customerId', type: 'int'}, // Customer UID
		{name: 'date', type: 'string'},
		{name: 'message', type: 'string'} //Message of the 
	]
});
/*
 * Create a store to load the data from the DB, should only show this customer UID.
 */
Ext.create('Ext.data.Store', {
	model: 'ErrorLog',
	storeId : 'ErrorLogStore',
	proxy: {
		type: 'ajax',
		url : 'data.php?view=ErrorLog',
		reader: {
			type: 'json',
			root: 'logs'
		}
	},
	autoLoad: true
});