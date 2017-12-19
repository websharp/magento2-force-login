<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BitExpert\ForceCustomerLogin\Test\Unit\Model;

use BitExpert\ForceCustomerLogin\Model\WhitelistEntry;

/**
 * Class WhitelistEntryUnitTest
 *
 * @package BitExpert\ForceCustomerLogin\Test\Unit\Model
 */
class WhitelistEntryUnitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function testGettersAndSetters()
    {
        $resource = $this->getResourceModel();
        $resource->expects($this->atLeastOnce())
            ->method('getIdFieldName')
            ->willReturn('whitelist_entry_id');

        $entity = new WhitelistEntry(
            $this->getContext(),
            $this->getRegistry(),
            $resource,
            $this->getDatabase(),
            []
        );

        $entity->setStoreId(42);
        $this->assertEquals(42, $entity->getStoreId());
        $entity->setLabel('label');
        $this->assertEquals('label', $entity->getLabel());
        $entity->setUrlRule('url-rule');
        $this->assertEquals('url-rule', $entity->getUrlRule());
        $entity->setStrategy('strategy');
        $this->assertEquals('strategy', $entity->getStrategy());
        $entity->setEditable(false);
        $this->assertFalse($entity->getEditable());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Model\ResourceModel\AbstractResource
     */
    protected function getResourceModel()
    {
        return $this->getMockBuilder('\Magento\Framework\Model\ResourceModel\AbstractResource')
            ->disableOriginalConstructor()
            ->setMethods([
                '_construct',
                'getConnection',
                'getIdFieldName'
            ]
            )
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Model\Context
     */
    protected function getContext()
    {
        return $this->getMockBuilder('\Magento\Framework\Model\Context')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Registry
     */
    protected function getRegistry()
    {
        return $this->getMockBuilder('\Magento\Framework\Registry')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Data\Collection\AbstractDb
     */
    protected function getDatabase()
    {
        return $this->getMockBuilder('\Magento\Framework\Data\Collection\AbstractDb')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
