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

namespace Mageplaza\ShopbybrandGraphQl\Model\Resolver\Brands;

use Mageplaza\Shopbybrand\Api\BrandRepositoryInterface;

/**
 * Class BrandConfigDataProvider
 * @package Mageplaza\ShopbybrandGraphQl\Model\Resolver\Brands
 */
class BrandConfigDataProvider
{
    /**
     * @var BrandRepositoryInterface
     */
    protected $brandRepository;

    /**
     * BrandConfigDataProvider constructor.
     *
     * @param BrandRepositoryInterface $brandRepository
     */
    public function __construct(
        BrandRepositoryInterface $brandRepository
    ) {
        $this->brandRepository = $brandRepository;
    }

        /**
         * Get brand config data
         *
         * @param string|null $storeId
         * @return array
         */
    public function getBrandConfigData($storeId): array
    {
        $brandConfigs = $this->brandRepository->getBrandConfigs($storeId);
        $brandConfigData = [
            'brand_list_name'             => $brandConfigs->getBrandListName(),
            'brandlist_style'             => $brandConfigs->getBrandlistStyle(),
            'display_option'              => $brandConfigs->getDisplayOption(),
            'brand_list_logo_width'       => $brandConfigs->getBrandListLogoWidth(),
            'brand_list_logo_height'      => $brandConfigs->getBrandListLogoHeight(),
            'color'                       => $brandConfigs->getColor(),
            'show_description'            => $brandConfigs->getShowDescription(),
            'show_product_qty'            => $brandConfigs->getShowProductQty(),
            'custom_css'                  => $brandConfigs->getCustomCss(),
            'show_brand_info'             => $brandConfigs->getShowBrandInfo(),
            'logo_width_on_product_page'  => $brandConfigs->getLogoWidthOnProductPage(),
            'logo_height_on_product_page' => $brandConfigs->getLogoHeightOnProductPage()
        ];

        return $brandConfigData;
    }
}
