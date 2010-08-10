<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Service_Amazon
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: AbstractTest.php 17667 2009-08-18 21:40:09Z mikaelkael $
 */

/**
 * @namespace
 */
namespace ZendTest\Service\Amazon\Ec2;
use Zend\Service\Amazon;

/**
 * @category   Zend
 * @package    Zend_Service_Amazon
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @group      Zend_Service
 * @group      Zend_Service_Amazon
 * @group      Zend_Service_Amazon_Ec2
 */
class AbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testNoKeysThrowException()
    {
        try {
            $class = new TestAmazonAbstract();
            $this->fail('Exception should be thrown when no keys are passed in.');
        } catch(Amazon\Exception $zsae) {}
    }

    public function testSetRegion()
    {
        TestAmazonAbstract::setRegion('eu-west-1');

        $class = new TestAmazonAbstract('TestAccessKey', 'TestSecretKey');
        $this->assertEquals('eu-west-1', $class->returnRegion());
    }

    public function testSetInvalidRegionThrowsException()
    {
        try {
            TestAmazonAbstract::setRegion('eu-west-1a');
            $this->fail('Invalid Region Set with no Exception Thrown');
        } catch (Amazon\Exception $zsae) {
            // do nothing
        }
    }
    
    public function testSignParamsWithSpaceEncodesWithPercentInsteadOfPlus()
    {
        $class = new TestAmazonAbstract('TestAccessKey', 'TestSecretKey');
        $ret = $class->testSign(array('Action' => 'Space Test'));
        
        // this is the encode signuature with urlencode - It's Invalid!
        $invalidSignature = 'EeHAfo7cMcLyvH4SW4fEpjo51xJJ4ES1gdjRPxZTlto=';
        
        $this->assertNotEquals($ret, $invalidSignature);
    }
}

class TestAmazonAbstract extends \Zend\Service\Amazon\Ec2\AbstractEc2
{

    public function returnRegion()
    {
        return $this->_region;
    }
    
    public function testSign($params)
    {
        return $this->signParameters($params);
    }
}

