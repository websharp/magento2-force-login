<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace bitExpert\ForceCustomerLogin\Ui\Component\Listing\Column;
function __($value) { return $value; }

namespace bitExpert\ForceCustomerLogin\Test\Unit\Ui\Component\Listing\Column;

use bitExpert\ForceCustomerLogin\Ui\Component\Listing\Column\StoreName;

/**
 * Class StoreNameUnitTest
 * @package bitExpert\ForceCustomerLogin\Test\Unit\Ui\Component\Listing\Column
 */
class StoreNameUnitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function prepareDataSourceSuccessfully()
    {
        $storeId = 42;

        $globalStore = $this->createMock('\Magento\Store\Api\Data\StoreInterface');
        $store = $this->createMock('\Magento\Store\Api\Data\StoreInterface');
        $store->expects($this->once())
            ->method('getId')
            ->willReturn($storeId);
        $store->expects($this->once())
            ->method('getName')
            ->willReturn('foobar');

        $storeManager = $this->getStoreManager();
        $storeManager->expects($this->at(0))
            ->method('getStore')
            ->with(0)
            ->willReturn($globalStore);
        $storeManager->expects($this->at(1))
            ->method('getStore')
            ->with($storeId)
            ->willReturn($store);

        $action = new StoreName(
            $this->getContext(),
            $storeManager,
            $this->getUiComponentFactory()
        );

        $action->setData([
            'name' => 'store'
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
                        'store_id' => '0'
                    ],
                    [
                        'store_id' => '42'
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
                        'store_id' => '0',
                        'store' => 'All Stores'
                    ],
                    [
                        'store_id' => '42',
                        'store' => 'foobar'
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
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Store\Model\StoreManager
     */
    protected function getStoreManager()
    {
        return $this->createMock('\Magento\Store\Model\StoreManager');
    }
}
