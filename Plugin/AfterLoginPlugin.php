<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Plugin;

use \Magento\Customer\Controller\Account\LoginPost;
use \Magento\Framework\Controller\Result\Redirect;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\UrlInterface;
use \Magento\Customer\Model\Account\Redirect as AccountRedirect;
use \Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class AfterLoginPlugin
 * @package bitExpert\ForceCustomerLogin\Plugin
 */
class AfterLoginPlugin
{
    /**
     * @var AccountRedirect
     */
    protected $accountRedirect;
    /**
     * @var UrlInterface
     */
    protected $url;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * AfterLoginPlugin constructor.
     * @param Context $context
     * @param AccountRedirect $accountRedirect
     */
    public function __construct(
        Context $context,
        AccountRedirect $accountRedirect
    ) {
        $this->accountRedirect = $accountRedirect;
        $this->url = $context->getUrl();
    }

    /**
     * Customer login form page
     * @param LoginPost $customerAccountLoginController
     * @param Redirect $resultRedirect
     * @return Redirect
     */
    public function afterExecute(LoginPost $customerAccountLoginController, $resultRedirect)
    {
        $currentUrl = $this->url->getCurrentUrl();

        if ($this->getScopeConfig()->getValue('customer/startup/redirect_dashboard')) {
            return $resultRedirect;
        }

        /** @var $resultRedirect Redirect */
        $resultRedirect->setUrl($currentUrl);

        return $resultRedirect;
    }

    /**
     * Get scope config
     *
     * @return ScopeConfigInterface
     */
    private function getScopeConfig()
    {
        if (!($this->scopeConfig instanceof \Magento\Framework\App\Config\ScopeConfigInterface)) {
            return \Magento\Framework\App\ObjectManager::getInstance()->get(
                \Magento\Framework\App\Config\ScopeConfigInterface::class
            );
        } else {
            return $this->scopeConfig;
        }
    }
}
