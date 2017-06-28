<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Helper\Strategy;

use \bitExpert\ForceCustomerLogin\Model\WhitelistEntry;

/**
 * Class StaticMatcher
 * @package bitExpert\ForceCustomerLogin\Helper\Strategy
 */
class StaticMatcher implements StrategyInterface
{
    /**+
     * @var string
     */
    private $name;

    /**
     * RegExAllMatcher constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function isMatch($url, WhitelistEntry $rule)
    {
        return ($url === $rule->getUrlRule());
    }
}
