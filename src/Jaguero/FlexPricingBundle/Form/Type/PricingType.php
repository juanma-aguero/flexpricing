<?php

namespace Jaguero\FlexPricingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PricingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('title')
            ->add('subtitle')
            ->add('price')
            ->add('important')
            ->add('content')
            ->add('action')
            ->add('enabled')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jaguero\FlexPricingBundle\Entity\Pricing',
            'translation_domain' => 'Pricing',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pricing';
    }
}
