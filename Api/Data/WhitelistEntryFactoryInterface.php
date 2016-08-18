<?php

/*
 * This file is part of the Force Login Module package for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Api\Data;

/**
 * Interface WhitelistEntryFactoryInterface
 * @package bitExpert\ForceCustomerLogin\Api\Data
 */
interface WhitelistEntryFactoryInterface
{
    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \bitExpert\ForceCustomerLogin\Model\WhitelistEntry
     */
    public function create(array $data = []);
}
