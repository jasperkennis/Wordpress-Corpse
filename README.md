Wordpress Corpse
==============================

This is a modified Wordpress setup, inspired by Mark Jaquith's WordPress Skeleton package (hence the name). See [the upstream documentation](https://github.com/markjaquith/WordPress-Skeleton) for base details.

## How it works
Wordpress is included as a [Git Submodule](http://chrisjean.com/2009/04/20/git-submodules-adding-using-removing-and-updating/), this makes sure that Wordpress is always up to date. All the content (themes, plugins, languages etc) live in their own, version controlled, directory 'content'. Configuration of this is done in ```wp-config.php```. Local settings are stored in the not version controlled `local-config.php`.

Uploads live in the non-version controlled folder ```/media``` in the root.

## Installation
### Fetch the submodules
After cloning this repository, fetch the Wordpress submodule by doing so:
```git submodule init``` and then ```git submodule update```.
cd into wordpress and checkout the version you desire. For instance ```git checkout 3.5.1```.

Important:
Don't forget to tell git in the parent repository you've checked out a different tag. Fortunately, that's very easy.
cd into the root of your project and hit ```git submodule update``` again.

### Setup the local environment
Setting up the local development machine is easy:

1. Create a file in the root of the repository called ```local-config.php```
2. Copy the following contents in to that file:

	```php
	<?php
	define( 'WP_LOCAL_DEV', true );
	define( 'WP_DEBUG', true );
	define( 'DB_NAME', 'your_database_name' );
	define( 'DB_USER', 'root' );
	define( 'DB_PASSWORD', 'root' );
	define( 'DB_HOST', 'localhost' ); // Probably 'localhost'
	define( 'HOST', 'localhost' ); // Probably 'localhost' too
	define( 'SITE_PATH', '/websites/my_website'); // the folder where your project livs aka the part of the url that comes after the hostname
	define( 'WP_HOME', 'http://'. HOST .'/'. SITE_PATH);
	define( 'WP_SITEURL','http://'. HOST .'/'. SITE_PATH );
	define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
	define( 'WP_CONTENT_URL', 'http://'. HOST .'/'. SITE_PATH .'/content' );
	define( 'UPLOADS', 'media/uploads' );
	?>
	```
3. Modify ```local-config.php``` to match your MAMP settings

Note:
```wp-config.php``` is setup to contain all the production settings. Put all your settings for the production environment here.

### Setup the media folder
1. Make sure the folder ```media``` is present and has the right permissions (```chmod 0700```).
2. It should work out of the box. If it doesn't, make sure your ```UPLOADS``` setting in your ```wp-config``` and ```local-config``` is present and correct.

## Development vs. Production/Staging
Wordpress stores a lot of it's settings in the database, and to make things worse, each plugin uses their own way of storing that information too. There isn't really a best practice of syncing these settings, if you do know, please contribute!

## Updating Wordpress
Since Wordpress is a submodule synced with the [Wordpress Github repository](https://github.com/WordPress/WordPress), you do not need to update Wordpress from the Wordpress Admin. Instead, update the submodule and checkout the tag of the latest (stable) Wordpress version. If you like to live on the edge, switching to a nightly build is as easy as ```git checkout master```.

## Problems commiting/updating after updating Wordpress?
It probably has something to do with modified Wordpress files in the Wordpress folder. Check those first, stash your changes and checkout the latest stable Wordpress version.

Since Git 1.7.0 modified submodules are tagged as 'dirty' and thus making it almost impossible to merge. Fortunately, there is an easy fix:
Add the following line to each module in ```.gitmodule```:
```ignore = dirty```

Like this:
```
[submodule "wordpress"]
	path = wordpress
	url = git://github.com/WordPress/WordPress.git
		ignore = dirty
```

## Tips & Recommendations
* Use something like [Yeoman](http://www.yeoman.io) for theme development to benefit of the joys of Coffee Script, SASS and more.
* Use the ```WP_DEBUG``` constant in ```local_settings.php``` to load your javascript files in ```functions.php``` and one compressed javascript file on the production server. See ```functions.php``` for details.
* Use [Git Flow](https://github.com/nvie/gitflow). Seriously, use it.

## Features & Plugins

### Functions.php
Comes preloaded with some handy code snippets.

### Style.css
Comes with the default Wordpress styles necessary for displaying content right

### Gitignore
Comes preset with default ignores for uploads, wordpress system files, cache folders, sass-cache, DS_Store and more. Modify this to suit your needs obviously.

### Debug Bar
Essential plugin

### Theme Check
Helps with developing a good Wordpress Theme

### W3 Total Cache
This is an advanced caching plugin for Wordpress which supports asset compression to achieve something similar to Rails' assets pipeline. And of course more.

### Advanced Custom Fields
This plugin is like a swiss army knife.

### Google Analytics for Wordpress
Supports advanced tracking codes for GA.

### Google Sitemap Generator
For enhanced SEO.

### Broken Link Checker
Nifty little tool

## To do
* Abstract wp-config to support staging & production
* More plugins?
