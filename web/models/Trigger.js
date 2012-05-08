/*
 * Define the data set for the Trigger class, reflects the view in the DB.
 */
Ext.define('Trigger', {
	extend: 'Ext.data.Model',
	fields: [
		{name: 'customerId', type: 'int'}, // Customer UID
		{name: 'triggerId', type: 'int'}, // Trigger UID
		{name: 'triggerName', type: 'string'}, // Name/Type of the trigger
		{name: 'clusterId', type: 'int'}, // Internal cluster ID
		{name: 'clusterName', type: 'string'},	// Name of the cluster
		{name: 'upper', type: 'int'}, // Upper threshold to scale up, either CPU load av or RAM usage %
		{name: 'lower', type: 'int'}, // lower threshold to scale down, either CPU load av or RAM usage %
		{name: 'scaleUpTime', type: 'int'}, // Time in seconds to allow for a scale-up
		{name: 'scaleDownTime', type: 'int'}, // Time in seconds to allow for a scale-up
		{name: 'oid', type: 'string'},
		{name: 'communityString', type: 'string'}
	]
});
/*
 * Create a store to load the data from the DB, should only show this customer UID.
 */
Ext.create('Ext.data.Store', {
	model: 'Trigger',
	storeId : 'TriggerStore',
	proxy: {
		type: 'ajax',
		url : 'data.php?view=Trigger',
		reader: {
			type: 'json',
			root: 'triggers'
		}
	},
	autoLoad: true
});