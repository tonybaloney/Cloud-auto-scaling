 /**
  * Tick Log View
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
Ext.create('Ext.data.JsonStore', {
	storeId: 'TickLogStore',
	fields: ['tl_id', 'result','vmId','vmName','date'],
	proxy: {
		type: 'ajax',
		url : 'data.php?view=TickLog',
		reader: {
			type: 'json',
			root: 'logs'
		}
	},
	autoLoad: false
})