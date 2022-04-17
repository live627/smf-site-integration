## Site Integration Mod
[![MIT license](http://img.shields.io/badge/license-MIT-009999.svg)](http://opensource.org/licenses/MIT)
[![Latest Version](https://img.shields.io/github/release/live627/smf-site-integration.svg)](https://github.com/live627/smf-site-integration/releases) [![Support](http://img.shields.io/badge/PayPal-$-009966.svg)](https://www.paypal.me/JohnRayes)

Package name | SMF version | Minimmum PHP version
--- | --- | ---
Site Integration Mod 2.0.0 | SMF 2.0.x | PHP 7.0
Site Integration Mod 1.4.1 | SMF 1.1.x, 2.0.x | PHP 4.3 – PHP 5.4

[View changelog](https://github.com/live627/smf-site-integration/blob/master/CHANGELOG.md)

### Overview
The Mod works by looking in a series of specific folders (defined by the admin) for `.php` files to include as actions, each included file will then be accessable within SMF from `index.php?action=(filename without trailing .php`).
- Create custom pages for your forum that may be accessed via direct link (`smf.example.com/index.php?action=demo`)
- Select membergroups that can access the actions
- Choose an action to use as a landing page instead of the board index
- Choose an action for errors (invalid or missing actions) instead of the board index
  - Does not change the standard error for missing or hidden topics
- Elect whether or not to show the action's name in Who's Online

This mod was borne of a desire for an easier way to integrate small php scripts and HTML pages into SMF without using the normal [SSI.php functions](http://docs.simplemachines.org/index.php?topic=400).

### Features Explained:
Settings are found in the admin panel: Administration Center » Configuration » Modifications » Site Integration (or `index.php?action=admin;area=modsettings;sa=siteintegration`).

- **Forum Default/Home Action:** This allows you to change the home page of your forums. Please note that your Board Index will still be accessible (`index.php?action=forum`). If you leave the setting blank then your normal Board Index will be your home page/action.

- **Invalid Action Error Action:** This allows you to show a specific action every time an invalid action is passed by the user. If you don't set this then it will just show the home/default page.

- **Site-Wide Language Integration Files:** (_only important if you are using more than one language_) Comma-seperated list of directories to search for language files in the form of `(current action).(current language).php`. These files will then be included before your included file/action, so that you can use a language system similar to the SMF language system where you define the same text variable (`$txt['welcome'] = 'Welcome to my Website!';`) in multiple language files and then access it later (eg `echo $txt['welcome'];`).

Further explanation of a setting's functionality can be found by clicking on the [?] help button.

### Important Information

This Mod should work for all installed themes. However, if you wish to customize the default layout, you can edit the `template_SiteIntegration()` function in the `SiteIntegration.template.php` template file. Hint: copy this file to another theme to   have a unique layout for that theme.

You have to set the permissions for all the includes actions/files that you want normal users or guests to see, by default every included action/file can only be seen by the admin of your website.

You can access any of the global variables from SMF, just like a mod. An example of declaring globals (this is easily forgotten):
```php
global $var;
```
Or for multiples:
```php
global $var1, $var2, $var3, ..., $varN;
```
You can use any of the functions which are defined by SMF from within the PHP code on your pages. Remember to `include` the       files first! (Refer to the [Function Database](https://wiki.simplemachines.org/smf/Function_database))

The index pages from your folders will _**never**_ be turned into actions. I would suggest that you copy an index.php page from one of the other SMF folders to protect your folders, so that people can't see a list of your files.

Finally note that you should always include the code below in all of your '.php ' files, so that if users try to view those files they will be redirected to the file's smf action. You only need to change the value of $smfurl to the web address of your SMF's index.php for it to work, ie. (`http://www.smf.example.com/index.php`).
```php
$smfurl = '{web adress of your SMFs index.php}';
if (!defined('SMF'))
	header('Location: ' . $smfurl . '?action=' . strtok(basename($_SERVER['SCRIPT_FILENAME']), '.');
```
### Tutorial
**[View more tutorials](https://github.com/live627/smf-site-integration/tree/main/docs)**
#### Create a simple action
1. Create directory `file_includes` in SMF root (`$boarddir`)
2. Create file in said directory `demo.php`
3. Save the following code to it
   ```php
   <?php

   echo 'Hello world';
   ```
4. Navigate browser to Administration Center » Configuration » Modifications » Site Integration
   1. Click "Manage" for settings specific to the `demo` action
      - _"File/Action Include Folders" MUST include `file_includes` or no files will be found_
   2. Enter the name and choose the group permisisons, click "Save"
   3. Click "demo" in the management table to view the action
      - The address bar should show `smf.example.com/index.php?action=demo`

#### Adding menu buttons for your actions
Download [Ultimate Menu](https://custom.simplemachines.org/index.php?mod=3674) for your menu building needs
