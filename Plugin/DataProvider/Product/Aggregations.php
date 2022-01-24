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

namespace Mageplaza\ShopbybrandGraphQl\Plugin\DataProvider\Product;

use Magento\CatalogGraphQl\DataProvider\Product\LayeredNavigation\Builder\Attribute;
use Mageplaza\Shopbybrand\Helper\Data;

/**
 * Class Aggregations
 * @package Mageplaza\ShopbybrandGraphQl\Plugin\DataProvider\Product
 */
class Aggregations
{
    /**
     * @var Data
     */
    protected $helperData;

    /**
     * Aggregations constructor.
     *
     * @param Data $helperData
     */
    public function __construct(
        Data $helperData
    ) {
        $this->helperData = $helperData;
    }

    /**
     * @param Attribute $subject
     * @param array $results
     *
     * @return mixed
     */
    public function afterBuild(Attribute $subject, $results)
    {
        if ($this->helperData->isEnabled() && $this->helperData->getAttributeCode() && $results) {
            foreach ($results as $bucketName => &$data) {
                if ($this->helperData->getAttributeCode() === $data['attribute_code']) {
                    $results[$bucketName]['is_mp_brand'] = true;
                }
            }
        }

        return $results;
    }
}
