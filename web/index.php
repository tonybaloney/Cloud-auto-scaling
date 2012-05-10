<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cloud Auto-Scaling dashboard</title>

    <link rel="stylesheet" type="text/css" href="extjs/resources/css/ext-all.css" />
    <link rel="stylesheet" type="text/css" href="assets/portal.css" />

    <script type="text/javascript" src="extjs/ext-all.js"></script>
    
    <!-- MVC Views and Models -->
    <script type="text/javascript" src="models/Trigger.js"></script>
    <script type="text/javascript" src="models/Cluster.js"></script>
    <script type="text/javascript" src="models/Customer.js"></script>
	<script type="text/javascript" src="models/Log.js"></script>
	<script type="text/javascript" src="models/ErrorLog.js"></script>
	<script type="text/javascript" src="models/Location.js"></script>	
	<script type="text/javascript" src="models/PrivateNetwork.js"></script>	
	<script type="text/javascript" src="models/VirtualAppliance.js"></script>	
    <!-- Portlets for the dashboard -->
    <script type="text/javascript" src="classes/TriggerPortlet.js"></script>
	<script type="text/javascript" src="classes/ClusterPortlet.js"></script>
	<script type="text/javascript" src="classes/LogPortlet.js"></script>
	<script type="text/javascript" src="classes/ErrorLogPortlet.js"></script>
    <script type="text/javascript" src="classes/ChartPortlet.js"></script>
    <script type="text/javascript" src="classes/PortalColumn.js"></script>
    <script type="text/javascript" src="classes/PortalPanel.js"></script>
    <script type="text/javascript" src="classes/Portlet.js"></script>

    <script type="text/javascript" src="portal.js"></script>

    <script type="text/javascript">
        Ext.onReady(function(){
            Ext.create('Ext.app.Portal');
        });
    </script>
</head>
<body>
    <span id="app-msg" style="display:none;"></span>
</body>
</html>