/*
 * Grid of triggers available to this user and dialogs to create and edit triggers.
 */
Ext.define('Cloud.LogPortlet', {
    extend: 'Ext.grid.Panel',
    height: 150,
    initComponent: function(){
        Ext.apply(this, {
            height: this.height,
            store: 'LogStore',
            stripeRows: true,
            columnLines: true,
            columns: [{
                text : 'Trigger',
                flex: 1,
                sortable : true,
                dataIndex: 'triggerName'
            },{
                text   : 'Message',
                flex: 2,
                sortable : true,
                dataIndex: 'message'
            }]
        });
        this.callParent(arguments);
    }
});