=== WooCommerce LPS Payment Gateway (API)===
Contributors: LPS WP Tech Team
Plugin Name: LPS Payment Gateway (API)
Plugin URI: http://www.lateralpaymentsolutions.com/cms/plugins
Author URI: http://digisource.co.in/
Requires at least: 3.5.1
Tags: payment, ecommerce, e-commerce, credit cards, woocommerce
Tested up to: 4.9
Stable tag: 4.0.3
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

== Description ==
This is a LPS Payment Gateway (API) for Woocommerce.
To signup for LPS merchant account in order to process payment transactions visit their website by clicking [here](http://www.lateralpaymentsolutions.com/apply.aspx)
LPS Payment Gateway (API) Woocommerce Payment Gateway allows you to accept payment on your Woocommerce store, LPS Payments supports Credit & Debit Cards on VISA & MASTERCARD card schemes. 
LPS also supports 3dsecure for enhanced transaction authentication.


== Features ==
 Credit Cards
 Debit Cards
 VISA, MASTERCARD
 3dSecure
 Multicurrency
 
 
 == LPS API ACCOUNT SETUP PROCESS HERE==
In order to setup an LPS API merchant processing account, the following details needs to be filled in and submitted to LPS.
The following information is required: 

*IP address of server
The IP address of the merchant web server needs to be provided. 
Please notify LPS before changing your IP address.

*Technical Contact
Technical contacts details.

*Currencies Required
Processing Currency Details

*Website
URL of the website (will be shown on customer email receipt)

*Company Name
Merchant Company Name (will be shown on customer email receipt)

*Email address for Sending Email receipts
Please provide the “sent from” e-mail address for e-mails sent to customers (.i.e.)

*Email Address for Receipt of Email receipts
The merchant is BCC’d on all receipts sent to customers. Please provide an e-mail address for these mails to be sent to. 

BILLING AND REPORTING SYSTEM
(Please note, email access to the Billing and Reporting system will be set up once the Merchant notifies us that they wish to go live)

Email Address for Reporting System login username
Please provide list of user’s email addresses who’ll need access to the LPS Reporting System. The passwords will be sent directly to the specified email addresses.

Email Address for Billing System login username
Please provide list of user’s email addresses who’ll need access to the LPS Billing System to download statements. The passwords will be sent directly to the specified email addresses.

== RESPONSE FIELDS ==
LPS_transaction_id 
Fraudscreening_status 
Bank_status
Amount
Bank_transaction_no
Bank_authorisation_no
Merchant_ref_number
 
 

== LPS Response codes validation==
The "Bank status" parameter holds the key to identifying the transaction status and it can carry the following values and the corresponding description of each code is also provided.

		00-Recredit accepted by bank
		05-Recredit rejected by bank
	  	90- Communication Failure. Please contact LPS
		If you have any queries get in touch: (techsupport@latpay.com)

== Handling responses ==	

You may handle bank response code in your checkout page. 
(example:  $LPS_transaction_id one of the bank response field. declare the variable
Step 1: class-woocommerce-lpsapi-payment-gateway.php
	session_start(); 
	   $_SESSION['transationid'] = $LPS_transaction_id;
Step 2: woocommerce->template->checkout->thank you.php
	<?php _e( 'Order Number:', 'woocommerce' ); ?>
				<strong><?php session_start(); 
				echo $_SESSION['transactionid'];?></strong>
Step 3: output: vissit plugin folder->get_started->screenshot-5.png


== Installation ==
The easy way: 
1. Go to the Plugins Menu in WordPress
2. Search for "LPS Payment Gateway (API)"
3. Click 'Install'
4. Activate the plugin
5.Go to woocommerce setting->checkout->lpsapi->

= Manual Installation =

1. Download the plugin file from this page and unzip the contents
1. Upload the "woocommerce-lps-api-payment-gateway" folder to the "/wp-content/plugins/" directory
1. Activate the "woocommerce-lps-api-payment-gateway" plugin through the "Plugins" menu in WordPress

==Test Account Details==
We will be providing test account details. contact(techsupport@latpay.com)
== Screenshots ==
1. plugin folder->get_started
screenshot-1.png
screenshot-2.png
screenshot-3.png
screenshot-4.png
screenshot-5.png

