 /**
  * Error Model and View
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
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
			root: 'logs',
			totalProperty:'total'
		}
	},
	autoLoad: true
});