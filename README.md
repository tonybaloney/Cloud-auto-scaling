Cloud Auto-Scaling
==========

This is a project to detect 'high-load' on a group of Virtual Systems using a cloud API and spawn new instances to a load-balanced cluster automatically.
This is to cope with peaks in demand and scale-down web clusters where appropriate.

Features 
---------------
* Supports multiple users each with a different 'cloud' backend
* Direct integration with Abiquo >1.8 to instantiate new VM's
* Specify a 'Cluster' as a Web-farm or app farm, a cluster has a profile of:
	* Minimum and Maximum VM's for that cluster
	* Template Appliance/VM image for new machines
	* Target VLAN to give addresses to new machines
	* Unlimited number of triggers in a cluster
* A Trigger is a SNMP poller in a cluster, it collects SNMP data and makes decisions to scale-up/scale-down a cluster based on user-specified rules
	* Specify lower threshold (e.g. Load Av <0.2)
	* Specify upper threshold (e.g. Load Av >2)
	* Specify time where average result must be above threshold before scale-up/down is executed
	* SNMP OID to collect
	* SNMP Community String
* Web application as a front-end to the application allowing a user to manage their clusters, their cloud API and triggers
	* See live SNMP results for a cluster
	* See a history of events (scale-up/scale-down)

Screenshot : [twitpic](https://p.twimg.com/An5NlwkCAAAGJn8.png:large)

Roadmap
---------------
* Adding support for OpenStack, EC2, Parallels
* Adding support for SNMP SetRequest to allow a Load-Balancer to be updated with changes (currently assume a network range is added to a pool in F5/Citrix/etc.)

Installation
---------------
Runs on a basic LAMP server

Requirements:
 * HTTP Server ( No apache/httpd requirements in this codebase)
 * MySQL >5.1 Server
 * PHP >5.3
 * ExtJS >4.0 for frontend

PHP Requirements :

* php_pcre
* php_json
* php_mysql
* php_simplexml
* php_gd

PEAR Requirements : 

* Mail
* Mail_Mime

License
-----------

This project is licensed under the LGPL license. See 'COPYING' for details

Cloud auto-scaling is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Cloud auto-scaling is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with Cloud auto-scaling.  If not, see <http://www.gnu.org/licenses/>.

Credits
===============

ExtJS license
----------------
This project uses ExtJS but does not contain ExtJS source code.

Ext JS - JavaScript Library
Copyright (c) 2006-2011, Sencha Inc.
All rights reserved.
licensing@sencha.com

http://www.sencha.com/license

This version of Ext JS is licensed under the terms of the Open Source GPL 3.0 license. 

Fugue
-----------

This Project uses the 'fugue' icon set produced by Yusuke Kamiyamane

Copyright (C) 2010 Yusuke Kamiyamane. All rights reserved.
The icons are licensed under a Creative Commons Attribution
3.0 license. [http://creativecommons.org/licenses/by/3.0/]

[http://p.yusukekamiyamane.com/]

Markdown
----------------
This project uses a tool to convert Markdown to HTML inline for documentation.

Markdown Extra Math - PHP Markdown Extra with additional syntax for jsMath equations
Copyright (c) 2008-2009 Dr. Drang
<http://www.leancrew.com/all-this/>

Markdown Extra  -  A text-to-HTML conversion tool for web writers

PHP Markdown & Extra
Copyright (c) 2004-2009 Michel Fortin  
<http://michelf.com/projects/php-markdown/>

Original Markdown
Copyright (c) 2004-2006 John Gruber  
<http://daringfireball.net/projects/markdown/>

JpGraph
-------------
This package contains the JpGraph PHP library Pro version 3.5.x

The library is Copyright (C) 2000-2010 Asial Corporatoin and
released under dual license QPL 1.0 for open source and educational
use and JpGraph Professional License for commercial use. 

Please see full license details at 
http://jpgraph.net/pro/
http://jpgraph.net/download/