/*
 * Define the data set for the Log class, reflects the view in the DB.
 */
Ext.define('Location', {
	extend: 'Ext.data.Model',
	fields: [
		{name: 'clusterLocation', type: 'int'}, // Location ID
		{name: 'locationName', type: 'string'}, // Name of the location
	]
});
/*
 * Create a store to load the data from the DB, should only show this customer UID.
 */
Ext.create('Ext.data.Store', {
	model: 'Location',
	storeId : 'LocationStore',
	proxy: {
		type: 'ajax',
		url : 'data.php?view=Locations',
		reader: {
			type: 'json',
			root: 'locations'
		}
	},
	autoLoad: true
});