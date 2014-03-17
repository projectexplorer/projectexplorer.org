projectexplorer.org
===================

## Requirements

* PHP5
* MySQL
* Git
* SASS
* (optional) MAMP or XAMPP if you don't want to deal with lots of local config stuff.

## Database

Contact us for a copy of the latest database dump for developing locally. For production servers, you'll just need to import the SQL through phpMyAdmin or however you like to rock MySQL.

## Get running locally or on a server

The instructions are pretty much the same to run the website local or on a server.

### (optional for local) Install MAMP

`http://www.mamp.info/en/downloads/`

### Clone the repository to your local computer wherever you like to keep project folders.

`git clone git@github.com:projectexplorer/projectexplorer.org.git`

### Have MAMP serve this project

1. Load MAMP
2. Click on `Preferences`
3. Click on `Apache`
4. Select document root will look similar to `/Users/david/Sites/projectexplorer.org` but with proper username and path to the cloned repo
5. Click `OK`
6. Apache should automatically restart
7. Visit `http://localhost:8888/` to confirm Apache is loading the correct files
8. If all is well, you'll get a message saying "config.php is missing or corrupt. To install Textpattern, visit textpattern/setup/"

### Create database and import SQL

1. Visit `http://localhost:8888/MAMP/`
2. Look at host, port, user and password info which should be standard localhost stuff for MySQL dev (localhost, 8889, root, root)
3. Click 'phpMyAdmin' link in the top navigation
4. Click 'Databases'
5. Create a database called `projectexplorer`
6. Click on the newsly created `projectexplorer` database
7. Click `Import`
8. Find the SQL dump, select it and click `Go`
9. Hopefully all green indicators
10. You should have see a bunch of txp-prefixed tables in the `Structure` tab

### Create config.php

1. Open Terminal
2. `cd` path/to/project
3. `cd textpattern`
4. `touch config.php`
5. Open config.php in your favorite text editor

### Paste into config.php

```
<?php
    $txpcfg['db'] = 'projectexplorer';
    $txpcfg['user'] = 'root';
    $txpcfg['pass'] = 'root';
    $txpcfg['host'] = 'localhost';
    $txpcfg['table_prefix'] = '';
    $txpcfg['txpath'] = '/home/path/to/textpattern';
    $txpcfg['dbcharset'] = 'utf8';
?>
```
### Update config.php with your path/to/project

7. Go back into terminal and run `pwd`
8. Copy the result
9. Back to the your text editor
10. Replace `txpath` with whatever you copied during the `pwd` step
11. Save
12. Reload `http://localhost:8888` in a browser

### (optional) Change Textpattern's permlink structure

1. Visit `http://localhost:8888/textpattern/`
2. Login with you username and password
3. Visit the advanced preferences `http://localhost:8888/textpattern/index.php?event=prefs&step=advanced_prefs`
4. Update `File directory path` and `Temporary directory path` using your path/to/project
5. Save
6. Go walk around the block once to make sure Apache isn't caching old permalink structure
7. Now visit `http://localhost:8888` and visit articles served directly out of your local database