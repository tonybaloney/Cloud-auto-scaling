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
 * MySQL 5.x Server
 * PHP >5.1
 * ExtJS >4.0 for frontend

PHP Requirements :

* php_pcre
* php_json
* php_mysql
* php_simplexml





