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

/**
 * Class LoginCheckUnitTest
 *
 * @package BitExpert\ForceCustomerLogin\Test\Unit\Controller
 */
class LoginRouterUnitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists('\BitExpert\ForceCustomerLogin\Controller\LoginRouter'));
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

        $loginRouter = new \BitExpert\ForceCustomerLogin\Controller\LoginRouter(
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
            ]
            )
            ->getMock();
        $request->expects($this->once())
            ->method('setDispatched')
            ->with(true);

        $loginRouter->match($request);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\App\ActionFactory
     */
    protected function getActionFactory()
    {
        return $this->getMockBuilder('\Magento\Framework\App\ActionFactory')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\BitExpert\ForceCustomerLogin\Api\Controller\LoginCheckInterface
     */
    protected function getLoginCheck()
    {
        return $this->createMock('\BitExpert\ForceCustomerLogin\Api\Controller\LoginCheckInterface');
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

        $loginRouter = new \BitExpert\ForceCustomerLogin\Controller\LoginRouter(
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
            ]
            )
            ->getMock();
        $request->expects($this->never())
            ->method('setDispatched')
            ->with(true);

        $loginRouter->match($request);
    }
}
