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
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mageplaza\Shopbybrand\Helper\Data;
use Mageplaza\Shopbybrand\Model\BrandRepository;

/**
 * Class BrandCategory
 * @package Mageplaza\ShopbybrandGraphQl\Model\Resolver
 */
class BrandCategory implements ResolverInterface
{

    /**
     * @var Data
     */
    protected $helperData;
    /**
     * @var BrandRepository
     */
    protected $brandRepository;

    /**
     * BrandCategory constructor.
     *
     * @param Data $helperData
     * @param BrandRepository $brandRepository
     */
    public function __construct(
        Data $helperData,
        BrandRepository $brandRepository
    ) {
        $this->brandRepository = $brandRepository;
        $this->helperData      = $helperData;
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
            throw new LocalizedException(__('The module is disabled'));
        }
        $categories = [];
        if (!isset($args['id'])) {
            $categoryItems = $this->brandRepository->getCategory();
            if (empty($categoryItems)) {
                throw new GraphQlNoSuchEntityException(__('Brand category doesn\'t exist'));
            }
            foreach ($categoryItems as $category) {
                $categories[$category->getId()]          = $category->getData();
                $categories[$category->getId()]['model'] = $category;
            }

            return $categories;
        }
        $brandCategory = $this->brandRepository->getCategoryById($args['id']);
        $id            = $brandCategory->getId();
        if ($id === $args['id']) {
            throw new GraphQlNoSuchEntityException(__('Brand category doesn\'t exist'));
        }
        $categories[$id]          = $brandCategory->getData();
        $categories[$id]['model'] = $brandCategory;

        return $categories;
    }
}
