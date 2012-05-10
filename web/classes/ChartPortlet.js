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
                store: Ext.create('Ext.data.JsonStore', {
                    fields: ['tl_id', 'result'],
                    proxy: {
						type: 'ajax',
						url : 'data.php?view=TickLog&clusterId=1&triggerId=3',
						reader: {
							type: 'json',
							root: 'logs'
						}
					},
					autoLoad: true
                }),
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
            }
        });

        this.callParent(arguments);
    }
});

