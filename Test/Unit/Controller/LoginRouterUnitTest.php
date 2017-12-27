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

use BitExpert\ForceCustomerLogin\Controller\LoginRouter;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class LoginCheckUnitTest
 *
 * @package BitExpert\ForceCustomerLogin\Test\Unit\Controller
 */
class LoginRouterUnitTest extends TestCase
{
    /**
     * @test
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(LoginRouter::class));
    }

    /**
     * @test
     * @depends testClassExists
     */
    public function runRedirectRoutingOnlyIfLoginCheckHasExecutedSuccessfully()
    {
        $actionFactory = $this->getActionFactory();
        $actionFactory->expects($this->once())
            ->method('create')
            ->willReturn(\Magento\Framework\App\Action\Redirect::class);

        $loginCheck = $this->getLoginCheck();
        $loginCheck->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $loginRouter = new LoginRouter(
            $actionFactory,
            $loginCheck
        );

        $request = $this->getMockBuilder(RequestInterface::class)
            ->setMethods([
                'getModuleName',
                'setModuleName',
                'getActionName',
                'setActionName',
                'getParam',
                'getParams',
                'setParams',
                'getCookie',
                'isSecure',
                'setDispatched'
            ])
            ->getMock();
        $request->expects($this->once())
            ->method('setDispatched')
            ->with(true);

        $loginRouter->match($request);
    }

    /**
     * @test
     * @depends testClassExists
     */
    public function skipRedirectRoutingIfLoginCheckHasNotBeenExecuted()
    {
        $actionFactory = $this->getActionFactory();
        $actionFactory->expects($this->never())
            ->method('create')
            ->willReturn(\Magento\Framework\App\Action\Redirect::class);

        $loginCheck = $this->getLoginCheck();
        $loginCheck->expects($this->once())
            ->method('execute')
            ->willReturn(false);

        $loginRouter = new LoginRouter(
            $actionFactory,
            $loginCheck
        );

        $request = $this->getMockBuilder('\Magento\Framework\App\RequestInterface')
            ->setMethods([
                'getModuleName',
                'setModuleName',
                'getActionName',
                'setActionName',
                'getParam',
                'getParams',
                'setParams',
                'getCookie',
                'isSecure',
                'setDispatched'
            ])
            ->getMock();
        $request->expects($this->never())
            ->method('setDispatched')
            ->with(true);

        $loginRouter->match($request);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ActionFactory
     */
    private function getActionFactory()
    {
        return $this->getMockBuilder(ActionFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\BitExpert\ForceCustomerLogin\Api\Controller\LoginCheckInterface
     */
    private function getLoginCheck()
    {
        return $this->createMock(\BitExpert\ForceCustomerLogin\Api\Controller\LoginCheckInterface::class);
    }
}
