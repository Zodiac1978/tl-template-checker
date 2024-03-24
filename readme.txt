=== Child Theme Check ===
Contributors: zodiac1978, drivingralle, fstaude, glueckpress, hinnerk, rkoller
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=LCH9UVV7RKDFY
Tags: child, theme, check, child theme, child theme check
Requires at least: 3.6.0
Tested up to: 6.5
Stable tag: 1.0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Warns you about outdated template files in your child theme and shows a diff view of the changes between parent and child theme template.

== Description ==

Child Themes are used to avoid overwriting your customizations. But if you preserve a file in a child theme, then you maybe preserve a security risk. After an update from the parent theme you always should check the changes and maybe add them to your child theme. This plugin helps you keeping track of these changes in the parent theme.

For full usage of the plugin your parent theme has to define the version of the template file in the header of the PHP file with an additional @version info.

For example: `@version 1.0.0`

If this is the case you will see a warning if the version of the parent theme file is higher than your child theme file. And you can see the differences between the parent theme file and the child theme file per wp_text_diff()-function like in revisions.

Some posts about this plugin:

* [KrautPress](https://krautpress.de/2016/child-theme-dilemma/) (German)
* [WP Tavern](https://wptavern.com/child-theme-check-plugin-helps-wordpress-users-navigate-parent-theme-updates) (English)
* [Elmastudio](http://www.elmastudio.de/en/wordpress-plugins-child-theme-check/) (English)
* [Elmastudio](http://www.elmastudio.de/wordpress-plugin-tipp-child-theme-check/) (German)

These themes from [Elmastudio](http://www.elmastudio.de/en/) are already using the @version info in the header:

* Uku
* Uku Light
* Weta
* Pukeko
* Zeitreise
* Werkstatt
* Neubau
* Hawea

Please spread the word and if you are a theme developer, please add this to your themes too! Thanks :)

== Installation ==

1. Upload the zip file from this plugin on your plugins page or search for `Child Theme Check` and install it directly from the repository
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Activate a child theme and run the child theme check from your tools menu


== Frequently Asked Questions ==

= I just get the error: Parent theme is missing version keyword. =

For full usage of the plugin your parent theme has to define the version of the template file in the header of the PHP file with an additional @version info.

For example: `@version 1.0.0`

If this is the case you will see a warning if the version of the parent theme file is higher than your child theme file. And you can see the differences between the parent theme file and the child theme file per wp_text_diff()-function like in revisions.

== Screenshots ==

1. Status View
2. Diff View

== Changelog ==

= 1.0.7 =
* Tested with WordPress 6.5

= 1.0.6 =
* Fix CSS

= 1.0.5 =
* Fix broken layout in Wordpress 5.7 (Thanks to Torsten Bulk for the report)
* Fix PHP warning
* Tested up to 5.7

= 1.0.4 =
* not released

= 1.0.3 =
* Fix flashing of first diff view
* More i18n improvements (Thanks @pedromendonca)
* Tested up to 5.4

= 1.0.2 =
* fixed some WordPress coding standards issues
* added Github Updater Metadata
* updated readme.txt
* i18n improvements (Thanks @pedromendonca)
* Tested up to 5.3

= 1.0.1 =
* Fixed typo in German translation (Thanks @pixolin)
* Changed text for action link on plugins page (Thanks @presskopp)
* Tested up to 4.6.1

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.1 =
* Minor string changes
