 /**
  * Virtual Appliance Model and View
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
Ext.define('VirtualAppliance', {
	extend: 'Ext.data.Model',
	fields: [
		{name: 'applianceId', type: 'int'}, // appliance ID
		{name: 'applianceName', type: 'string'}, // Name of the appliance
		{name: 'applianceState', type: 'string'} // State of the appliance deployed/not deployed
	]
});
/*
 * Create a store to load the data from the DB, should only show this customer UID.
 */
Ext.create('Ext.data.Store', {
	model: 'VirtualAppliance',
	storeId : 'VirtualApplianceStore',
	proxy: {
		type: 'ajax',
		url : 'data.php?view=VirtualAppliances',
		reader: {
			type: 'json',
			root: 'appliances'
		}
	},
	autoLoad: false
});