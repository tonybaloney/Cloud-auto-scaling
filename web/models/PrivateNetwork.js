/*
 * Define the data set for the Log class, reflects the view in the DB.
 */
Ext.define('PrivateNetwork', {
	extend: 'Ext.data.Model',
	fields: [
		{name: 'networkId', type: 'int'}, // Location ID
		{name: 'networkName', type: 'string'}, // Name of the location
	]
});
/*
 * Create a store to load the data from the DB, should only show this customer UID.
 */
Ext.create('Ext.data.Store', {
	model: 'PrivateNetwork',
	storeId : 'PrivateNetworkStore',
	proxy: {
		type: 'ajax',
		url : 'data.php?view=PrivateNetworks',
		reader: {
			type: 'json',
			root: 'networks'
		}
	},
	autoLoad: false
});