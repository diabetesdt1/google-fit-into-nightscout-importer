<?php
$config['home']               = dirname(__FILE__).'/';
$config['googlefitdir']       = 'Takeout/Fit/aktiv/'; # Without starting Slash from $config['home']
$config['apiurl']             = 'https://your-nightscout.domain.tld/api/v1/'; # with trailing Slash
$config['apisecret']          = 'your api secret';
$config['apisecret']          = sha1($config['apisecret']);
$config['apiadd']             = 'treatments'; # without starting slash
$config['client']             = 'Google-Fit-Importer';
$config['timeout']            = 5;   # Nightsout api timeout in secornds
$config['mindauer']           = 10;  # only data, which was longer then xx Minutes
$config['minmeters']          = 500; # or only data with more then xxx meters
$config['secure']             = 2;   # 2 = ignore Cert-Failures, 1 = strict ssl-cert checking
