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
			height:548,
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
						xtype:'textfield',
						name:'triggerName',
						fieldLabel: 'Trigger Name',
						value: (triggerRecord?triggerRecord.data.triggerName:'cpu'),
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
					},{
						xtype:'combo',
						name:'oid',
						fieldLabel: 'SNMP OID',
						value: (triggerRecord?triggerRecord.data.oid:'1.1.1.1.1'),
						displayField:'title',
						valueField:'oid',
						store: 'snmpOptions',
						queryMode: 'local',
						typeAhead: true,
						allowBlank: false
					},{
						xtype:'textfield',
						name:'communityString',
						fieldLabel: 'SNMP Community String',
						value: (triggerRecord?triggerRecord.data.communityString:''),
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
		Ext.define('SNMP', {
			extend: 'Ext.data.Model',
			fields: [
				{name: 'oid', type: 'string'},
				{name: 'title',  type: 'string'}
			]
		});

		Ext.create('Ext.data.Store', {
			storeId: 'snmpOptions',
			model: 'SNMP',
			data : [
				{oid:".1.3.6.1.4.1.2021.10.1.3.1",title:"Linux/1 Min Load Average"},
				{oid:".1.3.6.1.4.1.2021.10.1.3.2",title:"Linux/5 Min Load Average"},
				{oid:".1.3.6.1.4.1.2021.10.1.3.3",title:"Linux/15 Min Load Average"},
				{oid:".1.3.6.1.4.1.2021.11.9.0",title:"% of user CPU time"},
				{oid:".1.3.6.1.4.1.2021.11.50.0",title:"Raw user CPU time"},
				{oid:".1.3.6.1.4.1.2021.4.3.0",title:"Total Swap Size"},
				{oid:".1.3.6.1.4.1.2021.4.4.0",title:"Available Swap Space"},
				{oid:".1.3.6.1.4.1.2021.4.6.0",title:"Total RAM used"},
				{oid:".1.3.6.1.4.1.2021.4.11.0",title:"Total RAM free"}
				]
		});
        Ext.apply(this, {
            //height: 300,
            height: this.height,
            store: 'TriggerStore',
            stripeRows: true,
            columnLines: true,
            columns: [
			{
                text : 'Cluster',
                flex: 1,
                sortable : true,
                dataIndex: 'clusterName'
            },{
                text : 'Metric',
                flex: 2,
                sortable : true,
                dataIndex: 'oid',
				renderer : function (val, met,rec){
					return Ext.data.StoreManager.lookup('snmpOptions').findRecord('oid',val).data.title ; 
				}
            },{
                text : 'Trigger',
                flex: 2,
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