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

use \bitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface;
use \Magento\Framework\Controller\Result\RedirectFactory;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\Message\ManagerInterface;

/**
 * Class Save
 * @package bitExpert\ForceCustomerLogin\Controller\Adminhtml\Whitelist
 */
class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * @var WhitelistRepositoryInterface
     */
    protected $whitelistRepository;
    /**
     * @var RedirectFactory
     */
    protected $redirectFactory;
    /**
     * @var Context
     */
    protected $context;
    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * Save constructor.
     * @param WhitelistRepositoryInterface $whitelistRepository
     * @param Context $context
     */
    public function __construct(
        WhitelistRepositoryInterface $whitelistRepository,
        Context $context
    ) {
        $this->whitelistRepository = $whitelistRepository;
        $this->redirectFactory = $context->getResultRedirectFactory();
        $this->messageManager = $context->getMessageManager();
        $this->context = $context;
        parent::__construct($context);
    }

    /**
     * Save action.
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $result = $this->redirectFactory->create();

        try {
            $whitelistEntry = $this->whitelistRepository->createEntry(
                $this->getRequest()->getParam('label'),
                $this->getRequest()->getParam('url_rule'),
                $this->getRequest()->getParam('store_id', 0)
            );

            if (!$whitelistEntry->getId()) {
                throw new \RuntimeException(
                    'Could not persist whitelist entry.'
                );
            }
            $this->messageManager->addSuccess(
                __('Whitelist entry successfully saved.')
            );

            $result->setHttpResponseCode(200);
            $result->setPath('ForceCustomerLogin/Whitelist/index');
        } catch (\Exception $e) {
            $result->setHttpResponseCode(\Magento\Framework\Webapi\Exception::HTTP_INTERNAL_ERROR);
            $this->messageManager->addError(
                __('Could not add record: %s', $e->getMessage())
            );
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('bitExpert_ForceCustomerLogin::bitexpert_force_customer_login_manage');
    }
}
