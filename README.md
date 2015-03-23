Sage Pay Now WHMCS Credit Card Gateway Module
=============================================

Revision 1.5.2

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
2. Choose the following for both your accept and decline URLs:
   http://whmcs_installation/modules/gateways/callback/paynow.php

B. WHMCS Steps:

1. Go into WHMCS as admin
2. Click Setup / Payments / Payment Gateways
3. Activate the Module 'Pay Now'
4. Type an appropriate display name such as 'MasterCard/Visa'
5. Enter your Pay Now 'Service Key'
6. Click 'Support Budget Period' to allow the use of the credit card budget facility. (Default: No)
7. Click 'Send Email' to have the Pay Now gateway send e-mail (Default: No)
8. Make a note of the URL to use in your Sage Pay Now account for the Accept and Decline URLs
9. Click 'Save Changes'

You are now ready to transact. 

Remember to turn off "Make test mode active:" when you are ready to go live in the Pay Now Gateway Server Configuration.

Here is a screenshot of what the WHMCS settings screen for the Sage Pay Now configuration:
![alt tag](http://196.201.6.235/whmcs/whmcs_screenshot1.png)

Demo Site
---------

There is a demo site if you want to see WHMCS and the Sage Pay Now gateway in action:
http://196.201.6.235/whmcs

Revision History
----------------

* 23 March 2015/1.5.2: Removed API user requirement. Added setup guidance.
* 21 March 2015/1.5.1: Fixed the addInvoicePayment() arguments.
* 20 March 2015/1.5.0: Implemented callback verification for security. WHMCSfied the code.
* 20 March 2015/1.0.3: Fixed RegEx for invoiceid.
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
