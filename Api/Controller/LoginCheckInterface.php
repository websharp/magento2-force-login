<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Api\Controller;

use \Magento\Framework\App\ActionInterface;

/**
 * Interface LoginCheckInterface
 * @package bitExpert\ForceCustomerLogin\Api\Controller
 */
interface LoginCheckInterface extends ActionInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute();
}
