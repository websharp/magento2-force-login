<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Controller\Adminhtml\Whitelist;

use \Magento\Framework\App\Action\Context;

/**
 * Class Edit
 * @package bitExpert\ForceCustomerLogin\Controller\Adminhtml\Whitelist
 */
class Edit extends Create
{
    /**
     * Edit constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
}
