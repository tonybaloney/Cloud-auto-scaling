Ext.define('Ext.app.Portal', {

    extend: 'Ext.container.Viewport',

    uses: ['Ext.app.PortalPanel', 'Ext.app.PortalColumn', 'Cloud.ClusterPortlet', 'Cloud.TriggerPortlet', 'Ext.app.ChartPortlet', 'Cloud.LogPortlet'],
	ConfigureAPI : function (){
		var me = Ext.data.StoreManager.lookup('CustomerStore').getAt(0);
		var popup = new Ext.Window({
			layout:'fit',
			width:308,
			height:433,
			closeAction:'hide',
			iconCls:'icon-configure',
			plain: true,
			resizable:true,
			title: 'Configure API',
			items: {
				xtype:'form',
				url: 'form.php?form=SaveCustomer',
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
						xtype:'textfield',
						name:'portalAPIUrl',
						fieldLabel: 'Cloud API URL',
						allowBlank: false,
						value: me.data.portalAPIUrl
					},
					{ 
						xtype:'textfield',
						name:'portalUsername',
						fieldLabel: 'Username',
						allowBlank: false,
						value: me.data.portalUsername
					},
					{
						xtype:'textfield',
						name:'portalPassword',
						fieldLabel: 'Password',
						allowBlank: false,
						value: me.data.portalPassword
					},
					{
						xtype:'combo',
						name:'apiType',
						fieldLabel:'API Type',
						store:['abiquo'],
						allowBlank: false,
						value: me.data.apiType
					}
				],
				buttons: [
					{ 
						text:'Save', 
						handler: function(){
							this.up('form').getForm().submit({
								clientValidation: true,
								success: function(form, action) {
								   Ext.Msg.alert('Success', action.result.msg);
								   // refresh store.
								   Ext.data.StoreManager.lookup('CustomerStore').load();
								   Ext.data.StoreManager.lookup('ClusterStore').load();
								   Ext.data.StoreManager.lookup('TriggerStore').load();
								},
								failure: function(form, action) {}}); 
							popup.hide(); 
						}
					}
					// ,{ text:'?',handler:function(){alert(this.up('window').height+'x'+this.up('window').width);}} // Window size 
				]
			}
		  }); 
		popup.show(this);
		popup.center();
	},
    initComponent: function(){
        Ext.apply(this, {
            layout: {
                type: 'border',
                padding: '0 5 5 5' // pad the layout from the window edges
            },
            items: [{
                xtype: 'box',
                region: 'north',
                height: 60,
                html: 'Cloud autoscaling dashboard'
            },{
                xtype: 'container',
                region: 'center',
                layout: 'border',
                items: [{
                    region: 'west',
                    width: 200,
                    minWidth: 150,
                    maxWidth: 400,
                    split: true,
                    collapsible: false,
					unstyled: true,
					border: false,
                    layout: { 
						type:'vbox',
						align:'stretch',
						pack:'start'
					},
					dockedItems: [{
						xtype: 'toolbar',
						items: [{
							text: 'Configure Cloud API',
							scope: this,
							handler: this.ConfigureAPI,
							iconCls:'icon-configure'
						}]
					}],
                    items: Ext.create('Cloud.ClusterPortlet')
                },{
                    xtype: 'portalpanel',
                    region: 'center',
                    items: [{
                        items: [{
                            title: 'Triggers',
							iconCls:'icon-trigger',
                            items: Ext.create('Cloud.TriggerPortlet')
                        },{
							title: 'Logs',
							items: Ext.create('Cloud.LogPortlet') 
						}]
                    },{
                        items: [{
                            title: 'Performance',
							iconCls:'icon-chart',
                            items: Ext.create('Cloud.ChartPortlet')
                        }]
                    }]
                }]
            }]
        });
        this.callParent(arguments);
    },

    showMsg: function(msg) {
        var el = Ext.get('app-msg'),
            msgId = Ext.id();

        this.msgId = msgId;
        el.update(msg).show();

        Ext.defer(this.clearMsg, 3000, this, [msgId]);
    },

    clearMsg: function(msgId) {
        if (msgId === this.msgId) {
            Ext.get('app-msg').hide();
        }
    }
});

