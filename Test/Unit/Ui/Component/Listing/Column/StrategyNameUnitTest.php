<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Test\Unit\Ui\Component\Listing\Column;

use bitExpert\ForceCustomerLogin\Ui\Component\Listing\Column\StrategyName;

/**
 * Class StrategyNameUnitTest
 * @package bitExpert\ForceCustomerLogin\Test\Unit\Ui\Component\Listing\Column
 */
class StrategyNameUnitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function prepareDataSourceSuccessfully()
    {
        $strategy = $this->createMock('\bitExpert\ForceCustomerLogin\Helper\Strategy\StrategyInterface');
        $strategy->expects($this->once())
            ->method('getName')
            ->willReturn('FooBar');

        $strategyManager = $this->getStrategyManager();
        $strategyManager->expects($this->at(0))
            ->method('has')
            ->with('baz')
            ->willReturn(false);
        $strategyManager->expects($this->at(1))
            ->method('has')
            ->with('foobar')
            ->willReturn(true);
        $strategyManager->expects($this->at(2))
            ->method('get')
            ->with('foobar')
            ->willReturn($strategy);

        $action = new StrategyName(
            $this->getContext(),
            $strategyManager,
            $this->getUiComponentFactory()
        );

        $action->setData([
            'name' => 'strategy'
        ]);

        $dataSource = ['foo' => 'bar'];
        $this->assertEquals($dataSource, $action->prepareDataSource($dataSource));

        $dataSource = [
            'data' => [
                'items' => [
                    [
                        'foo' => 'bar'
                    ],
                    [
                        'strategy' => 'baz'
                    ],
                    [
                        'strategy' => 'foobar'
                    ]
                ]
            ]
        ];

        $expectedDataSource = [
            'data' => [
                'items' => [
                    [
                        'foo' => 'bar'
                    ],
                    [
                        'strategy' => 'baz'
                    ],
                    [
                        'strategy' => 'FooBar'
                    ]
                ]
            ]
        ];

        $this->assertEquals($expectedDataSource, $action->prepareDataSource($dataSource));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\View\Element\UiComponent\ContextInterface
     */
    protected function getContext()
    {
        return $this->createMock('\Magento\Framework\View\Element\UiComponent\ContextInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\View\Element\UiComponentFactory
     */
    protected function getUiComponentFactory()
    {
        return $this->getMockBuilder('\Magento\Framework\View\Element\UiComponentFactory')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\bitExpert\ForceCustomerLogin\Helper\Strategy\StrategyManager
     */
    protected function getStrategyManager()
    {
        return $this->getMockBuilder('\bitExpert\ForceCustomerLogin\Helper\Strategy\StrategyManager')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
