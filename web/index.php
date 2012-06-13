<?php
/**
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cloud Auto-Scaling dashboard</title>

    <link rel="stylesheet" type="text/css" href="resources/css/my-ext-theme.css">
    <link rel="stylesheet" type="text/css" href="assets/portal.css" />
	<link rel="stylesheet" type="text/css" href="extjs/src/ux/statusbar/css/statusbar.css" />
    <script type="text/javascript" src="extjs/ext-all.js"></script>
    <script type="text/javascript" src="extjs/src/ux/statusbar/StatusBar.js"></script>
    <!-- MVC Views and Models -->
    <script type="text/javascript" src="models/Trigger.js"></script>
    <script type="text/javascript" src="models/Cluster.js"></script>
    <script type="text/javascript" src="models/Customer.js"></script>
	<script type="text/javascript" src="models/Log.js"></script>
	<script type="text/javascript" src="models/ErrorLog.js"></script>
	<script type="text/javascript" src="models/TockLog.js"></script>
	<script type="text/javascript" src="models/TickLog.js"></script>
	<script type="text/javascript" src="models/Location.js"></script>	
	<script type="text/javascript" src="models/PrivateNetwork.js"></script>	
	<script type="text/javascript" src="models/VirtualAppliance.js"></script>	
	<script type="text/javascript" src="models/Template.js"></script>
    <!-- Portlets for the dashboard -->
    <script type="text/javascript" src="classes/TriggerPortlet.js"></script>
	<script type="text/javascript" src="classes/ClusterPortlet.js"></script>
	<script type="text/javascript" src="classes/LogPortlet.js"></script>
	<script type="text/javascript" src="classes/TickLogPortlet.js"></script>
	<script type="text/javascript" src="classes/ErrorLogPortlet.js"></script>

    <script type="text/javascript" src="portal.js"></script>

    <script type="text/javascript">
       Ext.onReady(function(){
			Ext.create('Ext.app.Portal');
			Ext.get('tock-logs').mask("Select a cluster.","x-cust-mask");
			Ext.get('trigger-grid').mask("Select a cluster.","x-cust-mask");
			Ext.get('tick-logs').mask("Select a trigger.","x-cust-mask");
			Ext.TaskManager.start({
				run: function (){
					Ext.Ajax.request({
						url: 'data.php?view=clockd_status',
						success: function(response, opts) {
							var obj = Ext.decode(response.responseText);
							if ( obj.running ) {
								var sb = Ext.getCmp('basic-statusbar');
								sb.setStatus({
									text: 'Clockd running',
									iconCls: 'x-status-valid'
								});
							} else {
								var sb = Ext.getCmp('basic-statusbar');
								sb.setStatus({
									text: 'Clockd not running!',
									iconCls: 'x-status-error'
								});
							}
						}
					});
						
					},
				interval: 10000
			});
			
        });
    </script>
</head>
<body>
    <span id="app-msg" style="display:none;"></span>
</body>
</html>