# About this project

Digital capability tool for civil servants.
This is the open repository for anyone to reuse and edit as they see fit.

# Technical Requirements

This project runs on standard LAMP (Linux/Apache/MySQL/PHP) stacks and doesn't have any other dependencies. 


# Setup instructions

## Wordpress and basic site setup

1. Download and install the latest version of [Wordpress](http://wordpress.org)
2. Create a new MySQL database and [install Wordpress](http://codex.wordpress.org/Installing_WordPress)
3. Purchase a license for [WatuPRO](http://calendarscripts.info/watupro/) Wordpress plugin and install/activate the plugin
4. Download the files from **this** repository
5. Install the custom theme, available in this repository under ```wordpress/wp-content/themes/digitalquiz```
6. Install the custom reports plugin, available under ```wordpress/wp-content/plugins/dfid-reports```
7. Copy ```wordpress/wp-content/plugins/watupro-custom/lib/email_parser.php``` to ```YOUR_NEW_WORDPRESS_PATH/wp-content/plugins/watupro/lib``` - this enables the customisation of the email report sent out to quiz takers
8. Add a bit of custom code to WatuPro's main PHP file, as instructed in ```wordpress/wp-content/plugins/watupro-custom/lib/additions_for_watupro.php```
9. Add a bit of custom code to WatuPro's main JavaScript file, as instructed in ```wordpress/wp-content/plugins/watupro-custom/lib/additions_for_main.js```
10. Go to **wp-admin** and change the theme to **digitalquiz**
11. You should now be able to open the site with no errors

## Quiz setup

1. Create a quiz on ```/wp-admin/admin.php?page=watupro_exams```
2. Create a new **Digital quiz** page and add the following shortcode: ```[watupro QUIZ_ID]``` (where ```QUIZ_ID``` is the id of the quiz you previously created, probably **1** if this is the first quiz)
3. Create a new **Welcome** page and set it to be displayed on the frontpage (from **wp-admin/ Settings/ Reading**); you can add your welcome copy to this page, as well as a link to the **Digital quiz** page you previously created
4. We recommend creating separate Question Categories in Watu and name the first one "**A. Introductory Questions**". The first category (if it's named that way) is being ignored in the scoring report. Should you want to use a different name, make sure you replace it in: 

    ```
    YOUR_NEW_WORDPRESS_PATH/wp-content/plugins/watupro/lib/email_parser.php
    ```
    ```
    YOUR_NEW_WORDPRESS_PATH/wp-content/themes/digitalquiz/dist/js/app.min.js
    ```
    ```
    YOUR_NEW_WORDPRESS_PATH/wp-content/themes/digitalquiz/src/js/app.js
    ```
5. The custom reports are available in wp-admin under the **Reports** section


# Theme customisations

The theme's CSS is built with SASS and using Gulp as a build tool. To make any changes, make sure you set things up first:

1. Install nodeJS 
2. Go in theme root directory
3. Install Bower and Gulp (if global is not working try local install)
```npm install -g bower```
```npm install -g gulp```
4. Install dependencies
```npm install```
```bower install```
5. Start gulp runner
```gulp watch```

Happy coding :).
