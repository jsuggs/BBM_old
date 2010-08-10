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
 * @package    Zend_Loader
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

namespace ZendTest\Loader;

use \stdClass,
    \Zend\Loader\Autoloader as ZendAutoloader;

/**
 * @category   Zend
 * @package    Zend_Loader
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @group      Zend_Loader
 */
class AutoloaderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Store original autoloaders
        $this->loaders = spl_autoload_functions();
        if (!is_array($this->loaders)) {
            // spl_autoload_functions does not return empty array when no
            // autoloaders registered...
            $this->loaders = array();
        }

        // Store original include_path
        $this->includePath = get_include_path();

        ZendAutoloader::resetInstance();
        $this->autoloader = ZendAutoloader::getInstance();

        // initialize 'error' member for tests that utilize error handling
        $this->error = null;
    }

    public function tearDown()
    {
        // Restore original autoloaders
        $loaders = spl_autoload_functions();
        foreach ($loaders as $loader) {
            spl_autoload_unregister($loader);
        }

        foreach ($this->loaders as $loader) {
            spl_autoload_register($loader);
        }

        // Retore original include_path
        set_include_path($this->includePath);

        // Reset autoloader instance so it doesn't affect other tests
        ZendAutoloader::resetInstance();
        ZendAutoloader::getInstance();
    }

    public function testAutoloaderShouldBeSingleton()
    {
        $autoloader = ZendAutoloader::getInstance();
        $this->assertSame($this->autoloader, $autoloader);
    }

    public function testSingletonInstanceShouldAllowReset()
    {
        ZendAutoloader::resetInstance();
        $autoloader = ZendAutoloader::getInstance();
        $this->assertNotSame($this->autoloader, $autoloader);
    }

    public function testAutoloaderShouldRegisterItselfWithSplAutoloader()
    {
        $autoloaders = spl_autoload_functions();
        $found = false;
        foreach ($autoloaders as $loader) {
            if (is_array($loader)) {
                if (('autoload' == $loader[1]) && ($loader[0] === get_class($this->autoloader))) {
                    $found = true;
                    break;
                }
            }
        }
        $this->assertTrue($found, 'Autoloader instance not found in spl_autoload stack: ' . var_export($autoloaders, 1));
    }

    public function testDefaultAutoloaderShouldBeZendLoader()
    {
        $this->assertSame(array('\\Zend\\Loader', 'loadClass'), $this->autoloader->getDefaultAutoloader());
    }

    public function testDefaultAutoloaderShouldBeMutable()
    {
        $this->autoloader->setDefaultAutoloader(array($this, 'autoload'));
        $this->assertSame(array($this, 'autoload'), $this->autoloader->getDefaultAutoloader());
    }

    public function testSpecifyingInvalidDefaultAutoloaderShouldRaiseException()
    {
        $this->setExpectedException('\\Zend\\Loader\\InvalidCallbackException');
        $this->autoloader->setDefaultAutoloader(uniqid());
    }

    public function testZfNamespacesShouldBeRegisteredByDefault()
    {
        $namespaces = $this->autoloader->getRegisteredNamespaces();
        $this->assertContains('Zend', $namespaces);
        $this->assertContains('ZendX', $namespaces);
    }

    public function testAutoloaderShouldAllowRegisteringArbitraryNamespaces()
    {
        $this->autoloader->registerNamespace('Phly');
        $namespaces = $this->autoloader->getRegisteredNamespaces();
        $this->assertContains('Phly', $namespaces);
    }

    public function testAutoloaderShouldAllowRegisteringMultipleNamespacesAtOnce()
    {
        $this->autoloader->registerNamespace(array('Phly', 'Solar'));
        $namespaces = $this->autoloader->getRegisteredNamespaces();
        $this->assertContains('Phly', $namespaces);
        $this->assertContains('Solar', $namespaces);
    }

    public function testRegisteringInvalidNamespaceSpecShouldRaiseException()
    {
        $this->setExpectedException('\\Zend\\Loader\\InvalidNamespaceException');
        $o = new stdClass;
        $this->autoloader->registerNamespace($o);
    }

    public function testAutoloaderShouldAllowUnregisteringNamespaces()
    {
        $this->autoloader->unregisterNamespace('Zend');
        $namespaces = $this->autoloader->getRegisteredNamespaces();
        $this->assertNotContains('Zend', $namespaces);
    }

    public function testAutoloaderShouldAllowUnregisteringMultipleNamespacesAtOnce()
    {
        $this->autoloader->unregisterNamespace(array('Zend', 'ZendX'));
        $namespaces = $this->autoloader->getRegisteredNamespaces();
        $this->assertNotContains('Zend', $namespaces);
        $this->assertNotContains('ZendX', $namespaces);
    }

    public function testUnregisteringInvalidNamespaceSpecShouldRaiseException()
    {
        $this->setExpectedException('\\Zend\\Loader\\InvalidNamespaceException');
        $o = new stdClass;
        $this->autoloader->unregisterNamespace($o);
    }

    public function testZfPrefixesShouldBeRegisteredByDefault()
    {
        $prefixes = $this->autoloader->getRegisteredPrefixes();
        $this->assertContains('Zend_', $prefixes);
        $this->assertContains('ZendX_', $prefixes);
    }

    public function testAutoloaderShouldAllowRegisteringArbitraryPrefixes()
    {
        $this->autoloader->registerPrefix('Phly_');
        $prefixes = $this->autoloader->getRegisteredPrefixes();
        $this->assertContains('Phly_', $prefixes);
    }

    public function testAutoloaderShouldAllowRegisteringMultiplePrefixesAtOnce()
    {
        $this->autoloader->registerPrefix(array('Phly_', 'Solar_'));
        $prefixes = $this->autoloader->getRegisteredPrefixes();
        $this->assertContains('Phly_', $prefixes);
        $this->assertContains('Solar_', $prefixes);
    }

    public function testRegisteringInvalidPrefixSpecShouldRaiseException()
    {
        $this->setExpectedException('\\Zend\\Loader\\InvalidPrefixException');
        $o = new stdClass;
        $this->autoloader->registerPrefix($o);
    }

    public function testAutoloaderShouldAllowUnregisteringPrefixes()
    {
        $this->autoloader->unregisterPrefix('Zend');
        $prefixes = $this->autoloader->getRegisteredPrefixes();
        $this->assertNotContains('Zend', $prefixes);
    }

    public function testAutoloaderShouldAllowUnregisteringMultiplePrefixesAtOnce()
    {
        $this->autoloader->unregisterPrefix(array('Zend', 'ZendX'));
        $prefixes = $this->autoloader->getRegisteredPrefixes();
        $this->assertNotContains('Zend', $prefixes);
        $this->assertNotContains('ZendX', $prefixes);
    }

    public function testUnregisteringInvalidPrefixSpecShouldRaiseException()
    {
        $this->setExpectedException('\\Zend\\Loader\\InvalidPrefixException');
        $o = new stdClass;
        $this->autoloader->unregisterPrefix($o);
    }

    /**
     * @group ZF-6536
     */
    public function testWarningSuppressionShouldBeDisabledByDefault()
    {
        $this->assertFalse($this->autoloader->suppressNotFoundWarnings());
    }

    public function testAutoloaderSuppressNotFoundWarningsFlagShouldBeMutable()
    {
        $this->autoloader->suppressNotFoundWarnings(true);
        $this->assertTrue($this->autoloader->suppressNotFoundWarnings());
    }

    public function testFallbackAutoloaderFlagShouldBeOffByDefault()
    {
        $this->assertFalse($this->autoloader->isFallbackAutoloader());
    }

    public function testFallbackAutoloaderFlagShouldBeMutable()
    {
        $this->autoloader->setFallbackAutoloader(true);
        $this->assertTrue($this->autoloader->isFallbackAutoloader());
    }

    public function testUnshiftAutoloaderShouldAddToTopOfAutoloaderStack()
    {
        $this->autoloader->unshiftAutoloader('require');
        $autoloaders = $this->autoloader->getAutoloaders();
        $test = array_shift($autoloaders);
        $this->assertEquals('require', $test);
    }

    public function testUnshiftAutoloaderWithoutNamespaceShouldRegisterAsEmptyNamespace()
    {
        $this->autoloader->unshiftAutoloader('require');
        $autoloaders = $this->autoloader->getNamespaceAutoloaders('');
        $test = array_shift($autoloaders);
        $this->assertEquals('require', $test);
    }

    public function testUnshiftAutoloaderShouldAllowSpecifyingSingleNamespace()
    {
        $this->autoloader->unshiftAutoloader('require', 'Foo');
        $autoloaders = $this->autoloader->getNamespaceAutoloaders('Foo');
        $test = array_shift($autoloaders);
        $this->assertEquals('require', $test);
    }

    public function testUnshiftAutoloaderShouldAllowSpecifyingMultipleNamespaces()
    {
        $this->autoloader->unshiftAutoloader('require', array('Foo', 'Bar'));

        $autoloaders = $this->autoloader->getNamespaceAutoloaders('Foo');
        $test = array_shift($autoloaders);
        $this->assertEquals('require', $test);

        $autoloaders = $this->autoloader->getNamespaceAutoloaders('Bar');
        $test = array_shift($autoloaders);
        $this->assertEquals('require', $test);
    }

    public function testPushAutoloaderShouldAddToEndOfAutoloaderStack()
    {
        $this->autoloader->pushAutoloader('require');
        $autoloaders = $this->autoloader->getAutoloaders();
        $test = array_pop($autoloaders);
        $this->assertEquals('require', $test);
    }

    public function testPushAutoloaderWithoutNamespaceShouldRegisterAsEmptyNamespace()
    {
        $this->autoloader->pushAutoloader('require');
        $autoloaders = $this->autoloader->getNamespaceAutoloaders('');
        $test = array_pop($autoloaders);
        $this->assertEquals('require', $test);
    }

    public function testPushAutoloaderShouldAllowSpecifyingSingleNamespace()
    {
        $this->autoloader->pushAutoloader('require', 'Foo');
        $autoloaders = $this->autoloader->getNamespaceAutoloaders('Foo');
        $test = array_pop($autoloaders);
        $this->assertEquals('require', $test);
    }

    public function testPushAutoloaderShouldAllowSpecifyingMultipleNamespaces()
    {
        $this->autoloader->pushAutoloader('require', array('Foo', 'Bar'));

        $autoloaders = $this->autoloader->getNamespaceAutoloaders('Foo');
        $test = array_pop($autoloaders);
        $this->assertEquals('require', $test);

        $autoloaders = $this->autoloader->getNamespaceAutoloaders('Bar');
        $test = array_pop($autoloaders);
        $this->assertEquals('require', $test);
    }

    public function testAutoloaderShouldAllowRemovingConcreteAutoloadersFromStackByCallback()
    {
        $this->autoloader->pushAutoloader('require');
        $this->autoloader->removeAutoloader('require');
        $autoloaders = $this->autoloader->getAutoloaders();
        $this->assertNotContains('require', $autoloaders);
    }

    public function testRemovingAutoloaderShouldAlsoRemoveAutoloaderFromNamespacedAutoloaders()
    {
        $this->autoloader->pushAutoloader('require', array('Foo', 'Bar'))
                         ->pushAutoloader('include');
        $this->autoloader->removeAutoloader('require');
        $test = $this->autoloader->getNamespaceAutoloaders('Foo');
        $this->assertTrue(empty($test));
        $test = $this->autoloader->getNamespaceAutoloaders('Bar');
        $this->assertTrue(empty($test));
    }

    public function testAutoloaderShouldAllowRemovingCallbackFromSpecifiedNamespaces()
    {
        $this->autoloader->pushAutoloader('require', array('Foo', 'Bar'))
                         ->pushAutoloader('include');
        $this->autoloader->removeAutoloader('require', 'Foo');
        $test = $this->autoloader->getNamespaceAutoloaders('Foo');
        $this->assertTrue(empty($test));
        $test = $this->autoloader->getNamespaceAutoloaders('Bar');
        $this->assertFalse(empty($test));
    }

    public function testAutoloadShouldReturnFalseWhenNamespaceIsNotRegistered()
    {
        $this->assertFalse(ZendAutoloader::autoload('Foo_Bar'));
    }

    public function testAutoloadShouldReturnFalseWhenNamespaceIsNotRegisteredButClassfileExists()
    {
        $this->addTestIncludePath();
        $this->assertFalse(ZendAutoloader::autoload('ZendLoaderAutoloader_Foo'));
    }

    public function testAutoloadShouldLoadClassWhenNamespaceIsRegisteredAndClassfileExists()
    {
        $this->addTestIncludePath();
        $this->autoloader->registerPrefix('ZendLoaderAutoloader');
        $result = ZendAutoloader::autoload('ZendLoaderAutoloader_Foo');
        $this->assertFalse($result === false);
        $this->assertTrue(class_exists('ZendLoaderAutoloader_Foo', false));
    }

    public function testAutoloadShouldNotSuppressFileNotFoundWarningsWhenFlagIsDisabled()
    {
        $this->addTestIncludePath();
        $this->autoloader->suppressNotFoundWarnings(false);
        $this->autoloader->registerPrefix('ZendLoaderAutoloader');
        set_error_handler(array($this, 'handleErrors'));
        $this->assertFalse(ZendAutoloader::autoload('ZendLoaderAutoloader_Bar'));
        restore_error_handler();
        $this->assertNotNull($this->error);
    }

    public function testAutoloadShouldReturnTrueIfFunctionBasedAutoloaderMatchesAndReturnsNonFalseValue()
    {
        $this->autoloader->pushAutoloader('\\ZendTest\\Loader\\testAutoload');
        $this->assertTrue(ZendAutoloader::autoload('ZendLoaderAutoloader_Foo_Bar'));
    }

    public function testAutoloadShouldReturnTrueIfMethodBasedAutoloaderMatchesAndReturnsNonFalseValue()
    {
        $this->autoloader->pushAutoloader(array($this, 'autoload'));
        $this->assertTrue(ZendAutoloader::autoload('ZendLoaderAutoloader_Foo_Bar'));
    }

    public function testAutoloadShouldReturnTrueIfAutoloaderImplementationReturnsNonFalseValue()
    {
        $this->autoloader->pushAutoloader(new TestAutoloader());
        $this->assertTrue(ZendAutoloader::autoload('ZendLoaderAutoloader_Foo_Bar'));
    }

    public function testUsingAlternateDefaultLoaderShouldOverrideUsageOfZendLoader()
    {
        $this->autoloader->setDefaultAutoloader(array($this, 'autoload'));
        $class = $this->autoloader->autoload('Zend_ThisClass_WilNever_Exist');
        $this->assertEquals('Zend_ThisClass_WilNever_Exist', $class);
        $this->assertFalse(class_exists($class, false));
    }

    /**
     * @group ZF-10024
     */
    public function testClosuresRegisteredWithAutoloaderShouldBeUtilized()
    {
        if (version_compare(PHP_VERSION, '5.3.0', '<')) {
            $this->markTestSkipped(__METHOD__ . ' requires PHP version 5.3.0 or greater');
        }

        $this->autoloader->pushAutoloader(function($class) {
            require_once __DIR__ . '/_files/AutoloaderClosure.php';
        });
        $test = new AutoloaderTest_AutoloaderClosure();
        $this->assertTrue($test instanceof AutoloaderTest_AutoloaderClosure);
    }

    public function addTestIncludePath()
    {
        set_include_path(__DIR__ . '/_files/' . PATH_SEPARATOR . $this->includePath);
    }

    public function handleErrors($errno, $errstr)
    {
        $this->error = $errstr;
    }

    public function autoload($class)
    {
        return $class;
    }
}

function testAutoload($class)
{
    return $class;
}

class TestAutoloader implements \Zend\Loader\Autoloadable
{
    public function autoload($class)
    {
        return $class;
    }
}
