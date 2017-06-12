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
 * Class RegExAllMatcher
 * @package bitExpert\ForceCustomerLogin\Helper\Strategy
 */
class RegExAllMatcher implements StrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function isMatch($url, WhitelistEntry $rule)
    {
        return (\preg_match(\sprintf('#^.*%s/?.*$#i', $this->quoteRule($rule->getUrlRule())), $url) === 1);
    }

    /**
     * Quote delimiter in whitelist entry rule
     * @param string $rule
     * @param string $delimiter
     * @return string
     */
    private function quoteRule($rule, $delimiter = '#')
    {
        return \str_replace($delimiter, \sprintf('\%s', $delimiter), $rule);
    }
}
