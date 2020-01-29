Netcash Pay Now WHMCS Credit Card Gateway Module
=============================================

Revision 2.0.0

Introduction
------------

A third party credit card gateway integration that works with Netcash South Africa's Pay Now product.

Installation Instructions
-------------------------

Download the files from here:
* https://github.com/Netcash-ZA/PayNow-WHMCS-Module/archive/master.zip

Copy the following two files from the archive:

* /modules/gateways/paynow.php
* /modules/gateways/callback/paynow.php

to

* /WHMCS_Installation/modules/gateways/paynow.php
* /WHMCS_Installation/modules/gateways/callback/paynow.php

Configuration
-------------

Prerequisites:

* Netcash login credentials
* Netcash Pay Now Service Key
* WHMCS login credentials

A. Pay Now Gateway Server Configuration Steps

1. Log into your Netcash Account
2. Choose the following for your accept, decline and notify URLs:
   http://whmcs_installation/modules/gateways/callback/paynow.php
3. Choose the following for your redirect URL:
	http://whmcs_installation/clientarea.php

B. WHMCS Steps:

1. Go into WHMCS as admin
2. Click Setup / Payments / Payment Gateways
3. Activate the Module 'Pay Now'
4. Type an appropriate display name such as 'MasterCard/Visa'
5. Enter your Pay Now Service Key
6. Enter an admin username for WHMCS Admin User Name. This is to utilise the localAPI() method.
7. Click 'Send email' to have the Pay Now gateway send e-mail
8. Click 'Save Changes'

You are now ready to transact. Remember to turn off "Make test mode active:" when you are ready to go live.
