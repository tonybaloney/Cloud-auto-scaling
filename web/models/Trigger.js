 /**
  * Trigger Model and View 
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
Ext.define('Trigger', {
	extend: 'Ext.data.Model',
	fields: [
		{name: 'customerId', type: 'int'}, // Customer UID
		{name: 'triggerId', type: 'int'}, // Trigger UID
		{name: 'triggerName', type: 'string'}, // Name/Type of the trigger
		{name: 'clusterId', type: 'int'}, // Internal cluster ID
		{name: 'clusterName', type: 'string'},	// Name of the cluster
		{name: 'upper', type: 'float'}, // Upper threshold to scale up, either CPU load av or RAM usage %
		{name: 'lower', type: 'float'}, // lower threshold to scale down, either CPU load av or RAM usage %
		{name: 'scaleUpTime', type: 'int'}, // Time in seconds to allow for a scale-up
		{name: 'scaleDownTime', type: 'int'}, // Time in seconds to allow for a scale-up
		{name: 'oid', type: 'string'},
		{name: 'communityString', type: 'string'},
		{name: 'vmPrefix', type: 'string'},
		{name: 'triggerApproval', type: 'string'},
		{name: 'clusterVmCount', type: 'int'}
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
	autoLoad: false
});