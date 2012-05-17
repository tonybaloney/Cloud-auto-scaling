 /**
  * Grid of clusters available to this user and dialogs to create and edit clusters.
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
Ext.define('Cloud.ClusterPortlet', {
    extend: 'Ext.grid.Panel', // Extend from basic panel
	
	updateLocationFilters: function ( sender, event ) {
		Ext.data.StoreManager.lookup('PrivateNetworkStore').load({
			params: {
				location: sender.value
				}
		});
		Ext.data.StoreManager.lookup('VirtualApplianceStore').load({
			params: {
				location: sender.value
				}
		});
	},
	
	// Create cluster dialog combined with edit cluster dialog, pass cluster record to edit, null to create
	CreateCluster : function (sender,event,clusterRecord/* If record is given this is an edit not a create */){
		if(clusterRecord){
			Ext.data.StoreManager.lookup('PrivateNetworkStore').load({
			params: {
				location: clusterRecord.data.clusterLocation
				}
			});
			Ext.data.StoreManager.lookup('VirtualApplianceStore').load({
			params: {
				location: clusterRecord.data.clusterLocation
				}
			});
		}
		var popup = new Ext.Window({
			layout:'fit',
			width:263,
			height:430,
			closeAction:'hide',
			iconCls:'icon-cluster',
			plain: true,
			resizable:true,
			title: (clusterRecord?'Save Cluster':'Create Cluster'),
			items: {
				xtype:'form',
				url: (clusterRecord?'form.php?form=SaveCluster':'form.php?form=AddCluster'),
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
						xtype:'hiddenfield',
						name:'clusterId',
						value: (clusterRecord?clusterRecord.data.clusterId:null)
					},
					{
						xtype:'textfield',
						name:'clusterName',
						fieldLabel: 'Cluster Name',
						allowBlank: false,
						value: (clusterRecord?clusterRecord.data.clusterName:'')
					},
					{
						xtype:'combo',
						name:'clusterLocation',
						fieldLabel: 'Location',
						displayField: 'locationName',
						valueField: 'clusterLocation',
						value: (clusterRecord?clusterRecord.data.clusterLocation:null),
						listeners: {
							'select': this.updateLocationFilters
						},
						store: 'LocationStore',
						queryMode: 'local',
						typeAhead: true,
						allowBlank: false
					},
					{
						xtype:'numberfield',
						name:'minServers',
						fieldLabel:'Minimum VM\'s',
						allowBlank:false,
						value: (clusterRecord?clusterRecord.data.minServers:1)
					},
					{
						xtype:'numberfield',
						name: 'maxServers',
						fieldLabel:'Maximum VM\'s',
						allowBlank:false,
						value: (clusterRecord?clusterRecord.data.maxServers:1)
					},
					{
						xtype:'combo',
						name:'targetVlanId',
						fieldLabel:'Target VLAN',
						allowBlank:false,
						value: (clusterRecord?clusterRecord.data.targetVlanId:''),
						displayField: 'networkDescription',
						valueField: 'networkId',
						store: 'PrivateNetworkStore',
						queryMode: 'local',
						typeAhead: true,
						allowBlank: false
					},
					{
						xtype:'combo',
						name:'targetApplianceId',
						fieldLabel:'Target Appliance',
						allowBlank:false,
						value: (clusterRecord?clusterRecord.data.targetApplianceId:''),
						displayField: 'applianceName',
						valueField: 'applianceId',
						store: 'VirtualApplianceStore',
						queryMode: 'local',
						typeAhead: true,
						allowBlank: false
					},
					{
						xtype:'textfield', 
						name:'clusterEmailAlerts',
						fieldLabel:'Alert Email',
						allowBlank:true,
						value: (clusterRecord?clusterRecord.data.clusterEmailAlerts:'')
					}
				],
				buttons: [
					{ 
						text:(clusterRecord?'Save Cluster':'Create Cluster'), 
						handler: function(){
							this.up('form').getForm().submit({
								clientValidation: true,
								success: function(form, action) {
								   Ext.Msg.alert('Success', action.result.msg);
								   // refresh store.
								   Ext.data.StoreManager.lookup('ClusterStore').load();
								   Ext.data.StoreManager.lookup('TriggerStore').load();
								},
								failure: function(form, action) {}}); 
							popup.hide(); 
						}
					}
					/* ,{ text:'?',handler:function(){alert(this.up('window').height+'x'+this.up('window').width);}} // Window size */
				]
			}
		  }); 
		popup.show(this);
		popup.center();
	},	
    initComponent: function(){
        Ext.apply(this, {
			title: 'Clusters',
            height: this.height,
            store: 'ClusterStore',
			iconCls:'icon-clusters',
            stripeRows: true,
            columnLines: true,
			border: false,
			flex:1,
			listeners: {
				'select' : function (a,b,c){
					if (b.data && b.data.clusterId){
						// Load the stores..
						Ext.data.StoreManager.lookup('TriggerStore').load({
							params: {
								clusterId: b.data.clusterId
								}
						});
						Ext.get('tock-logs').unmask();
						Ext.get('trigger-grid').unmask();
						Ext.data.StoreManager.lookup('TockLogStore').load({
							params: {
								clusterId: b.data.clusterId
								}
						});
						Ext.data.StoreManager.lookup('TockLogStore').lastParams = {params: {
								clusterId: b.data.clusterId
								}};
					}
					Ext.getCmp('DeleteCluster').enable();
					Ext.getCmp('ConfigureCluster').enable();
				}	
			},
            columns: [{
                id :'cluster',
                text : 'Cluster',
                flex: 1,
                sortable : true,
                dataIndex: 'clusterName'
            }],
			dockedItems: [{
                xtype: 'toolbar',
                items: [
				{
                    text: 'Add',
                    scope: this,
                    handler: this.CreateCluster,
					iconCls:'icon-add-cluster'
                },{
                    text: 'Delete',
					id:'DeleteCluster',
					disabled:true,
                    scope: this,
                    handler: this.onDeleteClick,
					iconCls:'icon-delete-cluster'
					
                },{
                    text: 'Configure',
					id:'ConfigureCluster',
					disabled:true,
                    scope: this,
                    handler: function(){ 
						this.CreateCluster(this,null,(this.selModel.selected.length>0?this.selModel.selected.items[0]:null)) ;
					},
					iconCls:'icon-edit-cluster'
                }]
            }]
        });
        this.callParent(arguments); // complete panel constructor
    }
});

