Ext.create('Ext.data.JsonStore', {
					storeId: 'TickLogStore',
                    fields: ['tl_id', 'result','vmId','vmName','date'],
                    proxy: {
						type: 'ajax',
						url : 'data.php?view=TickLog',
						reader: {
							type: 'json',
							root: 'logs'
						}
					},
					autoLoad: false
                })