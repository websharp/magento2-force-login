<?php

/*
 * This file is part of the Force Login Module package for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Test\Unit\Repository;

/**
 * Class WhitelistRepositoryUnitTest
 * @package bitExpert\ForceCustomerLogin\Test\Unit\Repository
 */
class WhitelistRepositoryUnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists('\bitExpert\ForceCustomerLogin\Repository\WhitelistRepository'));
    }

    /**
     * @test
     * @depends testClassExists
     */
    public function testConstructor()
    {
        $whitelistRepository = new \bitExpert\ForceCustomerLogin\Repository\WhitelistRepository(
            $this->getWhitelistEntryFactory(),
            $this->getWhitelistValidatorFactory(),
            $this->getWhitelistEntryCollectionFactory(),
            $this->getStoreManager(),
            $this->getWhitelistEntrySearchResultInterfaceFactory()
        );

        // check if mandatory interfaces are implemented
        $classInterfaces = class_implements($whitelistRepository);
        $this->assertContains(
            'bitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface',
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

        // Entity
        $expectedWhitelistEntry = $this->createMock('\bitExpert\ForceCustomerLogin\Model\WhitelistEntry');
        $expectedWhitelistEntry->expects($this->at(0))
            ->method('getId')
            ->will($this->returnValue($entityId));
        $expectedWhitelistEntry->expects($this->at(1))
            ->method('load')
            ->with(
                $label,
                'label'
            )
            ->will($this->returnSelf());
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
            ->method('setStoreId')
            ->with($storeId);
        $expectedWhitelistEntry->expects($this->at(6))
            ->method('setEditable')
            ->with(true);
        $expectedWhitelistEntry->expects($this->at(7))
            ->method('save');

        $whitelistEntryFactory = $this->getWhitelistEntryFactory();
        $whitelistEntryFactory->expects($this->at(0))
            ->method('create')
            ->will($this->returnValue($expectedWhitelistEntry));
        $whitelistEntryFactory->expects($this->at(1))
            ->method('create')
            ->will($this->returnValue($expectedWhitelistEntry));

        // Validator
        $expectedWhitelistValidator = $this->createMock('\bitExpert\ForceCustomerLogin\Validator\WhitelistEntry');
        $expectedWhitelistValidator->expects($this->once())
            ->method('validate')
            ->with($expectedWhitelistEntry)
            ->willReturn(true);

        $whitelistValidatoryFactory = $this->getWhitelistValidatorFactory();
        $whitelistValidatoryFactory->expects($this->at(0))
            ->method('create')
            ->will($this->returnValue($expectedWhitelistValidator));

        $whitelistRepository = new \bitExpert\ForceCustomerLogin\Repository\WhitelistRepository(
            $whitelistEntryFactory,
            $whitelistValidatoryFactory,
            $this->getWhitelistEntryCollectionFactory(),
            $this->getStoreManager(),
            $this->getWhitelistEntrySearchResultInterfaceFactory()
        );

        $resultWhitelistEntity = $whitelistRepository->createEntry(
            $entityId,
            $label,
            $urlRule,
            $storeId
        );

        $this->assertEquals(
            $expectedWhitelistEntry,
            $resultWhitelistEntity
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|
     *      \bitExpert\ForceCustomerLogin\Api\Data\WhitelistEntryFactoryInterface
     */
    protected function getWhitelistEntryFactory()
    {
        return $this->createMock('\bitExpert\ForceCustomerLogin\Api\Data\WhitelistEntryFactoryInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|
     *      \bitExpert\ForceCustomerLogin\Api\Validator\WhitelistEntryFactoryInterface
     */
    protected function getWhitelistValidatorFactory()
    {
        return $this->createMock('\bitExpert\ForceCustomerLogin\Api\Validator\WhitelistEntryFactoryInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|
     *      \bitExpert\ForceCustomerLogin\Api\Data\Collection\WhitelistEntryCollectionFactoryInterface
     */
    protected function getWhitelistEntryCollectionFactory()
    {
        return $this->createMock(
            '\bitExpert\ForceCustomerLogin\Api\Data\Collection\WhitelistEntryCollectionFactoryInterface'
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|
     *      \bitExpert\ForceCustomerLogin\Model\WhitelistEntrySearchResultInterfaceFactory
     */
    protected function getWhitelistEntrySearchResultInterfaceFactory()
    {
        return $this->getMockBuilder('\bitExpert\ForceCustomerLogin\Model\WhitelistEntrySearchResultInterfaceFactory')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Store\Model\StoreManager
     */
    protected function getStoreManager()
    {
        return $this->getMockBuilder('\Magento\Store\Model\StoreManager')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
