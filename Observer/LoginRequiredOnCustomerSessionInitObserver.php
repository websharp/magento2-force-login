<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Observer;

use \bitExpert\ForceCustomerLogin\Api\Controller\LoginCheckInterface;
use \bitExpert\ForceCustomerLogin\Api\Observer\LoginRequiredObserverInterface;
use \Magento\Framework\Event\Observer;

/**
 * Class LoginRequiredOnCustomerSessionInitObserver
 * @package bitExpert\ForceCustomerLogin\Observer
 */
class LoginRequiredOnCustomerSessionInitObserver implements LoginRequiredObserverInterface
{
    /**
     * @var LoginCheckInterface
     */
    protected $loginCheckController;

    /**
     * Creates a new {@link \bitExpert\ForceCustomerLogin\Observer\LoginRequiredOnCustomerSessionInitObserver}.
     *
     * @param LoginCheckInterface $loginCheckController
     */
    public function __construct(LoginCheckInterface $loginCheckController)
    {
        $this->loginCheckController = $loginCheckController;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(Observer $observer)
    {
        // check if a redirect is mandatory
        $this->loginCheckController->execute();
    }
}
