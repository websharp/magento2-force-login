<?php

/*
 * This file is part of the Force Login Module package for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Ui\Component\Listing\Column;

/**
 * Class EditAction
 * @package bitExpert\ForceCustomerLogin\Ui\Component\Listing\Column
 */
class EditAction extends DeleteAction
{
    /**
     * @return \Magento\Framework\Phrase|mixed|string
     */
    public function getLabel()
    {
        return __('Edit');
    }
}
