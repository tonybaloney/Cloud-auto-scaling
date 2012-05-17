 /**
  * Log Model and View
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
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
	autoLoad: false
});