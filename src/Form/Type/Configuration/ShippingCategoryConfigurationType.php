<?php

declare(strict_types=1);

/*
 * This file is part of the Asdoria Package.
 *
 * (c) Asdoria .
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asdoria\SyliusBulkEditPlugin\Form\Type\Configuration;

use Sylius\Bundle\ResourceBundle\Form\DataTransformer\ResourceToIdentifierTransformer;
use Sylius\Bundle\ShippingBundle\Form\Type\ShippingCategoryChoiceType;
use Sylius\Component\Core\Repository\ShippingCategoryRepositoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ReversedTransformer;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ShippingCategoryConfigurationType
 * @package Asdoria\SyliusBulkEditPlugin\Form\Type\Configuration
 *
 * @author  Philippe Vesin <pve.asdoria@gmail.com>
 */
class ShippingCategoryConfigurationType extends AbstractType
{
    const _SHIPPING_CATEGORY_FIELD = 'shipping_category';

    /**
     * @param ShippingCategoryRepositoryInterface $shippingCategoryRepository
     */
    public function __construct(protected ShippingCategoryRepositoryInterface $shippingCategoryRepository) {
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $taxCategoryField = $builder
            ->create(self::_SHIPPING_CATEGORY_FIELD, ShippingCategoryChoiceType::class, [
                'constraints' => [new NotBlank(['groups' => ['sylius']])],
            ])
            ->addModelTransformer(new ReversedTransformer(new ResourceToIdentifierTransformer($this->shippingCategoryRepository, 'code')));

        $builder->add($taxCategoryField);

    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'asdoria_bulk_edit_configuration_shipping_category';
    }
}
