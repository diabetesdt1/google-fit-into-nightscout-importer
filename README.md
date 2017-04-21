# google-fit-into-nightscout-importer
Imports downloaded tcx-Files from https://takeout.google.com/settings/takeout from Google-Fit over NightScout API into your NS.


Go to: https://takeout.google.com/settings/takeout
Choice only "Google-Fit"
Click to next Button
Click on "create Archiv" Button.
Wait until your Archiv is done.

Download your Archiv to your Server/Linux-Shell/Windows-PHP
Unpack it.

Adjust the Settings in "config.inc.php".

The "googlefitdir", can be have Problems, when you have specoaö characters (äö..., german, chinese, russian....) inside the Folder names.
Rename it to like /Takeout/Fit/working/
Adjust the Name in the config.inc.php

Then, call the importer-skript:
php -f import-google-fit-to-ns.php

done.


<a href="https://www.pic-upload.de" target="_blank"><img src="https://www2.pic-upload.de/img/33044613/google-fit-nightscout.jpg" title="Bilder oder Fotos hochladen"></a>


Important! This code/classes are very old and can be optimized :-)
You use it, how it is. Or update/made it better :-)
