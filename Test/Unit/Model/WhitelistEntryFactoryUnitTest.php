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

use BitExpert\ForceCustomerLogin\Model\WhitelistEntryFactory;

/**
 * Class WhitelistEntryFactoryUnitTest
 *
 * @package BitExpert\ForceCustomerLogin\Test\Unit\Model
 */
class WhitelistEntryFactoryUnitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function createEntitySuccessfully()
    {
        $expectedEntity = $this->createMock('\BitExpert\ForceCustomerLogin\Model\WhitelistEntry');

        $om = $this->getObjectManager();
        $om->expects($this->once())
            ->method('create')
            ->with('\\BitExpert\\ForceCustomerLogin\\Model\\WhitelistEntry', ['foo' => 'bar'])
            ->willReturn($expectedEntity);

        $factory = new WhitelistEntryFactory($om);

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
