<?php

/*
 * This file is part of the Force Login Module package for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Block\Adminhtml\Whitelist\Create;

use \Magento\Backend\Block\Template\Context;

/**
 * Class Submit
 * @package bitExpert\ForceCustomerLogin\Block\Adminhtml\Whitelist\Create
 */
class Submit extends \Magento\Backend\Block\Template
{
    /**
     * Submit constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data
    ) {
        parent::__construct(
            $context,
            $data
        );
    }
}
