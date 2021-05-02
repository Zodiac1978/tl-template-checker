[![Code Climate](https://codeclimate.com/github/Zodiac1978/tl-template-checker/badges/gpa.svg)](https://codeclimate.com/github/Zodiac1978/tl-template-checker) [![Current Child Theme Check version](https://img.shields.io/wordpress/plugin/v/child-theme-check.svg)](https://wordpress.org/plugins/child-theme-check/) [![Number of downloads](https://img.shields.io/wordpress/plugin/dt/child-theme-check.svg)](https://wordpress.org/plugins/child-theme-check/advanced/) [![Number of active installs](https://img.shields.io/wordpress/plugin/installs/child-theme-check.svg)](https://wordpress.org/plugins/child-theme-check/advanced/) [![WordPress plugin rating](https://img.shields.io/wordpress/plugin/r/child-theme-check.svg)](https://wordpress.org/plugins/child-theme-check/#reviews) [![Donate with PayPal](https://img.shields.io/badge/PayPal-Donate-yellow.svg)](https://paypal.me/zodiac1978)

# Child Theme Check

A WordPress plugin that warns you about old template files in your child theme.

## Why?

Child Themes are used to avoid overwriting your customizations. But if you preserve a file in a child theme, then you maybe preserve a security risk. After an update from the parent theme you should always check the changes and maybe add them to your child theme. This plugin helps you keeping track of these changes in the parent theme.

## Requirements

You have to use a child theme. If a child theme is active, you can see the status or the diff view under **Child Theme Check** in **Tools**.

For full usage of the plugin you have to define the version of the template file in the header of the PHP file with an additional @version info.

For example: ```* @version 1.0.0```

If this is the case you will see a warning if the version of the parent theme file is higher than your child theme file. And you can see the differences between the parent theme file and the child theme file per wp_text_diff()-function like in revisions.

## Thanks

Thank you very much @WooThemes and @WooCommerce for using the GPL, so that I can grab so much of their code to build this plugin.

## Changelog

### 1.0.6
* Fix CSS

### 1.0.5
* Fix broken layout in Wordpress 5.7 (Thanks to Torsten Bulk for the report)
* Fix PHP warning
* Tested up to 5.7
* 
### 1.0.4
* not released

### 1.0.3

* Fix flashing of first diff view
* More i18n improvements (Thanks [@pedro-mendonca](https://github.com/pedro-mendonca))
* Tested up to 5.4

### 1.0.2

* fixed some WordPress coding standards issues
* added Github Updater Metadata
* updated readme.txt
* i18n improvements (Thanks [@pedro-mendonca](https://github.com/pedro-mendonca))
* Tested up to 5.3

### 1.0.1

* Fixed typo in German translation (Thanks [@pixolin](https://github.com/pixolin))
* Changed text for action link on plugins page (Thanks [@presskopp](https://github.com/presskopp))
* Tested up to 4.6.1

### 1.0.0

* Initial public release
