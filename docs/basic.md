## Tutorial
### Create a simple action
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

### Add language file
1. Create file in `file_includes` called `demo.english.php`
  - Special title key: `$txt['title_demo']`
  - Special key for Who's Online: `$txt['whoallow_demo']`
  - Special key for showing error when user has no permission to access action: `$txt['cannot_siteintegration:demo']`
