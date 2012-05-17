/**
  * Customer Model and View
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
Ext.define('Customer', {
	extend: 'Ext.data.Model',
	fields: [
		{name: 'customerId', type: 'int'}, // Customer UID
		{name: 'portalAPIUrl', type: 'string'},
		{name: 'portalUsername', type: 'string'},
		{name: 'portalPassword', type: 'string'},
		{name: 'apiType', type: 'string'}
	]
});
/*
 * Create a store to load the data from the DB, should only show this customer UID.
 */
Ext.create('Ext.data.Store', {
	model: 'Customer',
	storeId : 'CustomerStore',
	proxy: {
		type: 'ajax',
		url : 'data.php?view=Customer',
		reader: {
			type: 'json',
			root: 'customers'
		}
	},
	autoLoad: true
});