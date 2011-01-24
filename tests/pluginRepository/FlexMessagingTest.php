<?php

require_once dirname(__FILE__) . '/../../pluginRepository/FlexMessaging.php';
require_once dirname(__FILE__) . '/../../amfphp/AMFPHPClassLoader.php';
require_once dirname(__FILE__) . "/../testData/TestServicesConfig.php";

/**
 * Test class for FlexMessaging.
 * Generated by PHPUnit on 2011-01-19 at 13:23:29.
 */
class FlexMessagingTest extends PHPUnit_Framework_TestCase {

    /**
     * @var FlexMessaging
     */
    protected $object;

    /**
     *
     * @var Amfphp_Core_Common_ServiceRouter
     */
    protected $serviceRouter;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new FlexMessaging;
        $testServiceConfig = new TestServicesConfig();
        $this->serviceRouter = new Amfphp_Core_Common_ServiceRouter($testServiceConfig->serviceFolderPaths, $testServiceConfig->serviceNames2Amfphp_Core_Common_ClassFindInfo);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    public function testCommandMessage() {
        $requestMessage = new Amfphp_Core_Amf_Message(null, "/1", null);
        $requestMessage->data = array();
        $expectedResponseMessage = new Amfphp_Core_Amf_Message("/1/onResult", null, null);
        
        $command = new stdClass();
        $command->_explicitType = FlexMessaging::TYPE_FLEX_COMMAND_MESSAGE;
        $command->messageId = "690D76D5-13C0-DFBD-7F2F-9E3786B59EB5";
        $requestMessage->data[] = $command;
        $ret = $this->object->specialRequestMessageHandler($requestMessage, $this->serviceRouter, null);
        $responseMessage = $ret[2];
        $expectedAcknowledge = new AcknowledgeMessage("690D76D5-13C0-DFBD-7F2F-9E3786B59EB5");
        //copy random ids, so as not to fail test
        $expectedAcknowledge->clientId = $responseMessage->data->clientId;
        $expectedAcknowledge->messageId = $responseMessage->data->messageId;
        $expectedResponseMessage->data = $expectedAcknowledge;
        $this->assertEquals(print_r($expectedResponseMessage, true), print_r($responseMessage, true));
    }

    public function testRemotingMessage(){
        $requestMessage = new Amfphp_Core_Amf_Message(null, "/1", null);
        $requestMessage->data = array();
        $expectedResponseMessage = new Amfphp_Core_Amf_Message("/1/onResult", null, null);

        $remoting = new stdClass();
        $remoting->_explicitType = FlexMessaging::TYPE_FLEX_REMOTING_MESSAGE;
        $remoting->messageId = "690D76D5-13C0-DFBD-7F2F-9E3786B59EB5";
        $remoting->source = "MirrorService";
        $remoting->operation = "returnOneParam";
        $remoting->body = array("boo");
        $requestMessage->data[] = $remoting;
        $ret = $this->object->specialRequestMessageHandler($requestMessage, $this->serviceRouter, null);

        $responseMessage = $ret[2];
        $expectedAcknowledge = new AcknowledgeMessage("690D76D5-13C0-DFBD-7F2F-9E3786B59EB5");
        //copy random ids, so as not to fail test
        $expectedAcknowledge->clientId = $responseMessage->data->clientId;
        $expectedAcknowledge->messageId = $responseMessage->data->messageId;
        $expectedAcknowledge->body = "boo";
        $expectedResponseMessage->data = $expectedAcknowledge;
        $this->assertEquals(print_r($expectedResponseMessage, true), print_r($responseMessage, true));
    }

}

?>
