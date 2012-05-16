/*
 * Grid of triggers available to this user and dialogs to create and edit triggers.
 */
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