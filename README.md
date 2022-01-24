This version is only compatible with V.7+ of WHMCS
====

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

You will need:
* Netcash account
* Pay Now service activated
* Netcash account login credentials (with the appropriate permissions setup)
* Netcash - Pay Now Service key
* Cart admin login credentials

A. Netcash Account Configuration Steps:
1. Log into your Netcash account:
	https://merchant.netcash.co.za/SiteLogin.aspx
2. Type in your Username, Password, and PIN
2. Click on ACCOUNT PROFILE on the top menu
3. Select NETCONNECTOR from tghe left side menu
4. Click on PAY NOW from the subsection
5. ACTIVATE the Pay Now service
6. Type in your EMAIL address
7. It is highly advisable to activate test mode & ignore errors while testing
8. Select the PAYMENT OPTIONS required (only the options selected will be displayed to the end user)
9. Remember to remove the "Make Test Mode Active" indicator to accept live payments

* For immediate assistance contact Netcash on 0861 338 338


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
