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
    generateData: function(){
        var data = [{
                name: 'x',
                srv1: 100,
                srv2: 100
            }],
            i;
        for (i = 1; i < 50; i++) {
            data.push({
                name: 'x' + i,
                srv1: data[i - 1].srv1 + ((Math.floor(Math.random() * 2) % 2) ? -1 : 1) * Math.floor(Math.random() * 7),
                srv2: data[i - 1].srv2 + ((Math.floor(Math.random() * 2) % 2) ? -1 : 1) * Math.floor(Math.random() * 7)
            });
        }
        return data;
    },

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
                    fields: ['name', 'srv1', 'srv2'],
                    data: this.generateData()
                }),
                legend: {
                    position: 'bottom'
                },
                axes: [{
                    type: 'Numeric',
                    position: 'left',
                    fields: ['srv1'],
                    title: 'CPU Average',
                    label: {
                        font: '11px Arial'
                    }
                }, {
                    type: 'Numeric',
                    position: 'right',
                    grid: false,
                    fields: ['srv2'],
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
                    xField: 'name',
                    yField: 'srv1',
                    style: {
                        'stroke-width': 1
                    }
                }, {
                    type: 'line',
                    lineWidth: 1,
                    showMarkers: false,
                    axis: ['right', 'bottom'],
                    xField: 'name',
                    yField: 'srv2',
                    style: {
                        'stroke-width': 1
                    }
                }]
            }
        });

        this.callParent(arguments);
    }
});

