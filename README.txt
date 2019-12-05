=== HQ Rental Software ===
Contributors: faggioni
Donate link: https://hqrentalsoftware.com
Tags: hqrentalsoftware
Requires at least: 4.9.0
Tested up to: 5.2.1
Requires PHP: 5.6.0
Stable tag: 1.4.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

This plugin is for HQ Rental Software clients that would like to enable online bookings on their website. Once you install this your customers will be able to make reservations which will show on your HQ account, and you can receive internal notifications when an online booking is made. You can also set up online payments on your HQ account, so that the payment step is enabled for online bookings. This way your customers can process online payments for their reservations.

== Installation ==

Once you add the plugin please follow the following steps:

Step 1: Go to your HQ Rental Software to generate API tokens for your tenant and user. You can find the Tenant Token inside the system under Settings > Integrations. Click on the “Generate new token” button.For User Token, you can find it under the User Management category > Users by clicking on the user that you would like to use to manage.

Step 2: Once you have generated the tokens by completing the previous step, you can set up the credentials to connect to the system. In WordPress go to Settings > HQ Rentals. Paste the tokens in the corresponding fields labeled Tenant Token and User Token.

Step 3: Select the API Region that you are in. Note: To find out which API region you are currently on, check your URL. If you have xxx.caagcrm.com or xxx.hqrentals.app, your region is in America. For Europe, it would be xxx.hqrentals.eu and for Asia, it would be xxx.hqrentals.asia.

Step 4: Once you have copied both tokens you will see HQ Rentals inside the WordPress menu and you
should see this table; now just copy the “HTML shortcode reservations” and paste that on the page
where you would like to display the bookings process. The system will automatically resize the iFrame
on this page.

== Frequently Asked Questions ==

== Changelog ==

= 1.4.2 =
Adding support for change on public reservations urls

= 1.4.1 =
Settings screen adjusted
Fixes on clients shortcodes

= 1.4.0 =
Settings screen adjusted
Support for custom fields
Auto update of saved settings
Removing support for regular API response on data sync

= 1.3.4 =
Fix buffering

= 1.3.3 =
Fixes on README files

= 1.3.2 =
Remove buffer on Reservation Shortcode

= 1.3.1 =
Fixes on buffering

= 1.3.0 =
Adding buffer handler on Reservation Shortcode, update assets

= 1.2.9 =
Tenant datetime format added to the front-end assets under the name of hqRentalsTenantDatetimeFormat.
Safari option on plugin settings

== Upgrade Notice ==

= 1.3.4 =
Fix buffering

== Screenshots ==

1. Set up the credentials to connect to the system. In WordPress go to Settings > HQ Rentals.
2. You can find the Tenant Token inside the system under Settings > Integrations. Click on the “Generate new token” button, highlighted in orange in the picture below.
5. For User Token, you can navigate to Settings > User Management > Users.
6. You will see a table with the user where you can click on the user that you would like to use to manage, and click on your user name.
8. Once you have generated the new tokens, paste them in the fields marked in the image below. Next, select the API Region that you are currently in circled in orange in the picture below. To find out which API region you are currently on, check your URL. If you have xxx.caagcrm.com, your region is in America. For Europe, it would be xxx.hqrentals.eu and for Asia, it would be xxx.hqrentals.asia.
9. Once you have copied both tokens you will see HQ Rentals inside the WordPress menu and you should see this table; now just copy the “HTML shortcode reservations” and paste that on the page where you would like to display the bookings process. The system will automatically resize the iFrame on this page.

== Frequently Asked Questions ==

= How can I setup the plugin? =

The setup its straightforward, you can find this under the Installation tab at this page or go to https://docs.hqrentalsoftware.com/knowledgebase/wordpress-plugin/ and go through the steps.

= I received an error on the setup screen =

Please make sure you select the right API Region depending on your installation. If your system link ends in caagcrm you should select America. In case your system link ends in hqrentals.eu, you should select Europe. Finally, if it ends in hqrentals.asia, please select Asia.

= What does the Force Update button do? =

This button triggers the synchronization between your WordPress installation and the system. This will refresh all the current system data on your WordPress website.

= I’m having problems with the reservation workflow on Safari =

Due to an incompatibility with Safari and Opera browsers, the domain name of the iframe has to be updated. You will need to add a CNAME record in your DNS records where the value is the name of your tenant. For example, if your link is my-company.caagcrm.com or my-company.hqrentals.app the value for the CNAME record has to be “my-company”, and the value needs to be your link for example my-company.caagcrm.com

Once you have created the CNAME record on your domain, you will receive an SSL error. Please create a support ticket inside the HQ application so our team can proceed with the installation.

= I need to make a custom integration using the system data =

We have a REST API available that can help you interact with the system. For more information regarding technical information please visit https://api-docs.caagcrm.com/

= Need more help? =

You can contact us via our chat at https://hqrentalsoftware.com or you can create a support ticket clicking on the “?” icon in your HQ application.