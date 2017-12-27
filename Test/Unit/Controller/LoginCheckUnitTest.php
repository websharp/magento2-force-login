<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BitExpert\ForceCustomerLogin\Test\Unit\Controller;

use BitExpert\ForceCustomerLogin\Api\Controller\LoginCheckInterface;
use BitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface;
use BitExpert\ForceCustomerLogin\Controller\LoginCheck;
use BitExpert\ForceCustomerLogin\Controller\ModuleCheck;
use BitExpert\ForceCustomerLogin\Helper\Strategy\StrategyInterface;
use BitExpert\ForceCustomerLogin\Helper\Strategy\StrategyManager;
use BitExpert\ForceCustomerLogin\Model\ResourceModel\WhitelistEntry\Collection;
use BitExpert\ForceCustomerLogin\Model\Session;
use BitExpert\ForceCustomerLogin\Model\WhitelistEntry;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Request\Http as RequestHttp;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\Http as ResponseHttp;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class LoginCheckUnitTest
 *
 * @package BitExpert\ForceCustomerLogin\Test\Unit\Controller
 */
class LoginCheckUnitTest extends TestCase
{
    /**
     * @test
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(LoginCheck::class));
    }

    /**
     * @test
     * @depends testClassExists
     */
    public function testConstructor()
    {
        $loginCheck = new LoginCheck(
            $this->getContext(),
            $this->getCustomerSession(),
            $this->getSession(),
            $this->getScopeConfig(),
            $this->getWhitelistRepository(),
            $this->getStrategyManager(),
            $this->getModuleCheck(),
            $this->getResponseHttp()
        );

        // check if mandatory interfaces are implemented
        $classInterfaces = class_implements($loginCheck);
        $this->assertContains(LoginCheckInterface::class, $classInterfaces);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Context
     */
    private function getContext()
    {
        return $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Customer\Model\Session
     */
    private function getCustomerSession()
    {
        return $this->getMockBuilder(CustomerSession::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\BitExpert\ForceCustomerLogin\Model\Session
     */
    private function getSession()
    {
        return $this->getMockBuilder(Session::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'setAfterLoginReferer'
            ])
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ScopeConfigInterface
     */
    private function getScopeConfig()
    {
        return $this->getMockBuilder(ScopeConfigInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|WhitelistRepositoryInterface
     */
    private function getWhitelistRepository()
    {
        return $this->createMock(WhitelistRepositoryInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|StrategyManager
     */
    private function getStrategyManager()
    {
        return $this->getMockBuilder(StrategyManager::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ModuleCheck
     */
    private function getModuleCheck()
    {
        return $this->getMockBuilder(ModuleCheck::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\App\Response\Http
     */
    private function getResponseHttp()
    {
        return $this->getMockBuilder(ResponseHttp::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Run test with url equals target, so no redirecting is happening.
     *
     * @test
     * @depends testConstructor
     */
    public function skipMatchingWhenModuleIsDisabled()
    {
        $moduleCheck = $this->getModuleCheck();
        $moduleCheck->expects($this->once())
            ->method('isModuleEnabled')
            ->willReturn(false);

        // --- Context
        $url = $this->getUrl();
        $url->expects($this->never())
            ->method('getCurrentUrl');

        $response = $this->getResponse();
        $redirect = $this->getRedirect();

        $context = $this->getContext();
        $context->expects($this->exactly(1))
            ->method('getUrl')
            ->will($this->returnValue($url));
        $context->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));
        $context->expects($this->once())
            ->method('getRedirect')
            ->will($this->returnValue($redirect));

        $loginCheck = new LoginCheck(
            $context,
            $this->getCustomerSession(),
            $this->getSession(),
            $this->getScopeConfig(),
            $this->getWhitelistRepository(),
            $this->getStrategyManager(),
            $moduleCheck,
            $this->getResponseHttp()
        );

        $loginCheck->execute();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|UrlInterface
     */
    private function getUrl()
    {
        return $this->createMock(UrlInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ResponseInterface
     */
    private function getResponse()
    {
        return $this->createMock(ResponseInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|RedirectInterface
     */
    private function getRedirect()
    {
        return $this->createMock(RedirectInterface::class);
    }

    /**
     * Run test with existing customer session, so no redirecting is happening.
     *
     * @test
     * @depends testConstructor
     */
    public function skipMatchingWhenCustomerSessionIsActive()
    {
        $moduleCheck = $this->getModuleCheck();
        $moduleCheck->expects($this->once())
            ->method('isModuleEnabled')
            ->willReturn(true);

        $customerSession = $this->getCustomerSession();
        $customerSession->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(true);

        // --- Context
        $url = $this->getUrl();
        $url->expects($this->never())
            ->method('getCurrentUrl');

        $response = $this->getResponse();
        $redirect = $this->getRedirect();

        $context = $this->getContext();
        $context->expects($this->exactly(1))
            ->method('getUrl')
            ->will($this->returnValue($url));
        $context->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));
        $context->expects($this->once())
            ->method('getRedirect')
            ->will($this->returnValue($redirect));

        $loginCheck = new LoginCheck(
            $context,
            $customerSession,
            $this->getSession(),
            $this->getScopeConfig(),
            $this->getWhitelistRepository(),
            $this->getStrategyManager(),
            $moduleCheck,
            $this->getResponseHttp()
        );

        $loginCheck->execute();
    }

    /**
     * Run test with url equals target, so no redirecting is happening.
     *
     * @test
     * @depends testConstructor
     */
    public function urlMatchesTargetUrlExactlyAndNoRedirectIsForced()
    {
        $urlString = 'http://example.tld/customer/account/login';
        $targetUrl = '/customer/account/login';

        // --- Scope Config
        $scopeConfig = $this->getScopeConfig();
        $scopeConfig->expects($this->once())
            ->method('getValue')
            ->with(
                LoginCheckInterface::MODULE_CONFIG_TARGET,
                ScopeInterface::SCOPE_STORE
            )
            ->will($this->returnValue($targetUrl));

        // --- Context
        $url = $this->getUrl();
        $url->expects($this->once())
            ->method('getCurrentUrl')
            ->will($this->returnValue($urlString));

        $response = $this->getResponse();
        $redirect = $this->getRedirect();

        $context = $this->getContext();
        $context->expects($this->exactly(1))
            ->method('getUrl')
            ->will($this->returnValue($url));
        $context->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));
        $context->expects($this->once())
            ->method('getRedirect')
            ->will($this->returnValue($redirect));

        // --- Response
        $responseHttp = $this->getResponseHttp();
        $responseHttp->expects($this->never())
            ->method('setNoCacheHeaders');
        $responseHttp->expects($this->never())
            ->method('setRedirect');
        $responseHttp->expects($this->never())
            ->method('sendResponse');

        // --- Whitelist Entries
        $whitelistRepository = $this->getWhitelistRepository();
        $whitelistRepository->expects($this->never())
            ->method('getCollection');

        // --- Strategy
        $strategyManager = $this->getStrategyManager();
        $strategyManager->expects($this->never())
            ->method('get');

        $loginCheck = new LoginCheck(
            $context,
            $this->getCustomerSession(),
            $this->getSession(),
            $scopeConfig,
            $whitelistRepository,
            $strategyManager,
            $this->getModuleCheck(),
            $responseHttp
        );

        $loginCheck->execute();
    }

    /**
     * Run test with data listed on the whitelist, so no redirecting is happening.
     *
     * @test
     * @depends testConstructor
     */
    public function ruleMatchingPositiveWithoutRedirect()
    {
        $urlString = 'http://example.tld/foo/bar';
        $targetUrl = '/customer/account/login';

        // --- Scope Config
        $scopeConfig = $this->getScopeConfig();
        $scopeConfig->expects($this->once())
            ->method('getValue')
            ->with(
                LoginCheckInterface::MODULE_CONFIG_TARGET,
                ScopeInterface::SCOPE_STORE
            )
            ->will($this->returnValue($targetUrl));

        // --- Context
        $url = $this->getUrl();
        $url->expects($this->once())
            ->method('getCurrentUrl')
            ->will($this->returnValue($urlString));

        $response = $this->getResponse();
        $redirect = $this->getRedirect();

        $context = $this->getContext();
        $context->expects($this->exactly(1))
            ->method('getUrl')
            ->will($this->returnValue($url));
        $context->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));
        $context->expects($this->once())
            ->method('getRedirect')
            ->will($this->returnValue($redirect));

        // --- Response
        $responseHttp = $this->getResponseHttp();
        $responseHttp->expects($this->never())
            ->method('setNoCacheHeaders');
        $responseHttp->expects($this->never())
            ->method('setRedirect');
        $responseHttp->expects($this->never())
            ->method('sendResponse');

        // --- Whitelist Entries
        $whitelistEntityOne = $this->getMockBuilder(WhitelistEntry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $whitelistEntityOne->expects($this->once())
            ->method('getStrategy')
            ->will($this->returnValue('default'));
        $whitelistCollection = $this
            ->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $whitelistCollection->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue([$whitelistEntityOne]));
        $whitelistRepository = $this->getWhitelistRepository();
        $whitelistRepository->expects($this->once())
            ->method('getCollection')
            ->will($this->returnValue($whitelistCollection));

        // --- Strategy
        $strategy = $this->createMock(StrategyInterface::class);
        $strategy->expects($this->once())
            ->method('isMatch')
            ->with('/foo/bar', $whitelistEntityOne)
            ->willReturn(true);

        $strategyManager = $this->getStrategyManager();
        $strategyManager->expects($this->once())
            ->method('get')
            ->with('default')
            ->willReturn($strategy);

        $loginCheck = new LoginCheck(
            $context,
            $this->getCustomerSession(),
            $this->getSession(),
            $scopeConfig,
            $whitelistRepository,
            $strategyManager,
            $this->getModuleCheck(),
            $responseHttp
        );

        $loginCheck->execute();
    }

    /**
     * Run test with data not listed on the whitelist, so redirecting is forced.
     *
     * @test
     * @depends testConstructor
     */
    public function ruleMatchingFailsAndResultsInRedirect()
    {
        $urlString = 'http://example.tld/foo/bar';
        $targetUrl = '/customer/account/login';

        // --- Scope Config
        $scopeConfig = $this->getScopeConfig();
        $scopeConfig->expects($this->once())
            ->method('getValue')
            ->with(
                LoginCheckInterface::MODULE_CONFIG_TARGET,
                ScopeInterface::SCOPE_STORE
            )
            ->will($this->returnValue($targetUrl));

        // --- Context
        $url = $this->getUrl();
        $url->expects($this->once())
            ->method('getCurrentUrl')
            ->will($this->returnValue($urlString));

        $request = $this->getRequest();
        $response = $this->getResponse();
        $redirect = $this->getRedirect();

        $context = $this->getContext();
        $context->expects($this->exactly(1))
            ->method('getUrl')
            ->will($this->returnValue($url));
        $context->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($request));
        $context->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));
        $context->expects($this->once())
            ->method('getRedirect')
            ->will($this->returnValue($redirect));

        // --- Response
        $responseHttp = $this->getResponseHttp();
        $responseHttp->expects($this->once())
            ->method('setNoCacheHeaders');
        $responseHttp->expects($this->once())
            ->method('setRedirect')
            ->with($targetUrl);
        $responseHttp->expects($this->once())
            ->method('sendResponse');

        // --- Request
        $request->expects($this->exactly(2))
            ->method('getParam');

        // --- Whitelist Entries
        $whitelistEntityOne = $this->getMockBuilder(WhitelistEntry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $whitelistEntityOne->expects($this->once())
            ->method('getStrategy')
            ->will($this->returnValue('default'));
        $whitelistCollection = $this
            ->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $whitelistCollection->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue([$whitelistEntityOne]));
        $whitelistRepository = $this->getWhitelistRepository();
        $whitelistRepository->expects($this->once())
            ->method('getCollection')
            ->will($this->returnValue($whitelistCollection));

        // --- Strategy
        $strategy = $this->createMock(StrategyInterface::class);
        $strategy->expects($this->once())
            ->method('isMatch')
            ->with('/foo/bar', $whitelistEntityOne)
            ->willReturn(false);

        $strategyManager = $this->getStrategyManager();
        $strategyManager->expects($this->once())
            ->method('get')
            ->with('default')
            ->will($this->returnValue($strategy));

        // -- Session
        $session = $this->getSession();
        $session->expects($this->once())
            ->method('setAfterLoginReferer')
            ->with('/foo/bar');

        $loginCheck = new LoginCheck(
            $context,
            $this->getCustomerSession(),
            $session,
            $scopeConfig,
            $whitelistRepository,
            $strategyManager,
            $this->getModuleCheck(),
            $responseHttp
        );

        $loginCheck->execute();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|RequestInterface
     */
    private function getRequest()
    {
        return $this->createMock(RequestInterface::class);
    }

    /**
     * Run test with ajax request and rule matching fails, so redirect is happening but "after login url" is not saved.
     *
     * @test
     * @depends testConstructor
     */
    public function requestIsAjaxAndRuleMatchingFails()
    {
        $urlString = 'http://example.tld/company-module/api/endpoint';
        $targetUrl = '/customer/account/login';

        // --- Scope Config
        $scopeConfig = $this->getScopeConfig();
        $scopeConfig->expects($this->once())
            ->method('getValue')
            ->with(
                LoginCheckInterface::MODULE_CONFIG_TARGET,
                ScopeInterface::SCOPE_STORE
            )
            ->will($this->returnValue($targetUrl));

        // --- Context
        $url = $this->getUrl();
        $url->expects($this->once())
            ->method('getCurrentUrl')
            ->will($this->returnValue($urlString));

        $request = $this->getRequest();
        $response = $this->getResponse();
        $redirect = $this->getRedirect();

        $context = $this->getContext();
        $context->expects($this->exactly(1))
            ->method('getUrl')
            ->will($this->returnValue($url));
        $context->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($request));
        $context->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));
        $context->expects($this->once())
            ->method('getRedirect')
            ->will($this->returnValue($redirect));

        // --- Response
        $responseHttp = $this->getResponseHttp();
        $responseHttp->expects($this->once())
            ->method('setNoCacheHeaders');
        $responseHttp->expects($this->once())
            ->method('setRedirect')
            ->with($targetUrl);
        $responseHttp->expects($this->once())
            ->method('sendResponse');

        // --- Request
        $request->expects($this->exactly(2))
            ->method('getParam')
            ->will(
                $this->returnValueMap([
                    ['ajax', null, null],
                    ['isAjax', null, '1']
                ])
            );

        // --- Whitelist Entries
        $whitelistEntityOne = $this->getMockBuilder(WhitelistEntry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $whitelistEntityOne->expects($this->once())
            ->method('getStrategy')
            ->will($this->returnValue('default'));
        $whitelistCollection = $this
            ->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $whitelistCollection->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue([$whitelistEntityOne]));
        $whitelistRepository = $this->getWhitelistRepository();
        $whitelistRepository->expects($this->once())
            ->method('getCollection')
            ->will($this->returnValue($whitelistCollection));

        // --- Strategy
        $strategy = $this->createMock(StrategyInterface::class);
        $strategy->expects($this->once())
            ->method('isMatch')
            ->with('/company-module/api/endpoint', $whitelistEntityOne)
            ->willReturn(false);

        $strategyManager = $this->getStrategyManager();
        $strategyManager->expects($this->once())
            ->method('get')
            ->with('default')
            ->will($this->returnValue($strategy));

        // -- Session
        $session = $this->getSession();
        $session->expects($this->never())
            ->method('setAfterLoginReferer');

        $loginCheck = new LoginCheck(
            $context,
            $this->getCustomerSession(),
            $session,
            $scopeConfig,
            $whitelistRepository,
            $strategyManager,
            $this->getModuleCheck(),
            $responseHttp
        );

        $loginCheck->execute();
    }

    /**
     * Run test with default request object and with data not listed on the whitelist, so redirecting is forced and
     * "isAjax" method is hit.
     *
     * @test
     * @depends testConstructor
     */
    public function ruleMatchingFailsAjaxCheckUsesHttpObject()
    {
        $urlString = 'http://example.tld/foo/bar';
        $targetUrl = '/customer/account/login';

        // --- Scope Config
        $scopeConfig = $this->getScopeConfig();
        $scopeConfig->expects($this->once())
            ->method('getValue')
            ->with(
                LoginCheckInterface::MODULE_CONFIG_TARGET,
                ScopeInterface::SCOPE_STORE
            )
            ->will($this->returnValue($targetUrl));

        // --- Context
        $url = $this->getUrl();
        $url->expects($this->once())
            ->method('getCurrentUrl')
            ->will($this->returnValue($urlString));

        $request = $this->getRequestObject();
        $response = $this->getResponse();
        $redirect = $this->getRedirect();

        $context = $this->getContext();
        $context->expects($this->exactly(1))
            ->method('getUrl')
            ->will($this->returnValue($url));
        $context->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($request));
        $context->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));
        $context->expects($this->once())
            ->method('getRedirect')
            ->will($this->returnValue($redirect));

        // --- Response
        $responseHttp = $this->getResponseHttp();
        $responseHttp->expects($this->once())
            ->method('setNoCacheHeaders');
        $responseHttp->expects($this->once())
            ->method('setRedirect')
            ->with($targetUrl);
        $responseHttp->expects($this->once())
            ->method('sendResponse');

        // --- Request
        $request->expects($this->once())
            ->method('isAjax')
            ->willReturn(false);

        // --- Whitelist Entries
        $whitelistEntityOne = $this->getMockBuilder(WhitelistEntry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $whitelistEntityOne->expects($this->once())
            ->method('getStrategy')
            ->will($this->returnValue('default'));
        $whitelistCollection = $this
            ->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $whitelistCollection->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue([$whitelistEntityOne]));
        $whitelistRepository = $this->getWhitelistRepository();
        $whitelistRepository->expects($this->once())
            ->method('getCollection')
            ->will($this->returnValue($whitelistCollection));

        // --- Strategy
        $strategy = $this->createMock(StrategyInterface::class);
        $strategy->expects($this->once())
            ->method('isMatch')
            ->with('/foo/bar', $whitelistEntityOne)
            ->willReturn(false);

        $strategyManager = $this->getStrategyManager();
        $strategyManager->expects($this->once())
            ->method('get')
            ->with('default')
            ->will($this->returnValue($strategy));

        // -- Session
        $session = $this->getSession();
        $session->expects($this->once())
            ->method('setAfterLoginReferer')
            ->with('/foo/bar');

        $loginCheck = new LoginCheck(
            $context,
            $this->getCustomerSession(),
            $session,
            $scopeConfig,
            $whitelistRepository,
            $strategyManager,
            $this->getModuleCheck(),
            $responseHttp
        );

        $loginCheck->execute();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\App\Request\Http
     */
    private function getRequestObject()
    {
        return $this->createMock(RequestHttp::class);
    }
}
