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

namespace Mageplaza\ShopbybrandGraphQl\Model\Resolver\Product;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mageplaza\Shopbybrand\Helper\Data;
use Mageplaza\Shopbybrand\Model\BrandFactory;

/**
 * Class Brand
 * @package Mageplaza\ShopbybrandGraphQl\Model\Resolver\Product
 */
class Brand implements ResolverInterface
{
    /**
     * @type BrandFactory
     */
    protected $_brandFactory;
    /**
     * @var Data
     */
    protected $helperData;
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * Brand constructor.
     *
     * @param Data $helperData
     * @param BrandFactory $brandFactory
     * @param ProductRepository $productRepository
     */
    public function __construct(
        Data $helperData,
        BrandFactory $brandFactory,
        ProductRepository $productRepository
    ) {
        $this->helperData        = $helperData;
        $this->_brandFactory     = $brandFactory;
        $this->productRepository = $productRepository;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!$this->helperData->isEnabled()) {
            return [];
        }
        if (!isset($value['model'])) {
            throw new LocalizedException(__('"model" value should be specified'));
        }
        /** @var Product $product */
        $product            = $value['model'];
        $product            = $this->productRepository->getById($product->getId());
        $optionId           = $product->getData($this->helperData->getAttributeCode());
        $brand              = $this->_brandFactory->create()->loadByOption($optionId);
        $brandData          = $brand->getData();
        $brandData['model'] = $brand;

        return $brandData;
    }
}
