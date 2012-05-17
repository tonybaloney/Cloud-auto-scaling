 /**
  * Private Network Model and View
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
Ext.define('PrivateNetwork', {
	extend: 'Ext.data.Model',
	fields: [
		{name: 'networkId', type: 'int'}, // Location ID
		{name: 'networkName', type: 'string'}, // Name of the location
		{name: 'networkAddress', type: 'string'}, // Network address e.g. 192.168.1.0
		{name: 'networkMask', type: 'int'}, // Network mask e.g. '24' for /24
		{name: 'networkDescription', type: 'string'}
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