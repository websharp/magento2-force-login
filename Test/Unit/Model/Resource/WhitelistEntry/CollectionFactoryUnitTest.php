<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Test\Unit\Model\Resource\WhitelistEntry;

use bitExpert\ForceCustomerLogin\Model\ResourceModel\WhitelistEntry\CollectionFactory;

/**
 * Class CollectionFactoryUnitTest
 * @package bitExpert\ForceCustomerLogin\Test\Unit\Model\Resource\WhitelistEntry
 */
class CollectionFactoryUnitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function createEntitySuccessfully()
    {
        $expectedEntity = $this->createMock('\bitExpert\ForceCustomerLogin\Model\ResourceModel\WhitelistEntry\Collection');

        $om = $this->getObjectManager();
        $om->expects($this->once())
            ->method('create')
            ->with('\\bitExpert\\ForceCustomerLogin\\Model\\ResourceModel\\WhitelistEntry\\Collection', ['foo' => 'bar'])
            ->willReturn($expectedEntity);

        $factory = new CollectionFactory($om);

        $this->assertEquals($expectedEntity, $factory->create(['foo' => 'bar']));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\ObjectManagerInterface
     */
    protected function getObjectManager()
    {
        return $this->createMock('\Magento\Framework\ObjectManagerInterface');
    }
}
