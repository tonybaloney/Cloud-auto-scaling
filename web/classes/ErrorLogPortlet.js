/*
 * Grid of triggers available to this user and dialogs to create and edit triggers.
 */
Ext.define('Cloud.ErrorLogPortlet', {
    extend: 'Ext.grid.Panel',
    height: 250,
    initComponent: function(){
        Ext.apply(this, {
            height: this.height,
            store: 'ErrorLogStore',
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
            }]
        });
        this.callParent(arguments);
    }
});