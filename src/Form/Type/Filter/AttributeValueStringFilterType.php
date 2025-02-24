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

namespace Asdoria\SyliusBulkEditPlugin\Form\Type\Filter;

use Asdoria\SyliusBulkEditPlugin\Traits\LocaleContextTrait;
use Sylius\Bundle\LocaleBundle\Form\Type\LocaleChoiceType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductAttributeChoiceType;
use Sylius\Component\Grid\Filter\StringFilter;
use Sylius\Component\Locale\Model\LocaleInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class AttributeValueStringFilterType
 * @package Asdoria\SyliusBulkEditPlugin\Form\Type\Filter
 *
 * @author  Philippe Vesin <pve.asdoria@gmail.com>
 */
class AttributeValueStringFilterType extends AbstractType
{
    use LocaleContextTrait;
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (!isset($options['type'])) {
            $builder
                ->add('type', ChoiceType::class, [
                    'choices' => [
                        'sylius.ui.contains' => StringFilter::TYPE_CONTAINS,
                        'sylius.ui.not_contains' => StringFilter::TYPE_NOT_CONTAINS,
                        'sylius.ui.equal' => StringFilter::TYPE_EQUAL,
                        'sylius.ui.not_equal' => StringFilter::TYPE_NOT_EQUAL,
                        'sylius.ui.empty' => StringFilter::TYPE_EMPTY,
                        'sylius.ui.not_empty' => StringFilter::TYPE_NOT_EMPTY,
                        'sylius.ui.starts_with' => StringFilter::TYPE_STARTS_WITH,
                        'sylius.ui.ends_with' => StringFilter::TYPE_ENDS_WITH,
                        'sylius.ui.in' => StringFilter::TYPE_IN,
                        'sylius.ui.not_in' => StringFilter::TYPE_NOT_IN,
                    ],
                ])
            ;
        }

        $builder
            ->add('attribute', ProductAttributeChoiceType::class, [
                'required' => false
            ])
            ->add('localeCode',
                LocaleChoiceType::class,
                [
                    'constraints' => [new NotBlank(['groups' => ['sylius']])],
                    'label' => 'sylius.ui.locale',
                    'empty_data' => $this->getLocaleContext()->getLocaleCode()
                ]
            )
            ->add('value', TextType::class, [
                'required' => false,
                'label' => 'sylius.ui.value',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'data_class' => null,
            ])
            ->setDefined('type')
            ->setAllowedValues('type', [
                StringFilter::TYPE_CONTAINS,
                StringFilter::TYPE_NOT_CONTAINS,
                StringFilter::TYPE_EQUAL,
                StringFilter::TYPE_NOT_EQUAL,
                StringFilter::TYPE_EMPTY,
                StringFilter::TYPE_NOT_EMPTY,
                StringFilter::TYPE_STARTS_WITH,
                StringFilter::TYPE_ENDS_WITH,
                StringFilter::TYPE_IN,
                StringFilter::TYPE_NOT_IN,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_grid_filter_attribute_value_string';
    }
}
