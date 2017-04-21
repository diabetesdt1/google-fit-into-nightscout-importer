# google-fit-into-nightscout-importer
Imports downloaded tcx-Files from https://takeout.google.com/settings/takeout from Google-Fit over NightScout API into your NS.


Go to: https://takeout.google.com/settings/takeout
Choice only "Google-Fit"
Click to next Button
Click on "create Archiv" Button.
Wait until your Archiv is done.

Download your Archiv to your Server/Linux-Shell/Windows-PHP
Unpack it.

Adjust the Settings in "config.inc.php" like:
&gt?php
$config['home']               = dirname(__FILE__).'/';
$config['googlefitdir']       = 'Takeout/Fit/aktiv/'; # Without starting Slash from $config['home']
$config['apiurl']             = 'https://your-nightscout.domain.tld/api/v1/'; # with trailing Slash
$config['apisecret']          = 'your api secret';
$config['apisecret']          = sha1($config['apisecret']);
$config['apiadd']             = 'treatments'; # without starting slash
$config['client']             = 'Google-Fit-Importer';
$config['timeout']            = 5;   # for the API in Seconds
$config['mindauer']           = 10;  # only data, which was longer then xx Minutes
$config['minmeters']          = 500; # or only data with more then xxx meters
$config['secure']             = 1;   # 2 = ignore Cert-Failures, 1 = strict ssl-cert checking

The "googlefitdir", can be have Problems, when you have other characters inside the Folder names.

Then, call the importer-skript:
php -f import-google-fit-to-ns.php

done.

Important! This code/classes are very old and can be optimized :-)
