/**
  * Portal, container class for the frontend
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
Ext.define('Ext.app.Portal', {
    extend: 'Ext.container.Viewport',
    uses: ['Cloud.ClusterPortlet', 'Cloud.TriggerPortlet', 'Cloud.TickLogPortlet', 'Cloud.TockLogPortlet', 'Cloud.ErrorLogPortlet', 'Ext.ux.StatusBar'],
	ConfigureAPI : function () {
		var me = Ext.data.StoreManager.lookup('CustomerStore').getAt(0);
		var popup = new Ext.Window({
			layout: 'fit',
			width: 308,
			height: 433,
			closeAction: 'hide',
			iconCls: 'icon-configure',
			plain: true,
			resizable: true,
			title: 'Configure API',
			items: {
				xtype: 'form',
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
						xtype: 'textfield',
						name: 'portalAPIUrl',
						fieldLabel: 'Cloud API URL',
						allowBlank: false,
						value: me.data.portalAPIUrl
					},
					{
						xtype: 'textfield',
						name: 'portalUsername',
						fieldLabel: 'Username',
						allowBlank: false,
						value: me.data.portalUsername
					},
					{
						xtype: 'textfield',
						name: 'portalPassword',
						fieldLabel: 'Password',
						allowBlank: false,
						value: me.data.portalPassword
					},
					{
						xtype: 'combo',
						name: 'apiType',
						fieldLabel: 'API Type',
						store: ['abiquo'],
						allowBlank: false,
						value: me.data.apiType
					}
				],
				buttons: [
					{ 
						text: 'Save', 
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
								failure: function(form, action) {
									Ext.Msg.alert('Saved settings but API incorrect', action.result.msg);
								}}); 
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
                padding: '0 0 0 0' // pad the layout from the window edges
            },
            items: [{
                xtype: 'box',
				id: 'top-header',
                region: 'north',
                height: 60,
                html: '<img src="assets/logo.png"/><span style="float:right;top:10px; right:10px; position:relative;">Cloud Autoscaling Dashboard</span>'
            },{
                xtype: 'container',
                region: 'center',
                layout: 'border',
				defaults: {
					border: false
				},
                items: [{
                    region: 'west',
                    width: "20%",
                    minWidth: 150,
                    maxWidth: 400,
                    split: true,
                    collapsible: false,
                    layout: { 
						type:'vbox',
						align:'stretch',
						pack:'start'
					},
					bbar: {
						items: [{
							text: 'Configure Cloud API',
							scope: this,
							handler: this.ConfigureAPI,
							iconCls:'icon-configure'
						}]
					},
                    items: Ext.create('Cloud.ClusterPortlet')
                },{
                    region: 'center',
					layout: { 
						type:'fit'
					},
                    items: [
						{layout: { 
							type:'vbox',
							align:'stretch',
							pack:'start'
						},
                        items: [
							Ext.create('Cloud.TriggerPortlet'),
							Ext.create('Cloud.TockLogPortlet')
						]
					}],
					bbar: Ext.create('Ext.ux.StatusBar', {
						id:'basic-statusbar',
						// defaults to use when the status is cleared:
						defaultText: 'Default status text',
						// values to set initially:
						text: 'Checking..',
						iconCls: 'x-status-valid'
					})
				},
				{
					region: 'east',
					width: "55%",
					layout: 'fit',
					minWidth: 250,
					split: true,
					resizable: true,
					items: [{layout: { 
							type:'vbox',
							align:'stretch',
							pack:'start'
						},
						defaults: { 
							border:false
						},
                        items: [
							Ext.create('Cloud.TickLogPortlet'),
							Ext.create('Cloud.ErrorLogPortlet') 
						]
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

