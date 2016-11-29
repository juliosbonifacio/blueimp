Drupal Blueimp module:
------------------------
Maintainers:
  Julio Bonifacio
Requires - Drupal 8
License - GPL (see LICENSE)


Overview:
--------
Blueimp Gallery is a touch-enabled, responsive and customizable image and video gallery, carousel and lightbox, optimized for both mobile and desktop web browsers. to display additional content types.
This module allows for integration of Blueimp Gallery into Drupal.


* jQuery - http://jquery.com/
* Blueimp Gallery - https://github.com/blueimp/Gallery


Features:
---------

The Blueimp module:

* Works as a Formatter in entities and in views.
* Excellent integration with core image field and image styles and the Insert module
* Choose between a default style and a number of other styles that are included.
* Style the Colorbox with a custom Colorbox style in your theme.
* Drush command, drush colorbox-plugin, to download and install the Colorbox plugin in sites/all/libraries.

The Colorbox plugin:

* Compatible with: jQuery 1.3.2+ in Firefox, Safari, Chrome, Opera, Internet Explorer 7+
* It's a touch-enabled, responsive and customizable image and video gallery, carousel and lightbox, optimized for both mobile and desktop web browsers.
* It features swipe, mouse and keyboard navigation, transition effects, slideshow functionality, fullscreen support and on-demand content loading and can be extended to display additional content types.
* Released under the MIT License

Installation:
------------
0. Download and install Composer:

   https://getcomposer.org/doc/00-intro.md#system-requirements

1. Download and install the latest version of Drush:

   https://github.com/drush-ops/drush#installupdate---composer

2. Download and install the latest Drupal 8:

   git clone --branch 8.0.x http://git.drupal.org/project/drupal.git 8.x

3. Download the latest release of blueimp to your Drupal 8 site’s
   /modules directory:

   drush dl blueimp

4. Run `composer install` from the blueimp directory:

   cd blueimp
   composer install

   You should see output as it downloads the composer dependencies

5. Finally, enable the module:

   drush en blueimp -y


Configuration:
-------------
Go to "Configuration" -> "User Interface" -> "Blueimp" to find
all the configuration options.
