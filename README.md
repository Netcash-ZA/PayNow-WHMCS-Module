Sage Pay Now WHMCS Credit Card Gateway Module
=============================================

Revision 2.0.0

Introduction
------------

A third party credit card gateway integration that works with Sage Pay South Africa's Pay Now product.

Installation Instructions
-------------------------

Download the files from here:
* https://github.com/SagePay/PayNow-WHMCS/archive/master.zip

Copy the following two files from the archive:

* /modules/gateways/paynow.php
* /modules/gateways/callback/paynow.php

to

* /WHMCS_Installation/modules/gateways/paynow.php
* /WHMCS_Installation/modules/gateways/callback/paynow.php

Configuration
-------------

Prerequisites:

* Sage Pay Now login credentials
* Sage Pay Now Service Key
* WHMCS login credentials

A. Pay Now Gateway Server Configuration Steps

1. Log into your Pay Now Gateway Server configuration page
2. Choose the following for your accept, decline, notify and redirect URLs:
   http://whmcs_installation/modules/gateways/callback/paynow.php

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

Here is a screenshot of what the WHMCS settings screen for the Sage Pay Now configuration:
![alt tag](http://196.201.6.235/whmcs/whmcs_screenshot1.png)

Demo Site
---------

There is a demo site if you want to see WHMCS and the Sage Pay Now gateway in action:
http://196.201.6.235/whmcs

Revision History
----------------

* 25 August 2015/2.0.0: Add support for Retail/EFT payments
* 18 February 2015/1.0.2: Added WHMCS Admin User Name step to readme and correct file names
* 11 May 2014/1.0.1: Added screenshot to readme, added to documentation
* 05 Mar 2014/1.0.0: Added information on Pay Now server side configuration
* 05 Mar 2014/1.0.0: First version

Tip
---

* You can assign default WHMCS payment methods per Product Group.
* Remember to take your WHMCS Gateway Server Configuration out of test mode

References
----------

WHMCS has a detailed and easy to use payment gateway integration guide:
* http://docs.whmcs.com/Payment_Gateways

Feedback, issues, comments, suggestions
---------------------------------------

We welcome your feedback.

If you have any comments or questions please contact Sage Pay South Africa or log the issue on GitHub.
