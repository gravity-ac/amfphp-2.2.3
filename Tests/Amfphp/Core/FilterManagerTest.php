<?php
/*
 *  This file is part of amfPHP
 *
 * LICENSE
 *
 * This source file is subject to the license that is bundled
 * with this package in the file license.txt.
 */


require_once dirname(__FILE__) . '/../../../Amfphp/ClassLoader.php';

/**
 * Test class for Amfphp_Core_FilterManager.
 * @package Tests_Amfphp_Core
 * @author Ariel Sommeria-klein
 */
class Amfphp_Core_FilterManagerTest extends PHPUnit_Framework_TestCase {
    public function testFilter() {
        $hookManager = Amfphp_Core_FilterManager::getInstance();
        //add the same hook twice to test filtering
        $hookManager->addFilter("TESTFILTER", $this, "double");
        $hookManager->addFilter("TESTFILTER", $this, "double");

        $ret = $hookManager->callFilters("TESTFILTER", 1);
        $this->assertEquals(4, $ret);


    }

    /**
     * note: this function must be public to be called. This is called by hook
     * @param <type> $valueToDouble
     * @return <type>
     */
    public function double($valueToDouble){
        return $valueToDouble * 2;
    }

}

?>
