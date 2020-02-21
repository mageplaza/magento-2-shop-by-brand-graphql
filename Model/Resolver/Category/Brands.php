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

namespace Mageplaza\ShopbybrandGraphQl\Model\Resolver\Category;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mageplaza\Shopbybrand\Helper\Data;
use Mageplaza\Shopbybrand\Model\Category;
use Mageplaza\Shopbybrand\Model\CategoryFactory;

/**
 * Class Brands
 * @package Mageplaza\ShopbybrandGraphQl\Model\Resolver\Category
 */
class Brands implements ResolverInterface
{

    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * Brands constructor.
     *
     * @param Data $helperData
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(
        Data $helperData,
        CategoryFactory $categoryFactory
    ) {
        $this->helperData      = $helperData;
        $this->categoryFactory = $categoryFactory;
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
        if (!isset($value['model'])) {
            throw new LocalizedException(__('"model" value should be specified'));
        }

        /** @var Category $category */
        $category   = $value['model'];
        $optionIds  = $this->getOptionIds($category->getId());
        $collection = $this->helperData->getBrandList(Data::CATEGORY, $optionIds);
        $brands     = [];
        foreach ($collection as $brand) {
            $brands[$brand->getId()]          = $brand->getData();
            $brands[$brand->getId()]['model'] = $brand;
        }

        return $brands;
    }

    /**
     * @param $categoryId
     *
     * @return array
     */
    public function getOptionIds($categoryId)
    {
        $result = [];
        $sql    = 'main_table.cat_id IN (' . $categoryId . ')';
        $brands = $this->categoryFactory->create()->getCategoryCollection($sql, null)->getData();
        foreach ($brands as $brand => $item) {
            $result[] = $item['option_id'];
        }

        return $result;
    }
}
