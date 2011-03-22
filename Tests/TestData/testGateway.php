<?php
/*
 *  This file is part of amfPHP
 *
 * LICENSE
 *
 * This source file is subject to the license that is bundled
 * with this package in the file license.txt.
 */

/* 
 * a gateway php script like the normal gateway except that it uses test services 
 * @package Tests_TestData
 * @author Ariel Sommeria-klein
 */

require_once dirname(__FILE__) . '/../../Amfphp/ClassLoader.php';
require_once dirname(__FILE__) . "/TestServicesConfig.php";
$config = new Amfphp_Core_Config();
$testServiceConfig = new TestServicesConfig();
$config->serviceFolderPaths = $testServiceConfig->serviceFolderPaths;
$config->serviceNames2ClassFindInfo = $testServiceConfig->serviceNames2ClassFindInfo;
$gateway = Amfphp_Core_HttpRequestGatewayFactory::createGateway($config);
$serializedResponse = $gateway->service();
$responseHeaders = $gateway->getResponseHeaders();
foreach($responseHeaders as $header){
    header($header);
}
echo $serializedResponse;

?>
