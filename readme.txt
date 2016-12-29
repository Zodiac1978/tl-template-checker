=== Child Theme Check ===
Contributors: zodiac1978, drivingralle, f.staude, glueckpress, hinnerk, rkoller, presskopp
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=LCH9UVV7RKDFY
Tags: child, theme, check, child theme, child theme check
Requires at least: 3.4.0
Tested up to: 4.6.1
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Warns you about outdated template files in your child theme and shows a diff view of the changes between parent and child theme template.

== Description ==

Child Themes are used to avoid overwriting your customizations. But if you preserve a file in a child theme, then you maybe preserve a security risk. After an update from the parent theme you always should check the changes and maybe add them to your child theme. This plugin helps you keeping track of these changes in the parent theme.

For full usage of the plugin your parent theme has to define the version of the template file in the header of the PHP file with an additional @version info.

For example: `@version 1.0.0`

If this is the case you will see a warning if the version of the parent theme file is higher than your child theme file. And you can see the differences between the parent theme file and the child theme file per wp_text_diff()-function like in revisions.

Some posts about this plugin:

* https://krautpress.de/2016/child-theme-dilemma/ (German)
* https://wptavern.com/child-theme-check-plugin-helps-wordpress-users-navigate-parent-theme-updates (English)
* http://www.elmastudio.de/en/wordpress-plugins-child-theme-check/ (English)
* http://www.elmastudio.de/wordpress-plugin-tipp-child-theme-check/ (German)

These themes from [Elmastudio](http://www.elmastudio.de/en/) are already using the @version info in the header:

* Uku
* Uku Light
* Weta
* Zeitreise
* Werkstatt
* Neubau
* Hawea

Please spread the word and if you are a theme developer, please add this to your themes too! Thanks :)

Plugins can register there templates by using the tl_tplc_external_files filter hook.

Example:

The Plugin have the template files single-author.php and archive-author.php in the templates folder inside the plugin folder.
In the Childtheme these files can be overwritten in the folder 'materialpool'.
To register the templates, ths plugin uses this code.

function add_template_check_external_files ( $checkArray ) {
    $checkArray[ 'materialpool/single-author.php' ] = $plugin_base_dir . 'templates/single-author.php';
    $checkArray[ 'materialpool/archive-author.php'] = $plugin_base_dir . 'templates/archive-author.php';
    return $checkArray;
}
add_filter( 'tl_tplc_external_files', 'add_template_check_external_files' );


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

= 1.0.3 =
* added support for plugin templates like buddypress, woocommerce and so on.

= 1.0.2 =
* added Github Updater Metadata

= 1.0.1 =
* Fixed typo in German translation (Thanks @pixolin)
* Changed text for action link on plugins page (Thanks @presskopp)
* Tested up to 4.6.1

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.1 =
* Minor string changes
