<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Block\Adminhtml\Whitelist\Create;

/**
 * Class Form
 * @package bitExpert\ForceCustomerLogin\Block\Adminhtml\Whitelist\Create
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create([
            'data' => [
                'id' => 'create_whitelist_entry_form',
                'action' => $this->getUrl('ForceCustomerLogin/Whitelist/Save'),
                'method' => 'post'
            ]
        ]);
        $form->setHtmlIdPrefix('');

        $fieldsetBase = $form->addFieldset(
            'base_fieldset',
            [
                'class' => 'fieldset-wide'
            ]
        );

        $fieldsetBase->addField('label', 'text', [
            'name' => 'label',
            'label' => __('Label'),
            'title' => __('Label'),
            'value' => \base64_decode($this->_request->getParam('label')),
            'required' => true

        ]);

        $fieldsetBase->addField('url_rule', 'text', [
            'name' => 'url_rule',
            'label' => __('Url Rule'),
            'title' => __('Url Rule'),
            'value' => \base64_decode($this->_request->getParam('url_rule')),
            'required' => true
        ]);

        $fieldsetBase->addField('store_id', 'select', [
            'name' => 'store_id',
            'label' => __('Store'),
            'title' => __('Store'),
            'value' => \base64_decode($this->_request->getParam('store_id')),
            'options' =>  $this->getStoresAsArray(),
            'required' => true
        ]);
        $form->setData('store_id', \base64_decode($this->_request->getParam('store_id')));



        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return array
     */
    protected function getStoresAsArray()
    {
        $stores = $this->_storeManager->getStores();

        $storeSet = array(
            0 => __('All Stores')
        );
        foreach ($stores as $store) {
            $storeSet[(int) $store->getId()] = $store->getName();
        }

        return $storeSet;
    }
}