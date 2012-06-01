/**
  * Define the data set for the Cluster class, reflects the view in the DB.
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
Ext.define('Cluster', {
	extend: 'Ext.data.Model',
	fields: [
		{name: 'clusterId', type: 'int'}, // UID of the cluster
		{name: 'clusterName', type: 'string'}, // Friendly name of the cluster
		{name: 'clusterLocation', type: 'int'}, // ID of the cluster location
        {name: 'customerId', type: 'int'}, // UID of the user/customer
		{name: 'minServers', type: 'int'}, // Minimum number of servers required in cluster
		{name: 'maxServers', type: 'int'}, // Maximum number of servers required in cluster
		{name: 'targetVlanId', type: 'int'}, // Target VLAN ID (ID in backend, will lookup on name change)
		{name: 'targetSecondaryVlanId', type: 'int'}, // Target VLAN ID (ID in backend, will lookup on name change)
		{name: 'targetVlanName', type: 'string'}, // Target VLAN Name
		{name: 'targetApplianceId', type: 'int'}, // Target Virtual Appliance ID, 
		{name: 'targetApplianceName', type: 'string'}, // Target Virtual Appliance Name
		{name: 'dateCreated', type: 'string'}, // Date the cluster was created 
		{name: 'dateChanged', type: 'string'}, // Date the cluster was last changed.
		{name: 'clusterEmailAlerts', type: 'string'}, // Email to send alerts to
		{name: 'templateUrl', type: 'string'}
	]
});
/*
 * Create a store to load the data from the DB, should only show this customer UID.
 */
Ext.create('Ext.data.Store', {
	model: 'Cluster',
	storeId : 'ClusterStore',
	proxy: {
		type: 'ajax',
		url : 'data.php?view=Cluster',
		reader: {
			type: 'json',
			root: 'clusters'
		}
	},
	autoLoad: true
});