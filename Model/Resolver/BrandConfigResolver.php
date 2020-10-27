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
 * @package     Mageplaza_ShopbybrandGraphQL
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */
declare(strict_types=1);

namespace Mageplaza\ShopbybrandGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mageplaza\Shopbybrand\Helper\Data;
use Mageplaza\ShopbybrandGraphQl\Model\Resolver\Brands\BrandConfigDataProvider;

/**
 * Class BrandConfigResolver
 * @package Mageplaza\ShopbybrandGraphQl\Model\Resolver
 */
class BrandConfigResolver implements ResolverInterface
{
    /**
     * @var BrandConfigDataProvider
     */
    protected $brandConfigDataProvider;
    /**
     * @var Data
     */
    protected $helperData;

    /**
     * BrandConfigResolver constructor.
     *
     * @param Data $helperData
     * @param BrandConfigDataProvider $brandConfigDataProvider
     */
    public function __construct(
        Data $helperData,
        BrandConfigDataProvider $brandConfigDataProvider
    ) {
        $this->helperData = $helperData;
        $this->brandConfigDataProvider = $brandConfigDataProvider;
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
        $storeId = null;
        if (isset($args['storeId'])) {
            $storeId = $args['storeId'];
        }

        return $this->brandConfigDataProvider->getBrandConfigData($storeId);
    }
}
