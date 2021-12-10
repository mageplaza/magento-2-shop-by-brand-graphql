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

namespace Mageplaza\ShopbybrandGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\Argument\SearchCriteria\Builder as SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mageplaza\Shopbybrand\Helper\Data;
use Mageplaza\Shopbybrand\Model\BrandRepository;
use Mageplaza\ShopbybrandGraphQl\Model\Resolver\Brands\DataProvider;

/**
 * Class Brands
 * @package Mageplaza\ShopbybrandGraphQl\Model\Resolver
 */
class Brands implements ResolverInterface
{
    /**
     * @var Data
     */
    protected $helperData;
    /**
     * @var DataProvider
     */
    protected $dataProvider;
    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;
    /**
     * @var BrandRepository
     */
    protected $brandRepository;

    /**
     * Brands constructor.
     *
     * @param Data $helperData
     * @param DataProvider $dataProvider
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        Data $helperData,
        BrandRepository $brandRepository,
        DataProvider $dataProvider,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->helperData            = $helperData;
        $this->dataProvider          = $dataProvider;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->brandRepository = $brandRepository;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!$this->helperData->isEnabled()) {
            throw new GraphQlInputException(__('The module is disabled'));
        }

        if ($args['currentPage'] < 1) {
            throw new GraphQlInputException(__('currentPage value must be greater than 0.'));
        }
        if ($args['pageSize'] < 1) {
            throw new GraphQlInputException(__('pageSize value must be greater than 0.'));
        }

        $storeId = null;
        if (isset($args['storeId'])) {
            $storeId = $args['storeId'];
        }

        $filter = [];
        if (isset($args['filter']) && !empty($args['filter'])) {
            foreach ($args['filter'] as $key => $item) {
                if ($key === 'value' || $key === 'default_value') {
                    $filter['tdv' . $key] = $item;
                } elseif ($key === 'option_id') {
                    $filter['main_table.option_id'] = $item;
                } else {
                    $filter[$key] = $item;
                }
            }
        }
        $args['filter'] = $filter;
        $searchCriteria = $this->searchCriteriaBuilder->build($field->getName(), $args);
        $searchCriteria->setCurrentPage($args['currentPage']);
        $searchCriteria->setPageSize($args['pageSize']);
        $collection = $this->dataProvider->getData($searchCriteria, $storeId);
        $brands     = [];
        foreach ($collection as $brand) {
            $brand->setProductQuantity(count($this->brandRepository->getProductList($brand->getOptionId())));
            $brandData          = $brand->getData();
            $brandData['model'] = $brand;
            $brands[]           = $brandData;
        }

        $collectionSize = $collection->getSize();
        //possible division by 0
        $pageSize = $collection->getPageSize();
        if ($pageSize) {
            $maxPages = ceil($collectionSize / $searchCriteria->getPageSize());
        } else {
            $maxPages = 0;
        }

        $currentPage = $collection->getCurPage();
        if ($collectionSize > 0 && $searchCriteria->getCurrentPage() > $maxPages) {
            throw new GraphQlInputException(
                __(
                    'currentPage value %1 specified is greater than the %2 page(s) available.',
                    [$currentPage, $maxPages]
                )
            );
        }

        return [
            'total_count' => $collection->getSize(),
            'items'       => $brands,
            'page_info'   => [
                'page_size'    => $pageSize,
                'current_page' => $currentPage,
                'total_pages'  => $maxPages
            ]
        ];
    }
}
