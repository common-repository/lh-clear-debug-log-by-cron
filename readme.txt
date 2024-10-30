=== LH Clear Debug Log by Cron ===
Contributors: shawfactor
Donate link: https://lhero.org/portfolio/lh-clear-debug-log-by-cron/
Tags: cron, debug, schedule, clear, cron-job
Requires at least: 5.0
Tested up to: 6.0
License: GPLv2 or later
Stable tag: 1.01

A simple plugin that clears the debug log by the cron schedule when it gets too big.

== Description ==

The best way of debugging in wordpress s to use the debug.log. But if you leave debug running for long periods that log can grow MASSIVELY. This can slow your site down.

This plugin uses the wordpress cron jobs to empty the debug log once it grows beyond a certain size.

NOTE this plugin relies on wordpress cron. If that is not working this plugin will not work. But then you will also have bigger problems!


**Like this plugin? Please consider [leaving a 5-star review](https://wordpress.org/support/view/plugin-reviews/lh-clear-debug-log-by-cron/).**

**Love this plugin or want to help the LocalHero Project? Please consider [making a donation](https://lhero.org/portfolio/lh-clear-debug-log-by-cron/).**

== Frequently Asked Questions ==

= What is the size threshold at which the logs are cleared?  =

By default the threshold is 4194304 bytes , which is the equivalent of 4 MB. This thrshold can be changed by using filters.

= What is that filter?  =

The filter is lh_del_dlog_cron_size_threshold . The only argument is the size threshold at which the debug log is deleted.

= How do I check if cron is working?  =

This plugin will help you check: https://wordpress.org/plugins/wp-cron-status-checker/

= What if something does not work?  =

LH Clear Debug Log by Cron, and all [https://lhero.org](LocalHero) plugins are made to WordPress standards. Therefore they should work with all well coded plugins and themes. However not all plugins and themes are well coded (and this includes many popular ones). 

If something does not work properly, firstly deactivate ALL other plugins and switch to one of the themes that come with core, e.g. twentyfirteen, twentysixteen etc.

If the problem persists please leave a post in the support forum: [https://wordpress.org/support/plugin/lh-clear-debug-log-by-cron/](https://wordpress.org/support/plugin/lh-clear-debug-log-by-cron/) . I look there regularly and resolve most queries.

= What if I need a feature that is not in the plugin?  =

Please contact me for custom work and enhancements here: [https://shawfactor.com/contact/](https://shawfactor.com/contact/)

== Installation ==

Install using WordPress:

1. Log in and go to *Plugins* and click on *Add New*.
1. Search for *LH Clear Debug Log by Cron* and hit the *Install Now* link in the results. WordPress will install it.
1. From the Plugin Management page in WordPress, activate the *LH Clear Debug Log by Cron* plugin.
1. That is it


== Changelog ==

**1.00 May 09, 2021**  
Initial release.

**1.01 June 19, 2022**  
Minor improvements