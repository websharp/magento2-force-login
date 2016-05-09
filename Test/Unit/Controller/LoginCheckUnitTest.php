<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Test\Unit\Controller;

/**
 * Class LoginCheckUnitTest
 * @package bitExpert\ForceCustomerLogin\Test\Unit\Controller
 */
class LoginCheckUnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists('\bitExpert\ForceCustomerLogin\Controller\LoginCheck'));
    }

    /**
     * @test
     * @depends testClassExists
     */
    public function testConstructor()
    {
        $loginCheck = new \bitExpert\ForceCustomerLogin\Controller\LoginCheck(
            $this->getContext(),
            $this->getDeploymentConfig(),
            $this->getWhitelistRepository(),
            ''
        );

        // check if mandatory interfaces are implemented
        $classInterfaces = class_implements($loginCheck);
        $this->assertContains('bitExpert\ForceCustomerLogin\Api\Controller\LoginCheckInterface', $classInterfaces);
    }

    /**
     * @test
     * @depends testConstructor
     */
    public function testPositiveWhitelistedUrlMapping()
    {
        $urlString = 'http://example.tld/foobar/baz';
        $targetUrl = '/target-url';

        // --- Context
        $url = $this->getUrl();
        $url->expects($this->once())
            ->method('getCurrentUrl')
            ->will($this->returnValue($urlString));

        $response = $this->getResponse();
        $redirect = $this->getRedirect();

        $context = $this->getContext();
        $context->expects($this->exactly(2))
            ->method('getUrl')
            ->will($this->returnValue($url));
        $context->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));
        $context->expects($this->once())
            ->method('getRedirect')
            ->will($this->returnValue($redirect));

        // --- Whitelist Entries
        $whitelistEntityOne = $this->getMockBuilder('\bitExpert\ForceCustomerLogin\Model\WhitelistEntry')->disableOriginalConstructor()->getMock();
        $whitelistEntityOne->expects($this->once())
            ->method('getUrlRule')
            ->will($this->returnValue('/foobar'));
        $whitelistCollection = $this->getMockBuilder('\bitExpert\ForceCustomerLogin\Model\ResourceModel\WhitelistEntry\Collection')->disableOriginalConstructor()->getMock();
        $whitelistCollection->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue([$whitelistEntityOne]));
        $whitelistRepository = $this->getWhitelistRepository();
        $whitelistRepository->expects($this->once())
            ->method('getCollection')
            ->will($this->returnValue($whitelistCollection));

        // --- Deployment configuration
        $deploymentConfig = $this->getDeploymentConfig();
        $deploymentConfig->expects($this->once())
            ->method('get')
            ->with(\Magento\Backend\Setup\ConfigOptionsList::CONFIG_PATH_BACKEND_FRONTNAME)
            ->will($this->returnValue('admin'));

        $loginCheck = new \bitExpert\ForceCustomerLogin\Controller\LoginCheck(
            $context,
            $deploymentConfig,
            $whitelistRepository,
            $targetUrl
        );

        $loginCheck->execute();
    }

    /**
     * @test
     * @depends testConstructor
     */
    public function testPositiveShopwviewWhitelistedUrlMapping()
    {
        $urlString = 'http://example.tld/shopview/foobar/baz';
        $targetUrl = '/target-url';

        // --- Context
        $url = $this->getUrl();
        $url->expects($this->once())
            ->method('getCurrentUrl')
            ->will($this->returnValue($urlString));

        $response = $this->getResponse();
        $redirect = $this->getRedirect();

        $context = $this->getContext();
        $context->expects($this->exactly(2))
            ->method('getUrl')
            ->will($this->returnValue($url));
        $context->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));
        $context->expects($this->once())
            ->method('getRedirect')
            ->will($this->returnValue($redirect));

        // --- Whitelist Entries
        $whitelistEntityOne = $this->getMockBuilder('\bitExpert\ForceCustomerLogin\Model\WhitelistEntry')->disableOriginalConstructor()->getMock();
        $whitelistEntityOne->expects($this->once())
            ->method('getUrlRule')
            ->will($this->returnValue('/foobar'));
        $whitelistCollection = $this->getMockBuilder('\bitExpert\ForceCustomerLogin\Model\ResourceModel\WhitelistEntry\Collection')->disableOriginalConstructor()->getMock();
        $whitelistCollection->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue([$whitelistEntityOne]));
        $whitelistRepository = $this->getWhitelistRepository();
        $whitelistRepository->expects($this->once())
            ->method('getCollection')
            ->will($this->returnValue($whitelistCollection));

        // --- Deployment configuration
        $deploymentConfig = $this->getDeploymentConfig();
        $deploymentConfig->expects($this->once())
            ->method('get')
            ->with(\Magento\Backend\Setup\ConfigOptionsList::CONFIG_PATH_BACKEND_FRONTNAME)
            ->will($this->returnValue('admin'));

        $loginCheck = new \bitExpert\ForceCustomerLogin\Controller\LoginCheck(
            $context,
            $deploymentConfig,
            $whitelistRepository,
            $targetUrl
        );

        $loginCheck->execute();
    }

    /**
     * @test
     * @depends testConstructor
     */
    public function testNegativeWhitelistedUrlMapping()
    {
        $urlString = 'http://example.tld/foobar/baz';
        $targetUrl = '/target-url';

        // --- Context
        $url = $this->getUrl();
        $url->expects($this->once())
            ->method('getCurrentUrl')
            ->will($this->returnValue($urlString));

        $response = $this->getResponse();
        $response->expects($this->once())
            ->method('sendResponse');

        $redirect = $this->getRedirect();
        $redirect->expects($this->once())
            ->method('redirect')
            ->with($response, $targetUrl);

        $context = $this->getContext();
        $context->expects($this->exactly(2))
            ->method('getUrl')
            ->will($this->returnValue($url));
        $context->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));
        $context->expects($this->once())
            ->method('getRedirect')
            ->will($this->returnValue($redirect));

        // --- Whitelist Entries
        $whitelistEntityOne = $this->getMockBuilder('\bitExpert\ForceCustomerLogin\Model\WhitelistEntry')->disableOriginalConstructor()->getMock();
        $whitelistEntityOne->expects($this->once())
            ->method('getUrlRule')
            ->will($this->returnValue('/barfoo'));
        $whitelistCollection = $this->getMockBuilder('\bitExpert\ForceCustomerLogin\Model\ResourceModel\WhitelistEntry\Collection')->disableOriginalConstructor()->getMock();
        $whitelistCollection->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue([$whitelistEntityOne]));
        $whitelistRepository = $this->getWhitelistRepository();
        $whitelistRepository->expects($this->once())
            ->method('getCollection')
            ->will($this->returnValue($whitelistCollection));

        // --- Deployment configuration
        $deploymentConfig = $this->getDeploymentConfig();
        $deploymentConfig->expects($this->once())
            ->method('get')
            ->with(\Magento\Backend\Setup\ConfigOptionsList::CONFIG_PATH_BACKEND_FRONTNAME)
            ->will($this->returnValue('admin'));

        $loginCheck = new \bitExpert\ForceCustomerLogin\Controller\LoginCheck(
            $context,
            $deploymentConfig,
            $whitelistRepository,
            $targetUrl
        );

        $loginCheck->execute();
    }

    /**
     * @test
     * @depends testConstructor
     */
    public function testNegativeShopviewWhitelistedUrlMapping()
    {
        $urlString = 'http://example.tld/shopview/foobar/baz';
        $targetUrl = '/target-url';

        // --- Context
        $url = $this->getUrl();
        $url->expects($this->once())
            ->method('getCurrentUrl')
            ->will($this->returnValue($urlString));

        $response = $this->getResponse();
        $response->expects($this->once())
            ->method('sendResponse');

        $redirect = $this->getRedirect();
        $redirect->expects($this->once())
            ->method('redirect')
            ->with($response, $targetUrl);

        $context = $this->getContext();
        $context->expects($this->exactly(2))
            ->method('getUrl')
            ->will($this->returnValue($url));
        $context->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));
        $context->expects($this->once())
            ->method('getRedirect')
            ->will($this->returnValue($redirect));

        // --- Whitelist Entries
        $whitelistEntityOne = $this->getMockBuilder('\bitExpert\ForceCustomerLogin\Model\WhitelistEntry')->disableOriginalConstructor()->getMock();
        $whitelistEntityOne->expects($this->once())
            ->method('getUrlRule')
            ->will($this->returnValue('/barfoo'));
        $whitelistCollection = $this->getMockBuilder('\bitExpert\ForceCustomerLogin\Model\ResourceModel\WhitelistEntry\Collection')->disableOriginalConstructor()->getMock();
        $whitelistCollection->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue([$whitelistEntityOne]));
        $whitelistRepository = $this->getWhitelistRepository();
        $whitelistRepository->expects($this->once())
            ->method('getCollection')
            ->will($this->returnValue($whitelistCollection));

        // --- Deployment configuration
        $deploymentConfig = $this->getDeploymentConfig();
        $deploymentConfig->expects($this->once())
            ->method('get')
            ->with(\Magento\Backend\Setup\ConfigOptionsList::CONFIG_PATH_BACKEND_FRONTNAME)
            ->will($this->returnValue('admin'));

        $loginCheck = new \bitExpert\ForceCustomerLogin\Controller\LoginCheck(
            $context,
            $deploymentConfig,
            $whitelistRepository,
            $targetUrl
        );

        $loginCheck->execute();
    }

    /**
     * @return \Magento\Framework\App\Action\Context
     */
    protected function getContext()
    {
        return $this->getMockBuilder('\Magento\Framework\App\Action\Context')->disableOriginalConstructor()->getMock();
    }

    /**
     * @return \Magento\Framework\UrlInterface
     */
    protected function getUrl()
    {
        return $this->getMock('\Magento\Framework\UrlInterface');
    }

    /**
     * @return \Magento\Framework\App\Response\RedirectInterface
     */
    protected function getRedirect()
    {
        return $this->getMock('\Magento\Framework\App\Response\RedirectInterface');
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface
     */
    protected function getResponse()
    {
        return $this->getMock('\Magento\Framework\App\ResponseInterface');
    }

    /**
     * @return \Magento\Framework\App\DeploymentConfig
     */
    protected function getDeploymentConfig()
    {
        return $this->getMockBuilder('\Magento\Framework\App\DeploymentConfig')->disableOriginalConstructor()->getMock();
    }

    /**
     * @return \bitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface
     */
    protected function getWhitelistRepository()
    {
        return $this->getMock('\bitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface');
    }
}
