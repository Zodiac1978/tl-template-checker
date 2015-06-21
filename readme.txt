=== Child Theme Check ===
Contributors: zodiac1978, drivingralle, fstaude, glueckpress, hinnerkaltenburg
Donate link: http://example.com/
Tags: child, theme, check, child theme, child theme check
Requires at least: ?.?.?
Tested up to: 4.2.2
Stable tag: 0.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Warns you about outdated template files in your child theme and shows a diff view of the changes between parent and child theme template.

== Description ==

Child Themes are used to avoid overwriting your customizations. But if you preserve a file in a child theme, then you maybe preserve a security risk. After an update from the parent theme you always should check the changes and maybe add them to your child theme. This plugin helps you keeping track of these changes in the parent theme.

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

= 0.1.0 =
* Initial release