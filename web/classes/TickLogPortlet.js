/*
 * Grid of triggers available to this user and dialogs to create and edit triggers.
 */
Ext.define('Cloud.TickLogPortlet', {
	ApproveTockAction: function (sender,event){
	
	},
	DeclineTockAction: function (sender,event){
		
	},
    extend: 'Ext.grid.Panel',
    height: 300,
    initComponent: function(){
        Ext.apply(this, {
            height: this.height,
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