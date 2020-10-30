<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_ShopbybrandGraphQl
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */
declare(strict_types=1);

namespace Mageplaza\ShopbybrandGraphQl\Model\Resolver\Brands;

use Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\Collection;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Mageplaza\Shopbybrand\Helper\Data;

/**
 * Class DataProvider
 * @package Mageplaza\ShopbybrandGraphQl\Model\Resolver\Brands
 */
class DataProvider
{
    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;
    /**
     * @var Data
     */
    protected $helperData;

    /**
     * DataProvider constructor.
     *
     * @param Data $helperData
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        Data $helperData,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->helperData          = $helperData;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param string|null $storeId
     *
     * @return Collection
     */
    public function getData(
        SearchCriteriaInterface $searchCriteria,
        $storeId
    ): Collection {
        $collection = $this->helperData->getBrandList(null, null, $storeId);
        $this->collectionProcessor->process($searchCriteria, $collection);

        return $collection;
    }
}
