/*
 * Grid of triggers available to this user and dialogs to create and edit triggers.
 */
Ext.define('Cloud.TriggerPortlet', {
    extend: 'Ext.grid.Panel',
    height: 300,
	CreateTrigger : function (sender,event,triggerRecord/* If record is given this is an edit not a create */)	{
		var popup = new Ext.Window({	
			layout:'fit',
			width:320,
			height:439,
			closeAction:'hide',
			plain: true,
			resizable:true,
			iconCls:'icon-trigger',
			title: (triggerRecord?'Edit Trigger':'Create Trigger'),
			items: {
				xtype:'form',
				url:(triggerRecord?'form.php?form=SaveTrigger':'form.php?form=AddTrigger'),
				layout: {
					type: 'vbox',
					align: 'stretch'
				},
				border: false,
				bodyPadding: 10,
				fieldDefaults: {
					labelAlign: 'top',
					labelWidth: 100,
					labelStyle: 'font-weight:bold'
				},
				defaults: {
					margins: '0 0 10 0'
				},
				items: [
					{
						xtype:'combo',
						name:'clusterId',
						fieldLabel: 'Cluster Name',
						displayField: 'clusterName',
						valueField: 'clusterId',
						value: (triggerRecord?triggerRecord.data.clusterId:null),
						store: 'ClusterStore',
						queryMode: 'local',
						typeAhead: true,
						allowBlank: false
					},
					{
						xtype:'hiddenfield',
						name: 'triggerId',
						value: (triggerRecord?triggerRecord.data.triggerId:null)
					},
					{
						xtype:'combo',
						name:'triggerName',
						fieldLabel: 'Trigger Type',
						value: (triggerRecord?triggerRecord.data.triggerName:'cpu'),
						store : [ 'cpu','ram'],
						allowBlank: false
					},
					{
						xtype:'numberfield',
						name:'lower',
						value: (triggerRecord?triggerRecord.data.lower:0),
						fieldLabel: 'Lower Limit',
						allowBlank: false
					},
					{
						xtype:'numberfield',
						name:'upper',
						value: (triggerRecord?triggerRecord.data.upper:0),
						fieldLabel: 'Upper Limit',
						allowBlank: false
					},
					{
						xtype:'numberfield',
						name:'scaleUpTime',
						value: (triggerRecord?triggerRecord.data.scaleUpTime:120),
						fieldLabel: 'Scale Up Time (sec)',
						allowBlank: false
					},
					{
						xtype:'numberfield',
						name:'scaleDownTime',
						value: (triggerRecord?triggerRecord.data.scaleDownTime:120),
						fieldLabel: 'Scale Down Time (sec)',
						allowBlank: false
					}
				],
				buttons: [
					{ text:(triggerRecord?'Save Trigger':'Create Trigger'), handler: function(){
							this.up('form').getForm().submit({
								clientValidation: true,
								success: function(form, action) {
								   Ext.Msg.alert('Success', action.result.msg);
								   // refresh store.
								   Ext.data.StoreManager.lookup('TriggerStore').load();
								},
								failure: function(form, action) {
									Ext.Msg.alert('Failure', action.result.msg);
								}}); 
							popup.hide(); 
						}
					}
					//,{ text:'?',handler:function(){alert(this.up('window').height+'x'+this.up('window').width);}} // Window size 
					]
				}
			}); 
		popup.show(this);
		popup.center();
	},
    initComponent: function(){
        Ext.apply(this, {
            //height: 300,
            height: this.height,
            store: 'TriggerStore',
            stripeRows: true,
            columnLines: true,
            columns: [{
                id :'triggerName',
                text : 'Trigger',
                flex: 1,
                sortable : true,
                dataIndex: 'triggerName'
            },{
                text   : 'Lower',
                width    : 75,
                sortable : true,
                dataIndex: 'lower'
            },{
                text   : 'Upper',
                width    : 75,
                sortable : true,
                dataIndex: 'upper'
            }],
			dockedItems: [{
                xtype: 'toolbar',
                items: [{
                    text: 'Add',
                    scope: this,
                    handler: this.CreateTrigger,
					iconCls:'icon-add-trigger'
                }, {
                    text: 'Delete',
                    scope: this,
                    handler: this.onDeleteClick,
					iconCls:'icon-delete-trigger'
                },
				{
					text: 'Configure',
					scope:this,
					handler: function () { 
						this.CreateTrigger(this,null,(this.selModel.selected.length>0?this.selModel.selected.items[0]:null)) ;
					},
					iconCls:'icon-edit-trigger'
				}
				]
            }]
        });
        this.callParent(arguments);
    }
});