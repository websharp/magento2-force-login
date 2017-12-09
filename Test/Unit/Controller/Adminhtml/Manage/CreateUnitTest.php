<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BitExpert\ForceCustomerLogin\Test\Unit\Controller\Adminhtml\Manage;

use BitExpert\ForceCustomerLogin\Controller\Adminhtml\Manage\Create;
use Magento\Store\Model\ScopeInterface;

/**
 * Class ModuleCheckUnitTest
 * @package BitExpert\ForceCustomerLogin\Test\Unit\Controller
 */
class CreateUnitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function executeSuccessfully()
    {
        $view = $this->createMock('\Magento\Framework\App\ViewInterface');
        $view->expects($this->once())
            ->method('loadLayout');
        $view->expects($this->once())
            ->method('renderLayout');

        $context = $this->getContext();
        $context->expects($this->atLeastOnce())
            ->method('getView')
            ->willReturn($view);

        $action = new Create(
            $context
        );
        $action->execute();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Backend\App\Action\Context
     */
    protected function getContext()
    {
        return $this->getMockBuilder('\Magento\Backend\App\Action\Context')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
