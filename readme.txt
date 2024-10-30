=== Chalet Agent ===
Contributors: ChaletAgent
Requires at least: 3.5
Tested up to: 6.0.3
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.txt
Stable tag: 0.2.17
Tags: chaletagent, chalet agent, chalet

This is the WordPress plugin for the ChaletAgent system.

ChaletAgent is a sophisticated management tool for small chalet companies.

== Description ==

This is the WordPress plugin for the ChaletAgent system.

ChaletAgent is a sophisticated management tool for chalet companies.
For more information see http://chaletagent.com/

The plugin integrates ChaletAgent with your WordPress based chalet web site.
It allows you to publish your data stored in ChaletAgent on to your own WordPress web site pages.

The plugin communicates with your own ChaletAgent account. You cannot use the plugin without a ChaletAgent account.

The plugin communicates with the ChaletAgent API. No other communication with any other service is performed.

== Installation ==

Upload the files in to your WordPress plugins directory.

Then go to Settings -> ChaletAgent in WordPress admin and configure your account name.

Finally, add shortcodes or use the template tags as shown on the Settings page.

== Frequently Asked Questions ==

= Who is this plugin for? =

This plugin is only for users of ChaletAgent. See http://chaletagent.com/ for more information.

= What does this plugin do? =

The plugin allows you to show your data from your ChaletAgent account on your WordPress web site.

== Changelog ==

= 0.2.15 =
* Compatibility up to Wordpress 6.0.3

= 0.2.11 =
* Remove dependency on PHP sessions.
* Compatibility up to Wordpress 5.3.2

= 0.2.10 =
* Add support for listing Guest Feedback by catered / self catered bookings

= 0.2.9 =
* Removed support for Lift Passes API calls which are now redundant

= 0.2.7 =
* Added support for Guest Feedback shortcodes

= 0.2.6 =
* Caching system now has graceful fallback to last known good response

= 0.2.5 =
* Added caching of API calls using the Wordpress Transient API. Improves page load speed and reliability.

= 0.2.4 =
* Allow display of availability table showing only specific properties

= 0.2.3 =
* Added more CSS hooks to help with style customisations
* Bug fix on path to CSS file

= 0.2.2 =
* Added error log to admin screen
* Rationalised config constants

= 0.2.1 =
* Updated stable tag
* Switched to semantic versioning

= 0.2 =
* Refactored to improve code architecture
* Fix bug that caused undesirable paragraph tags in HTML output
* Added warning messages about missing configuration

= 0.1 =
* Initial release for WordPress

== Upgrade Notice ==

= 0.2.15 =
Upgrade for latest version and bug fixes

= 0.2.11 =
Upgrade for latest version and bug fixes

= 0.2.10 =
Upgrade for latest version and bug fixes

= 0.2.9 =
Upgrade for latest version and bug fixes

= 0.2.7 =
Upgrade to be able to include Guest Feedback via a shortcode

= 0.2.6 =
This release improves the API caching functionality and adds graceful fallback to handle connectivity errors

= 0.2.5 =
This release adds caching functionality to improve performance and reliability

= 0.2.4 =
Upgrade to get additional functionality for showing availability for a single property

= 0.2.3 =
Please upgrade to get important bug fix for missing CSS styles

= 0.2.2 =
Upgrade for important bug fix and access to error messages in admin screen

= 0.2.1 =
Set up correct version numbers with this update. No functional changes from 0.2

= 0.2 =
Please upgrade to this version to benefit from several bug fixes

= 0.1 =
This is the initial release
