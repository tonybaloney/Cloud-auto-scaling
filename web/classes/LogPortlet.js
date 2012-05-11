/*
 * Grid of triggers available to this user and dialogs to create and edit triggers.
 */
Ext.define('Cloud.TockLogPortlet', {
	ApproveTockAction: function (sender,event){
	
	},
	DeclineTockAction: function (sender,event){
		
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
				'select': function(){
					Ext.getCmp('ApproveButton').enable();
					Ext.getCmp('DeclineButton').enable();
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
                    scope: this,
                    handler: this.ApproveTockAction,
					iconCls:'icon-approve'
                },{
                    text: 'Decline',
					id:'DeclineButton',
					disabled:true,
                    scope: this,
                    handler: this.DeclineTockAction,
					iconCls:'icon-decline'
                }
				]
            }]
        });
        this.callParent(arguments);
    }
});