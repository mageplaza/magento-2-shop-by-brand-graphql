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
use Mageplaza\Shopbybrand\Api\BrandRepositoryInterface;
use Mageplaza\Shopbybrand\Helper\Data;

/**
 * Class BrandConfigResolver
 * @package Mageplaza\ShopbybrandGraphQl\Model\Resolver
 */
class BrandConfigResolver implements ResolverInterface
{
    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @var BrandRepositoryInterface
     */
    protected $brandRepository;

    /**
     * BrandConfigResolver constructor.
     *
     * @param Data $helperData
     * @param BrandRepositoryInterface $brandRepository
     */
    public function __construct(
        Data $helperData,
        BrandRepositoryInterface $brandRepository
    ) {
        $this->helperData      = $helperData;
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
        $storeId = null;
        if (isset($args['storeId'])) {
            $storeId = $args['storeId'];
        }

        $config = $this->brandRepository->getBrandConfigs($storeId);

        return [
            'general'              => $config->getGeneral(),
            'brands_page_settings' => $config->getBrandsPageSettings(),
            'brand_info'           => $config->getBrandInfo(),
            'sidebar'              => $config->getSidebar(),
            'seo'                  => $config->getSeo()
        ];
    }
}
