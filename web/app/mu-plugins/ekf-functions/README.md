# WordPress Plugin Boilerplate with Namespace and Autoloader Support

This is a fork of the [WordPress Plugin Boilerplate](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate) project and adds support for Namespaces and Autoloader. It requires PHP 5.6 and greater.

## Contents

The `ekf-functions` directory contains the source code - a fully executable WordPress plugin.

## Features

* The Boilerplate is based on the [Plugin API](http://codex.wordpress.org/Plugin_API), [Coding Standards](http://codex.wordpress.org/WordPress_Coding_Standards), and [Documentation Standards](https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/php/).
* All classes, functions, and variables are documented so that you know what you need to change.
* The Boilerplate uses a strict file organization scheme that corresponds both to the WordPress Plugin Repository structure, and that makes it easy to organize the files that compose the plugin.
* The project includes a `.pot` file as a starting point for internationalization.

## Installation

The Boilerplate can be installed directly into your plugins folder "as-is". You will want to rename it and the classes inside of it to fit your needs.

* Copy ekf-functions to your plugin's directory and rename it to your plugin's name
* Perform a find and replace at the project level as follows:
  1. Find the text `ekf-functions` and replace with `your-ekf-functions` in all files
  2. Find the text `EKF_Functions` and replace with `Your_ekf_functions` in all files
  3. Rename the `css` and `js` files under `inc\admin\css`, `inc\admin\js\`, `inc\views\js`, `inc\views\css` and replace the string `ekf-functions` with `your-ekf-functions`
  4. Rename the `pot` file under `languages` and replace the string `ekf-functions` with `your-ekf-functions`
  5. Find the text `http://example.com` and replace with your URI in all files
  6. Find the text `Your Name or Your Company` and replace with your name in all files
* Activate the plugin

#### Quick Commands to perform the Find and Replace #####
```	bash
# After having downloaded and extracted the archive, navigate to the folder containing the plugin
$ mv ekf-functions my-awesome-plugin
$ cd my-awesome-plugin
```
```	bash
# Replace text for "example.com/ekf-functions-uri" and "example.com"
$ grep -rl "example.com/ekf-functions-uri" ./* | xargs sed -i "s/example.com\/ekf-functions-uri/somedomain.com\/my-awesome-plugin-uri/g"

$ grep -rl "example.com" ./* | xargs sed -i "s/example.com/somedomain.com/g"
```
```	bash
# Replace text for "ekf-functions"
$ grep -rl "ekf-functions" ./* | xargs sed -i "s/ekf-functions/my-awesome-plugin/g"
```
```	bash
# Replace Namespace references for the text "EKF_Functions"
$ grep -rl "EKF_Functions" ./* | xargs sed -i "s/EKF_Functions/My_Awesome_Plugin/g"
```
```	bash
# Rename Files with the text "ekf-functions" in them
$ find . -iname '*ekf-functions*' -exec rename 's/ekf-functions/my-awesome-plugin/' {} \;
```
```	bash
# Replace text for Your Name
$ grep -rl "Your Name or Your Company" ./* | xargs sed -i "s/Your Name or Your Company/Your Name/g"
```
Note that this will activate the source code of the Boilerplate, but because the Boilerplate has no real functionality there will be no menu items, meta boxes, or custom post types added.

### Plugin Structure

If you want to include your own classes, or third-party libraries

* `ekf-functions/inc/admin` - admin-specific functionality
* `ekf-functions/inc/core` - plugin core to register hooks, load files etc
* `ekf-functions/inc/frontend` - public-facing functionality
* `ekf-functions/inc/common` - functionality shared between the admin area and the public-facing parts
* `ekf-functions/inc/libraries` - libraries that the plugin may use

### PHP Version
Requires PHP `5.6.0` or greater

# Developer Notes

### The BoilerPlate uses a variable for the Text Domain

The WordPress Plugin Boilerplate uses a **variable** (`$this->plugin_text_domain`) to store the text domain, used when internationalizing strings. To take advantage of this method, there are tools that are recommended for providing correct, translatable files:

#### i18n Tools
* [Poedit](http://www.poedit.net/)
* [makepot](http://i18n.svn.wordpress.org/tools/trunk/)
* [i18n](https://github.com/grappler/i18n)

Any of the above tools should provide you with the proper tooling to internationalize the plugin. However, if you face problems translating the strings with an automated tool/process, replace `$this->plugin_text_domain` with the literal string of your plugin's text domain throughout the plugin.

### References:
* [Here's a discussion from the original project in favor of using variables](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate/issues/59)
* [The Plugin Handbook Recommended Way (i.e. not to use variables)](https://developer.wordpress.org/plugins/internationalization/how-to-internationalize-your-plugin/#text-domains)

# License

The WordPress Plugin Boilerplate is licensed under the GPL v2 or later.

> This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

> This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

> You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

A copy of the license is included in the root of the plugin’s directory. The file is named `LICENSE`.

If you opt to use third-party code that is not compatible with v2, then you may need to switch to using code that is GPL v3 compatible.

For reference, [here's a discussion](http://make.wordpress.org/themes/2013/03/04/licensing-note-apache-and-gpl/) that covers the Apache 2.0 License used by [Bootstrap](http://twitter.github.io/bootstrap/).

# History

The original launch of this version of the boilerplate included the folder structure needed for using your plugin on WordPress.org. That folder structure has been moved to its own repo here: https://github.com/DevinVinson/Plugin-Directory-Boilerplate

# Credits

The WordPress Plugin Boilerplate was started in 2011 by [Tom McFarlin](http://twitter.com/tommcfarlin/) and has since included a number of great contributions. In March of 2015 the project was handed over by Tom to [Devin Vinson](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate/)


