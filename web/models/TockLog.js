 /**
  * Tock Log Model and View
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
Ext.define('TockLog', {
	extend: 'Ext.data.Model',
	fields: [
		{nane: 'ta_id', type: 'int'}, //Tock log id
		{name: 'customerId', type: 'int'}, // Customer UID
		{name: 'clusterId', type: 'int'}, // cluster ID
		{name: 'triggerName', type: 'string'},
		{name: 'triggerId', type: 'int'}, //trigger
		{name: 'action', type: 'string'}, //Message of the 
		{name: 'approval', type: 'string'},
		{name: 'date', type: 'string'}
	]
});
/*
 * Create a store to load the data from the DB, should only show this customer UID.
 */
Ext.create('Ext.data.Store', {
	model: 'TockLog',
	storeId : 'TockLogStore',
	proxy: {
		type: 'ajax',
		url : 'data.php?view=TockLog',
		reader: {
			type: 'json',
			root: 'logs'
		}
	},
	autoLoad: false
});