<?php

/*
 * This file is part of the Force Login Module package for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Api\Observer;

use \Magento\Framework\Event\ObserverInterface;

/**
 * Interface LoginRequiredObserverInterface
 * @package bitExpert\ForceCustomerLogin\Api\Observer
 */
interface LoginRequiredObserverInterface extends ObserverInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute(\Magento\Framework\Event\Observer $observer);
}
