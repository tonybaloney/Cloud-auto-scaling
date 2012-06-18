  /**
  * Grid of Triggers
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
Ext.define('Cloud.TriggerPortlet', {
    extend: 'Ext.grid.Panel',
	DeleteTrigger: function (sender,event){
		var b=sender.ownerCt.ownerCt.selModel.getSelection();
		var id = b[0].raw.triggerId;
		Ext.Ajax.request({
			url: 'form.php',
			params: {
				form:'DeleteTrigger',
				triggerId:id
			},
			success: function(form,action){
				var x = Ext.StoreManager.lookup('TriggerStore');
				Ext.StoreManager.lookup('TriggerStore').load(x.lastParams);
			}
		});
	},
	ForceScaleUp: function (sender,event){
		var b=sender.ownerCt.ownerCt.selModel.getSelection();
		var id = b[0].raw.triggerId;
		Ext.Ajax.request({
			url: 'form.php',
			params: {
				form:'TriggerForceScale',
				direction:'SCALE_UP',
				triggerId:id
			},
			success: function(form,action){
				var x = Ext.StoreManager.lookup('TickLogStore');
				Ext.StoreManager.lookup('TickLogStore').load(x.lastParams);
			}
		});
	},
	ForceScaleDown: function (sender,event){
		var b=sender.ownerCt.ownerCt.selModel.getSelection();
		var id = b[0].raw.triggerId;
		Ext.Ajax.request({
			url: 'form.php',
			params: {
				form:'TriggerForceScale',
				direction:'SCALE_DOWN',
				triggerId:id
			},
			success: function(form,action){
				var x = Ext.StoreManager.lookup('TickLogStore');
				Ext.StoreManager.lookup('TickLogStore').load(x.lastParams);
			}
		});
	},
	CreateTrigger : function (sender,event,triggerRecord/* If record is given this is an edit not a create */)	{
		var popup = new Ext.Window({	
			layout:'fit',
			width:560,
			height:306,
			closeAction:'hide',
			plain: true,
			resizable:true,
			iconCls:'icon-trigger',
			title: (triggerRecord?'Edit Trigger':'Create Trigger'),
			items: {
				xtype:'form',
				url:(triggerRecord?'form.php?form=SaveTrigger':'form.php?form=AddTrigger'),
				layout: {
					type: 'hbox',
					align: 'stretch',
					border:false
				},
				border: false,
				bodyPadding: 10,
				fieldDefaults: {
					labelAlign: 'top',
					labelWidth: 100,
					labelStyle: 'font-weight:bold'
				},
				defaults: {
					border: false,
					xtype: 'panel',
					flex: 1,
					layout: 'anchor'
				},
				items: [{
					border: false,
					items:[
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
							name:'priority',
							value: (triggerRecord?triggerRecord.data.priority:1),
							fieldLabel: 'Priority (highest first)',
							allowDecimals:false,
							minValue:0,
							allowBlank: false
						}
					]},{
					border: false,
					items:[
						{
							xtype:'numberfield',
							name:'lower',
							value: (triggerRecord?triggerRecord.data.lower:0),
							fieldLabel: 'Lower Limit',
							allowDecimals:true,
							minValue:0,
							allowBlank: false
						},
						{
							xtype:'numberfield',
							name:'upper',
							value: (triggerRecord?triggerRecord.data.upper:0),
							fieldLabel: 'Upper Limit',
							allowDecimals:true,
							minValue:0,
							allowBlank: false
						},
						{
							xtype:'numberfield',
							name:'scaleUpTime',
							value: (triggerRecord?triggerRecord.data.scaleUpTime:120),
							fieldLabel: 'Scale Up Time (sec)',
							minValue:1,
							allowBlank: false
						},
						{
							xtype:'numberfield',
							name:'scaleDownTime',
							value: (triggerRecord?triggerRecord.data.scaleDownTime:120),
							fieldLabel: 'Scale Down Time (sec)',
							minValue:1,
							allowBlank: false
						}
					]},{
					border: false,
					items:[{
							xtype:'combo',
							name:'oid',
							fieldLabel: 'SNMP OID',
							value: (triggerRecord?triggerRecord.data.oid:'.1.3.6.1.4.1.2021.10.1.3.1'),
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
							value: (triggerRecord?triggerRecord.data.communityString:'public'),
							allowBlank: false
						},{
							xtype:'textfield',
							name:'vmPrefix',
							fieldLabel: 'VM Prefix',
							value: (triggerRecord?triggerRecord.data.vmPrefix:'ABQ_'),
							allowBlank: false
						},{
							xtype:'combo',
							name:'triggerApproval',
							fieldLabel: 'Approval',
							value: (triggerRecord?triggerRecord.data.triggerApproval:'Manual'),
							store: ['Manual','Automatic'],
							allowBlank: false
						}
					]
				}],
				buttons: [
					{ text:(triggerRecord?'Save Trigger':'Create Trigger'), handler: function(){
							this.up('form').getForm().submit({
								clientValidation: true,
								success: function(form, action) {
								   Ext.Msg.alert('Success', action.result.msg);
								   // refresh store.
								   var x = Ext.StoreManager.lookup('TriggerStore');
									Ext.StoreManager.lookup('TriggerStore').load(x.lastParams);
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
            height: this.height,
			id:'trigger-grid',
			flex:1,
			title: 'Triggers',
			iconCls:'icon-trigger',
            store: 'TriggerStore',
			border:false,
			tools:[
				{
					type:'help',
					tooltip: 'Get Help',
					handler: function(event, toolEl, panel){
						// show help here
						Ext.create('Ext.window.Window', {
							title: 'Help',
							height: 600,
							width: 600,
							layout: 'fit',
							autoScroll: true,
							loader: {
							  url: '/doc/trigger.md',
							  renderer: 'html',
							  autoLoad: true
							  }
						}).show();
					}
				}],
            stripeRows: true,
            columnLines: true,
			listeners: {
				'select': function(a,b){
					Ext.data.StoreManager.lookup('TickLogStore').load({
						params: {
							clusterId: b.data.clusterId,
							triggerId: b.data.triggerId
						}
					});
					Ext.data.StoreManager.lookup('TickLogStore').lastParams = {params: {
							clusterId: b.data.clusterId,
							triggerId: b.data.triggerId
						}};
					Ext.getCmp('DeleteTrigger').enable();
					Ext.getCmp('ConfigureTrigger').enable();
					Ext.get('tick-logs').unmask();
				}
			},
            columns: [
			{
                text : 'Priority',
                flex: 1,
                sortable : true,
                dataIndex: 'priority'
            },
			{
                text : 'Cluster',
                flex: 2,
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
                text : 'VM Count',
                flex: 1,
                sortable : true,
                dataIndex: 'clusterVmCount'
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
					id:'DeleteTrigger',
					disabled:true,
                    scope: this,
                    handler: this.DeleteTrigger,
					iconCls:'icon-delete-trigger'
                },
				{
					text: 'Configure',
					id:'ConfigureTrigger',
					disabled:true,
					scope:this,
					handler: function () { 
						this.CreateTrigger(this,null,(this.selModel.selected.length>0?this.selModel.selected.items[0]:null)) ;
					},
					iconCls:'icon-edit-trigger'
				},'-',
				{
					text: 'Raise Scale up',
					scope:this,
					handler: this.ForceScaleUp,
					iconCls: 'icon-scale-up'
				},
				{
					text: 'Raise Scale down',
					scope:this,
					handler: this.ForceScaleDown,
					iconCls: 'icon-scale-down'
				}
				]
            }]
        });
        this.callParent(arguments);
    }
});