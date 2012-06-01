 /**
  * Template Model and View 
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
Ext.define('Template', {
	extend: 'Ext.data.Model',
	fields: [
		{name: 'name', type: 'string'}, 
		{name: 'description', type: 'string'},
		{name: 'url', type: 'string'},
		{name: 'icon', type: 'string'}
	]
});
/*
 * Create a store to load the data from the DB, should only show this customer UID.
 */
Ext.create('Ext.data.Store', {
	model: 'Template',
	storeId : 'TemplateStore',
	proxy: {
		type: 'ajax',
		url : 'data.php?view=Templates',
		reader: {
			type: 'json',
			root: 'templates'
		}
	},
	autoLoad: true
});