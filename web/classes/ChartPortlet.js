/*

This file is part of Ext JS 4

Copyright (c) 2011 Sencha Inc

Contact:  http://www.sencha.com/contact

GNU General Public License Usage
This file may be used under the terms of the GNU General Public License version 3.0 as published by the Free Software Foundation and appearing in the file LICENSE included in the packaging of this file.  Please review the following information to ensure the GNU General Public License version 3.0 requirements will be met: http://www.gnu.org/copyleft/gpl.html.

If you are unsure which license is appropriate for your use, please contact the sales department at http://www.sencha.com/contact.

*/
Ext.define('Cloud.ChartPortlet', {
    extend: 'Ext.panel.Panel',
    initComponent: function(){
        Ext.apply(this, {
            layout: 'fit',
            width: 600,
            height: 300,
			iconCls:'icon-chart',
            items: {
                xtype: 'chart',
                animate: false,
                shadow: false,
                store: 'TickLogStore',
                legend: {
                    position: 'bottom'
                },
                axes: [
				{
                    type: 'Numeric',
                    position: 'right',
                    grid: false,
                    fields: ['result'],
                    title: 'Memory usage',
                    label: {
                            font: '11px Arial'
                        }
                }],
                series: [{
                    type: 'line',
                    lineWidth: 1,
                    showMarkers: false,
                    fill: true,
                    axis: ['left', 'bottom'],
                    xField: 'tl_id',
                    yField: 'result',
                    style: {
                        'stroke-width': 1
                    }
                }]
            },
			dockedItems: [{
                xtype: 'toolbar',
                items: [{
                    text: 'Trigger',
					xtype:'combo',
                    scope: this,
                    handler: this.CreateTrigger,
					store: 'TriggerStore',
					listeners: {
						'select': function(a,b){
							Ext.data.StoreManager.lookup('TickLogStore').load({
							params: {
								clusterId: b[0].data.clusterId,
								triggerId: b[0].data.triggerId
							}
							});
						}
					},
					displayField: 'triggerName',
					valueField: 'triggerId',
					queryMode: 'local',
					typeAhead: true
				}
				]
            }]
        });

        this.callParent(arguments);
    }
});

