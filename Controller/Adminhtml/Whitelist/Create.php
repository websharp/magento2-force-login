<?php

/*
 * This file is part of the Force Login Module package for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Controller\Adminhtml\Whitelist;

/**
 * Class Create
 * @package bitExpert\ForceCustomerLogin\Controller\Adminhtml\Whitelist
 * @codingStandardsIgnoreFile
 */
class Create extends \Magento\Framework\App\Action\Action
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('bitExpert_ForceCustomerLogin::bitexpert_force_customer_login_manage');
    }
}
