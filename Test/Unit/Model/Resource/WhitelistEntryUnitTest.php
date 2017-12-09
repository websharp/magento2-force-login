<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BitExpert\ForceCustomerLogin\Test\Unit\Model\Resource;

use BitExpert\ForceCustomerLogin\Model\ResourceModel\WhitelistEntry;

/**
 * Class WhitelistEntryUnitTest
 * @package BitExpert\ForceCustomerLogin\Test\Unit\Model\Resource
 */
class WhitelistEntryUnitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function createEntitySuccessfully()
    {
        $resource = new WhitelistEntry($this->getDatabaseContext());
        $this->assertEquals('whitelist_entry_id', $resource->getIdFieldName());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Model\ResourceModel\Db\Context
     */
    protected function getDatabaseContext()
    {
        return $this->createMock('\Magento\Framework\Model\ResourceModel\Db\Context');
    }
}
