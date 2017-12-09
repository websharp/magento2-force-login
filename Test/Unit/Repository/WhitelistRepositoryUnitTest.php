<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BitExpert\ForceCustomerLogin\Test\Unit\Repository;

use BitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface;
use BitExpert\ForceCustomerLogin\Repository\WhitelistRepository;

/**
 * Class WhitelistRepositoryUnitTest
 * @package BitExpert\ForceCustomerLogin\Test\Unit\Repository
 */
class WhitelistRepositoryUnitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists('\BitExpert\ForceCustomerLogin\Repository\WhitelistRepository'));
    }

    /**
     * @test
     * @depends testClassExists
     */
    public function testConstructor()
    {
        $whitelistRepository = new WhitelistRepository(
            $this->getWhitelistEntryFactory(),
            $this->getWhitelistEntryCollectionFactory(),
            $this->getStoreManager(),
            $this->getWhitelistEntrySearchResultInterfaceFactory()
        );

        // check if mandatory interfaces are implemented
        $classInterfaces = class_implements($whitelistRepository);
        $this->assertContains(
            'BitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface',
            $classInterfaces
        );
    }

    /**
     * Run test of creating a new entry without existing entity
     * @test
     * @depends testConstructor
     */
    public function testEntryCreationWithoutExistingEntity()
    {
        $entityId = null;
        $label = 'foobar';
        $urlRule = '/foobar';
        $storeId = 0;
        $strategy = 'default';

        $expectedWhitelistEntry = $this->createMock('\BitExpert\ForceCustomerLogin\Model\WhitelistEntry');
        $expectedWhitelistEntry->expects($this->at(0))
            ->method('getId')
            ->will($this->returnValue($entityId));
        $expectedWhitelistEntry->expects($this->at(1))
            ->method('load')
            ->with($label, 'label')
            ->willReturnSelf();
        $expectedWhitelistEntry->expects($this->at(2))
            ->method('getId')
            ->will($this->returnValue($entityId));
        $expectedWhitelistEntry->expects($this->at(3))
            ->method('setLabel')
            ->with($label);
        $expectedWhitelistEntry->expects($this->at(4))
            ->method('setUrlRule')
            ->with($urlRule);
        $expectedWhitelistEntry->expects($this->at(5))
            ->method('setStrategy')
            ->with($strategy);
        $expectedWhitelistEntry->expects($this->at(6))
            ->method('setStoreId')
            ->with($storeId);
        $expectedWhitelistEntry->expects($this->at(7))
            ->method('setEditable')
            ->with(true);
        $expectedWhitelistEntry->expects($this->at(8))
            ->method('getLabel')
            ->will($this->returnValue($label));
        $expectedWhitelistEntry->expects($this->at(9))
            ->method('getLabel')
            ->will($this->returnValue($label));
        $expectedWhitelistEntry->expects($this->at(10))
            ->method('getUrlRule')
            ->will($this->returnValue($urlRule));
        $expectedWhitelistEntry->expects($this->at(11))
            ->method('getUrlRule')
            ->will($this->returnValue($urlRule));
        $expectedWhitelistEntry->expects($this->at(12))
            ->method('getStrategy')
            ->will($this->returnValue($strategy));
        $expectedWhitelistEntry->expects($this->at(13))
            ->method('getStrategy')
            ->will($this->returnValue($strategy));
        $expectedWhitelistEntry->expects($this->at(14))
            ->method('getEditable')
            ->will($this->returnValue(true));
        $expectedWhitelistEntry->expects($this->at(15))
            ->method('save');

        $whitelistEntryFactory = $this->getWhitelistEntryFactory();
        $whitelistEntryFactory->expects($this->at(0))
            ->method('create')
            ->will($this->returnValue($expectedWhitelistEntry));
        $whitelistEntryFactory->expects($this->at(1))
            ->method('create')
            ->will($this->returnValue($expectedWhitelistEntry));

        $whitelistRepository = new WhitelistRepository(
            $whitelistEntryFactory,
            $this->getWhitelistEntryCollectionFactory(),
            $this->getStoreManager(),
            $this->getWhitelistEntrySearchResultInterfaceFactory()
        );

        $resultWhitelistEntity = $whitelistRepository->createEntry($entityId, $label, $urlRule, $strategy, $storeId);

        $this->assertEquals($expectedWhitelistEntry, $resultWhitelistEntity);
    }

    /**
     * Run test of creating a new entry with existing entity
     * @test
     * @depends testConstructor
     */
    public function testEntryCreationWithExistingEntity()
    {
        $entityId = 42;
        $label = 'foobar';
        $urlRule = '/foobar';
        $storeId = 0;
        $strategy = 'default';

        $expectedWhitelistEntry = $this->createMock('\BitExpert\ForceCustomerLogin\Model\WhitelistEntry');
        $expectedWhitelistEntry->expects($this->at(0))
            ->method('load')
            ->with($entityId)
            ->willReturnSelf();
        $expectedWhitelistEntry->expects($this->at(1))
            ->method('getId')
            ->will($this->returnValue($entityId));
        $expectedWhitelistEntry->expects($this->at(2))
            ->method('getId')
            ->will($this->returnValue($entityId));
        $expectedWhitelistEntry->expects($this->at(3))
            ->method('getEditable')
            ->willReturn(true);
        $expectedWhitelistEntry->expects($this->at(4))
            ->method('setLabel')
            ->with($label);
        $expectedWhitelistEntry->expects($this->at(5))
            ->method('setUrlRule')
            ->with($urlRule);
        $expectedWhitelistEntry->expects($this->at(6))
            ->method('setStrategy')
            ->with($strategy);
        $expectedWhitelistEntry->expects($this->at(7))
            ->method('setStoreId')
            ->with($storeId);
        $expectedWhitelistEntry->expects($this->at(8))
            ->method('setEditable')
            ->with(true);
        // validation
        $expectedWhitelistEntry->expects($this->at(9))
            ->method('getLabel')
            ->will($this->returnValue($label));
        $expectedWhitelistEntry->expects($this->at(10))
            ->method('getLabel')
            ->will($this->returnValue($label));
        $expectedWhitelistEntry->expects($this->at(11))
            ->method('getUrlRule')
            ->will($this->returnValue($urlRule));
        $expectedWhitelistEntry->expects($this->at(12))
            ->method('getUrlRule')
            ->will($this->returnValue($urlRule));
        $expectedWhitelistEntry->expects($this->at(13))
            ->method('getStrategy')
            ->will($this->returnValue($strategy));
        $expectedWhitelistEntry->expects($this->at(14))
            ->method('getStrategy')
            ->will($this->returnValue($strategy));
        $expectedWhitelistEntry->expects($this->at(15))
            ->method('getEditable')
            ->will($this->returnValue(true));
        $expectedWhitelistEntry->expects($this->at(16))
            ->method('save');

        $whitelistEntryFactory = $this->getWhitelistEntryFactory();
        $whitelistEntryFactory->expects($this->at(0))
            ->method('create')
            ->will($this->returnValue($expectedWhitelistEntry));

        $whitelistRepository = new WhitelistRepository(
            $whitelistEntryFactory,
            $this->getWhitelistEntryCollectionFactory(),
            $this->getStoreManager(),
            $this->getWhitelistEntrySearchResultInterfaceFactory()
        );

        $resultWhitelistEntity = $whitelistRepository->createEntry($entityId, $label, $urlRule, $strategy, $storeId);

        $this->assertEquals($expectedWhitelistEntry, $resultWhitelistEntity);
    }

    /**
     * Run test of creating a new entry with existing entity being not editable
     * @test
     * @depends testConstructor
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Whitelist entry not editable.
     */
    public function testEntryCreationWithExistingEntityFailsDueToNonEditable()
    {
        $entityId = 42;
        $label = 'foobar';
        $urlRule = '/foobar';
        $storeId = 0;
        $strategy = 'default';

        $expectedWhitelistEntry = $this->createMock('\BitExpert\ForceCustomerLogin\Model\WhitelistEntry');
        $expectedWhitelistEntry->expects($this->at(0))
            ->method('load')
            ->with($entityId)
            ->willReturnSelf();
        $expectedWhitelistEntry->expects($this->at(1))
            ->method('getId')
            ->will($this->returnValue($entityId));
        $expectedWhitelistEntry->expects($this->at(2))
            ->method('getId')
            ->will($this->returnValue($entityId));
        $expectedWhitelistEntry->expects($this->at(3))
            ->method('getEditable')
            ->willReturn(false);

        $whitelistEntryFactory = $this->getWhitelistEntryFactory();
        $whitelistEntryFactory->expects($this->at(0))
            ->method('create')
            ->will($this->returnValue($expectedWhitelistEntry));

        $whitelistRepository = new WhitelistRepository(
            $whitelistEntryFactory,
            $this->getWhitelistEntryCollectionFactory(),
            $this->getStoreManager(),
            $this->getWhitelistEntrySearchResultInterfaceFactory()
        );

        $whitelistRepository->createEntry($entityId, $label, $urlRule, $strategy, $storeId);
    }

    /**
     * @test
     * @depends testConstructor
     */
    public function deleteEntityFailsDueToNonEditable()
    {
        $entityId = 42;

        $expectedWhitelistEntry = $this->createMock('\BitExpert\ForceCustomerLogin\Model\WhitelistEntry');
        $expectedWhitelistEntry->expects($this->once())
            ->method('load')
            ->willReturnSelf();
        $expectedWhitelistEntry->expects($this->once())
            ->method('getId')
            ->willReturn($entityId);
        $expectedWhitelistEntry->expects($this->once())
            ->method('getEditable')
            ->willReturn(false);

        $whitelistEntryFactory = $this->getWhitelistEntryFactory();
        $whitelistEntryFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($expectedWhitelistEntry));

        $whitelistRepository = new WhitelistRepository(
            $whitelistEntryFactory,
            $this->getWhitelistEntryCollectionFactory(),
            $this->getStoreManager(),
            $this->getWhitelistEntrySearchResultInterfaceFactory()
        );

        $this->assertFalse($whitelistRepository->deleteEntry($entityId));
    }

    /**
     * @test
     * @depends testConstructor
     */
    public function deleteEntitySucceeds()
    {
        $entityId = 42;

        $expectedWhitelistEntry = $this->createMock('\BitExpert\ForceCustomerLogin\Model\WhitelistEntry');
        $expectedWhitelistEntry->expects($this->once())
            ->method('load')
            ->willReturnSelf();
        $expectedWhitelistEntry->expects($this->once())
            ->method('getId')
            ->willReturn($entityId);
        $expectedWhitelistEntry->expects($this->once())
            ->method('getEditable')
            ->willReturn(true);
        $expectedWhitelistEntry->expects($this->once())
            ->method('delete');

        $whitelistEntryFactory = $this->getWhitelistEntryFactory();
        $whitelistEntryFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($expectedWhitelistEntry));

        $whitelistRepository = new WhitelistRepository(
            $whitelistEntryFactory,
            $this->getWhitelistEntryCollectionFactory(),
            $this->getStoreManager(),
            $this->getWhitelistEntrySearchResultInterfaceFactory()
        );

        $this->assertTrue($whitelistRepository->deleteEntry($entityId));
    }

    /**
     * @test
     * @depends testConstructor
     */
    public function getCollectionSuccessfully()
    {
        $storeId = 222;
        $store = $this->createMock('\Magento\Store\Api\Data\StoreInterface');
        $store->expects($this->once())
            ->method('getId')
            ->willReturn($storeId);

        $storeManager = $this->getStoreManager();
        $storeManager->expects($this->once())
            ->method('getStore')
            ->willReturn($store);

        $expectedCollection = $this->getMockBuilder('\BitExpert\ForceCustomerLogin\Model\ResourceModel\WhitelistEntry\Collection')
            ->disableOriginalConstructor()
            ->getMock();
        $expectedCollection->expects($this->once())
            ->method('addFieldToFilter')
            ->with('store_id',
                [
                    'in' => [
                        WhitelistRepositoryInterface::ROOT_STORE_ID,
                        $storeId
                    ]
                ]
            );
        $expectedCollection->expects($this->once())
            ->method('load')
            ->willReturnSelf();

        $collectionFactory = $this->getWhitelistEntryCollectionFactory();
        $collectionFactory->expects($this->once())
            ->method('create')
            ->willReturn($expectedCollection);

        $whitelistRepository = new WhitelistRepository(
            $this->getWhitelistEntryFactory(),
            $collectionFactory,
            $storeManager,
            $this->getWhitelistEntrySearchResultInterfaceFactory()
        );

        $this->assertEquals($expectedCollection, $whitelistRepository->getCollection());
    }

    /**
     * @test
     * @depends testConstructor
     */
    public function getListSuccessfully()
    {
        $filter = $this->getMockBuilder('\Magento\Framework\Api\Filter')
            ->disableOriginalConstructor()
            ->getMock();
        $filter->expects($this->exactly(2))
            ->method('getConditionType')
            ->willReturn('foo');
        $filter->expects($this->once())
            ->method('getField')
            ->willReturn('bar');
        $filter->expects($this->once())
            ->method('getValue')
            ->willReturn('baz');

        $filterGroup = $this->getMockBuilder('\Magento\Framework\Api\Search\FilterGroup')
            ->disableOriginalConstructor()
            ->getMock();
        $filterGroup->expects($this->once())
            ->method('getFilters')
            ->willReturn([$filter]);

        $searchCriteria = $this->getMockBuilder('\Magento\Framework\Api\SearchCriteria')
            ->disableOriginalConstructor()
            ->getMock();
        $searchCriteria->expects($this->once())
            ->method('getFilterGroups')
            ->willReturn([$filterGroup]);
        $searchCriteria->expects($this->once())
            ->method('getCurrentPage')
            ->willReturn(3);
        $searchCriteria->expects($this->once())
            ->method('getPageSize')
            ->willReturn(42);

        $expectedSearchResult = $this->getMockBuilder(
            '\BitExpert\ForceCustomerLogin\Api\Data\Collection\WhitelistEntrySearchResultInterface'
            )
            ->setMethods([
                'getItems',
                'setItems',
                'getSearchCriteria',
                'setSearchCriteria',
                'getTotalCount',
                'setTotalCount',
                'addFieldToFilter',
                'setCurPage',
                'setPageSize'
            ])
            ->getMock();
        $expectedSearchResult->expects($this->once())
            ->method('addFieldToFilter')
            ->with('bar', ['foo' => 'baz']);
        $expectedSearchResult->expects($this->once())
            ->method('setCurPage')
            ->with(3);
        $expectedSearchResult->expects($this->once())
            ->method('setPageSize')
            ->with(42);

        $searchResultFactory = $this->getWhitelistEntrySearchResultInterfaceFactory();
        $searchResultFactory->expects($this->once())
            ->method('create')
            ->willReturn($expectedSearchResult);

        $whitelistRepository = new WhitelistRepository(
            $this->getWhitelistEntryFactory(),
            $this->getWhitelistEntryCollectionFactory(),
            $this->getStoreManager(),
            $searchResultFactory
        );

        $this->assertEquals($expectedSearchResult, $whitelistRepository->getList($searchCriteria));
    }

    /**
     * @return \BitExpert\ForceCustomerLogin\Api\Data\WhitelistEntryFactoryInterface
     */
    protected function getWhitelistEntryFactory()
    {
        return $this->createMock('\BitExpert\ForceCustomerLogin\Api\Data\WhitelistEntryFactoryInterface');
    }

    /**
     * @return \BitExpert\ForceCustomerLogin\Api\Data\Collection\WhitelistEntryCollectionFactoryInterface
     */
    protected function getWhitelistEntryCollectionFactory()
    {
        return $this->createMock(
            '\BitExpert\ForceCustomerLogin\Api\Data\Collection\WhitelistEntryCollectionFactoryInterface'
        );
    }

    /**
     * @return \BitExpert\ForceCustomerLogin\Model\WhitelistEntrySearchResultInterfaceFactory
     */
    protected function getWhitelistEntrySearchResultInterfaceFactory()
    {
        return $this->getMockBuilder('\BitExpert\ForceCustomerLogin\Model\WhitelistEntrySearchResultInterfaceFactory')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \Magento\Store\Model\StoreManager
     */
    protected function getStoreManager()
    {
        return $this->getMockBuilder('\Magento\Store\Model\StoreManager')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
