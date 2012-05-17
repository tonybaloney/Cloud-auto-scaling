 /**
  * Grid of Tock actions 
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
Ext.define('Cloud.TockLogPortlet', {
	ApproveTockAction: function (sender,event){
		var b=sender.ownerCt.ownerCt.selModel.getSelection();
		var id = b[0].raw.ta_id;
		Ext.Ajax.request({
			url: 'form.php',
			params: {
				form:'ApproveTock',
				ta_id:id
			},
			success: function(form,action){
				var x = Ext.StoreManager.lookup('TockLogStore');
				Ext.StoreManager.lookup('TockLogStore').load(x.lastParams);
			}
		});
	},
	DeclineTockAction: function (sender,event){
		var b=sender.ownerCt.ownerCt.selModel.getSelection();
		var id = b[0].raw.ta_id;
		Ext.Ajax.request({
			url: 'form.php',
			params: {
				form:'DeclineTock',
				ta_id:id
			},
			success: function(form,action){
				var x = Ext.StoreManager.lookup('TockLogStore');
				Ext.StoreManager.lookup('TockLogStore').load(x.lastParams);
			}
		});
	},
    extend: 'Ext.grid.Panel',
    initComponent: function(){
        Ext.apply(this, {
            height: this.height,
			flex:1,
            store: 'TockLogStore',
			title: 'Tock Logs (Scaling actions)',
			iconCls: 'icon-tock-logs',
			id: 'tock-logs',
			border:false,
            stripeRows: true,
            columnLines: true,
			listeners: {
				'select': function(sender,selected){
					if( selected.data.approval == 'PENDING') { 
						Ext.getCmp('ApproveButton').enable();
						Ext.getCmp('DeclineButton').enable();
					} else { 
						Ext.getCmp('ApproveButton').disable();
						Ext.getCmp('DeclineButton').disable();					
					}
				}
			},
            columns: [{
                text   : 'Date',
                flex: 1,
                sortable : true,
                dataIndex: 'date'
            },{
                text : 'Trigger',
                flex: 2,
                sortable : true,
                dataIndex: 'triggerName'
            },{
                text   : 'Action',
                flex: 1,
                sortable : true,
                dataIndex: 'action'
            },{
                text   : 'Status',
                flex: 1,
                sortable : true,
                dataIndex: 'approval'
            }],
			dockedItems: [{
                xtype: 'toolbar',
                items: [{
                    text: 'Approve',
					id:'ApproveButton',
					disabled:true,
                    handler: this.ApproveTockAction,
					iconCls:'icon-approve'
                },{
                    text: 'Decline',
					id:'DeclineButton',
					disabled:true,
                    handler: this.DeclineTockAction,
					iconCls:'icon-decline'
                }
				]
            }]
        });
        this.callParent(arguments);
    }
});