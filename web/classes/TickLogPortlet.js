/*
 * Grid of triggers available to this user and dialogs to create and edit triggers.
 */
Ext.define('Cloud.TickLogPortlet', {
	ApproveTockAction: function (sender,event){
	
	},
	DeclineTockAction: function (sender,event){
		
	},
    extend: 'Ext.grid.Panel',
    initComponent: function(){
        Ext.apply(this, {
			title: 'Tick Logs (Trigger results)',
			iconCls:'icon-chart',
			border:false,
			id:'tick-logs',
            height: this.height,
			flex:1,
            store: 'TickLogStore',
            stripeRows: true,
            columnLines: true,
            columns: [{
                text   : 'Date',
                flex: 1,
                sortable : true,
                dataIndex: 'date'
            },{
                text   : 'VM',
                flex: 1,
                sortable : true,
                dataIndex: 'vmName'
            },{
                text   : 'Result',
                flex: 1,
                sortable : true,
                dataIndex: 'result'
            }]			
        });
        this.callParent(arguments);
    }
});