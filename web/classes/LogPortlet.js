/*
 * Grid of triggers available to this user and dialogs to create and edit triggers.
 */
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
    height: 300,
    initComponent: function(){
        Ext.apply(this, {
            height: this.height,
            store: 'TockLogStore',
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