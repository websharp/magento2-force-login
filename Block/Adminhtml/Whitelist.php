<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Block\Adminhtml;

/**
 * Class Whitelist
 * @package bitExpert\ForceCustomerLogin\Block\Adminhtml
 */
class Whitelist extends \Magento\Backend\Block\Widget\Container
{
    /**
     * @var \Banc\AssetProduct\Api\Helper\Type\AssetTypeHelperInterface
     */
    protected $assetTypeHelper;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Banc\AssetProduct\Api\Helper\Type\AssetTypeHelperInterface $assetTypeHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Banc\AssetProduct\Api\Helper\Type\AssetTypeHelperInterface $assetTypeHelper,
        array $data = []
    ) {
        $this->assetTypeHelper = $assetTypeHelper;

        parent::__construct($context, $data);
    }

    /**
     * Prepare button and grid
     *
     * @return \Banc\AssetBuilder\Block\Adminhtml\Asset
     */
    protected function _prepareLayout()
    {
        $addButtonProps = [
            'id' => 'add_new_asset',
            'label' => __('Add Asset'),
            'class' => 'add',
            'button_class' => '',
            'class_name' => 'Magento\Backend\Block\Widget\Button\SplitButton',
            'options' => $this->_getAddAssetButtonOptions(),
        ];
        $this->buttonList->add('add_new', $addButtonProps);

        return parent::_prepareLayout();
    }

    /**
     * Retrieve options for 'Add Asset' split button
     *
     * @return array
     */
    protected function _getAddAssetButtonOptions()
    {
        $splitButtonOptions = [];
        $types = $this->assetTypeHelper->getTypes();
        uasort(
            $types,
            function ($elementOne, $elementTwo) {
                return ($elementOne['sort_order'] < $elementTwo['sort_order']) ? -1 : 1;
            }
        );

        foreach ($types as $typeId => $type) {
            $splitButtonOptions[$typeId] = [
                'label' => __($type['label']),
                'onclick' => "setLocation('" . $this->_getAssetCreateUrl($typeId) . "')",
                'default' => \Banc\AssetProduct\Helper\Type\AssetTypeHelper::DEFAULT_TYPE === $typeId,
            ];
        }

        return $splitButtonOptions;
    }

    /**
     * Retrieve product create url by specified product type
     *
     * @param string $type
     * @return string
     */
    protected function _getAssetCreateUrl($type)
    {
        return $this->getUrl(
            'AssetBuilder/asset/create',
            ['type' => $type]
        );
    }
}
