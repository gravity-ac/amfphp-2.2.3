<?php
/**
 *  This file is part of amfPHP installed with Composer
 *
 */ 
 
require ('../../app/autoload.php');
$serviceFolderLocation = '/var/www/muse.museapp.ai/services/';

$config = new Amfphp_Core_Config();
$config->serviceFolders = array($serviceFolderLocation);

$gateway = Amfphp_Core_HttpRequestGatewayFactory::createGateway($config);
$gateway->service();
$gateway->output();

?>
