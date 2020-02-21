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

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mageplaza\Shopbybrand\Model\Brand;
use Mageplaza\Shopbybrand\Model\CategoryFactory;
use Mageplaza\Shopbybrand\Model\ResourceModel\Category\Collection;

/**
 * Class Categories
 * @package Mageplaza\ShopbybrandGraphQl\Model\Resolver
 */
class Categories implements ResolverInterface
{
    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * Categories constructor.
     *
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(
        CategoryFactory $categoryFactory
    ) {
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
        $categories = [];
        /** @var Brand $brand */
        $brand = $value['model'];
        if (!$brand->getOptionId()) {
            return $categories;
        }
        $sql   = 'brand_cat_tbl.option_id IN (' . $brand->getOptionId() . ')';
        $group = 'main_table.cat_id';

        /** @var Collection $collection */
        $collection = $this->categoryFactory->create()->getCategoryCollection($sql, $group);
        foreach ($collection as $category) {
            $categories[$category->getId()]          = $category->getData();
            $categories[$category->getId()]['model'] = $category;
        }

        return $categories;
    }
}
