<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Repository;

use \bitExpert\ForceCustomerLogin\Api\Data\Collection\WhitelistEntryCollectionFactoryInterface;
use \bitExpert\ForceCustomerLogin\Model\WhitelistEntrySearchResultInterfaceFactory as SearchResultFactory;

/**
 * Class WhitelistRepository
 * @package bitExpert\ForceCustomerLogin\Model
 */
class WhitelistRepository implements \bitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface
{
    /**
     * @var WhitelistEntryCollectionFactoryInterface
     */
    protected $collectionFactory;
    /**
     * @var SearchResultFactory
     */
    protected $searchResultFactory;

    /**
     * WhitelistRepository constructor.
     * @param WhitelistEntryCollectionFactoryInterface $collectionFactory
     * @param SearchResultFactory $searchResultFactory
     */
    public function __construct(
        WhitelistEntryCollectionFactoryInterface $collectionFactory,
        SearchResultFactory $searchResultFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function getCollection()
    {
        return $this->collectionFactory->create()->load();
    }

    /**
     * {@inheritDoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteria $searchCriteria)
    {
        /** @var \bitExpert\ForceCustomerLogin\Api\Data\Collection\WhitelistEntrySearchResultInterface $searchResult */
        $searchResult = $this->searchResultFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $searchResult->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResult->setCurPage($searchCriteria->getCurrentPage());
        $searchResult->setPageSize($searchCriteria->getPageSize());

        return $searchResult;
    }
}
