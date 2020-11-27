=== HQ Rental Software ===
Contributors: faggioni
Donate link: https://hqrentalsoftware.com
Tags: hqrentalsoftware
Requires at least: 4.9.0
Tested up to: 5.4.2
Requires PHP: 5.6.0
Stable tag: 1.4.23
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

The HQ Rental Software plugin allows you to easily set up the reservation process on your website. Once you install the plugin, connect it to your HQ account, and set up your reservations page, your customers will be able to make reservations which will show on your HQ account. The plugin also lets you quickly set up a standard booking form, and the vehicle availability calendar on your website in just a few simple steps.

== Installation ==

After you add the plugin to your website, please follow the steps below to complete connection with your HQ account.

Step 1 - On your website’s WordPress admin dashboard navigate settings for HQ Rentals.

Step 2 - Under the General Settings section enter your HQ Rental Software user account email and password.

Step 3 - Press the Authenticate button - That’s it, you’re all set!

You can now use the features of the plugin to set up the reservation process and more. For information on this setup, please go to our Website Integrations section on our Knowledge Base.

If you experience any issues, please review your user and password and try again. If you are unable to authenticate your user information and fail to connect the plugin, please contact our support team via your HQ Rental Software account and we’ll happily assist you.

== Frequently Asked Questions ==

== Changelog ==

= 1.4.23 =
Screenshots update

= 1.4.21 =
Support for Elementor

= 1.4.20 =
New Region on API

= 1.4.19 =
Small fixes on settings

= 1.4.18 =
Support for Grand Car Theme

== Screenshots ==

1. Set up the credentials to connect to the system. In WordPress go to Settings > HQ Rentals.
2. You can find the Tenant Token inside the system under Settings > Integrations. Click on the “Generate new token” button, highlighted in orange in the picture below.
5. For User Token, you can navigate to Settings > User Management > Users.
6. You will see a table with the user where you can click on the user that you would like to use to manage, and click on your user name.
8. Once you have generated the new tokens, paste them in the fields marked in the image below. Next, select the API Region that you are currently in circled in orange in the picture below. To find out which API region you are currently on, check your URL. If you have xxx.caagcrm.com, your region is in America. For Europe, it would be xxx.hqrentals.eu and for Asia, it would be xxx.hqrentals.asia.
9. Once you have copied both tokens you will see HQ Rentals inside the WordPress menu and you should see this table; now just copy the “HTML shortcode reservations” and paste that on the page where you would like to display the bookings process. The system will automatically resize the iFrame on this page.

== Frequently Asked Questions ==

= How can I set up the plugin? =

The setup it's straightforward, you can find this under the Installation tab at this page or go to https://hqrentalsoftware.com/knowledgebase/wordpress-plugin/ and go through the steps.

= I’m having problems with the reservation workflow on Safari =

Due to an incompatibility with Safari and Opera browsers, the domain name of the iframe has to be updated. You will need to add a CNAME record in your DNS records where the value is the name of your tenant. For example, if your link is my-company.caagcrm.com or my-company.hqrentals.app the value for the CNAME record has to be “my-company”, and the value needs to be your link for example my-company.caagcrm.com

Once you have created the CNAME record on your domain, you will receive an SSL error. Please create a support ticket inside the HQ application so our team can proceed with the installation.

= I need to make a custom integration using the system data =

We have a REST API available that can help you interact with the system. For more information regarding technical information please visit https://api-docs.caagcrm.com/

= Need more help? =

You can contact us via our chat at https://hqrentalsoftware.com or you can create a support ticket clicking on the “?” icon in your HQ application.
