[![Code Climate](https://codeclimate.com/github/Zodiac1978/tl-template-checker/badges/gpa.svg)](https://codeclimate.com/github/Zodiac1978/tl-template-checker)

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

### 1.0.0

* Initial public release.


### 0.1.0

* Initial release. (Proof-of-concept / Beta - DO NOT USE ON PRODUCTION SITES!)
