<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\CustomerForceLogin\Observer;

use bitExpert\CustomerForceLogin\Api\Observer\LoginRequiredObserverInterface;
use bitExpert\CustomerForceLogin\Observer\LoginRequiredOnCustomerSessionInitObserver;

/**
 * Class LoginRequiredOnVisitorInitObserver
 * @package bitExpert\CustomerForceLogin\Observer
 */
class LoginRequiredOnVisitorInitObserver extends LoginRequiredOnCustomerSessionInitObserver implements
    LoginRequiredObserverInterface
{
}
