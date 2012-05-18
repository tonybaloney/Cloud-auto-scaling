 /**
  * Grid of triggers available to this user and dialogs to create and edit triggers.
  * all are of the format ?form.php?form=[Add|Save][Cluster|Trigger|Customer]
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
Ext.define('Cloud.ErrorLogPortlet', {
    extend: 'Ext.grid.Panel',
    initComponent: function(){
        Ext.apply(this, {
            height: this.height,
			flex:1,
			title: 'Error Logs',
			iconCls:'icon-error-logs',
            store: 'ErrorLogStore',
			border:false,
			autoScroll:true,
            stripeRows: true,
            columnLines: true,
			listeners: {
				'itemdblclick': function (t,rec){
					Ext.Msg.alert("Error message",rec.data.message);
				}
			},
            columns: [{
                text   : 'Date',
                flex: 1,
                sortable : true,
                dataIndex: 'date'
            },{
                text   : 'Message',
                flex: 3,
                sortable : true,
                dataIndex: 'message'
            }],
			bbar: Ext.create('Ext.PagingToolbar', {
				store: 'ErrorLogStore',
				displayInfo: true,
				displayMsg: 'Displaying logs {0} - {1} of {2}',
				emptyMsg: "No logs to display"
			})
        });
        this.callParent(arguments);
    }
});