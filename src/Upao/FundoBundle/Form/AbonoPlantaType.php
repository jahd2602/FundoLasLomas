<?php

namespace Upao\FundoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AbonoPlantaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idAbono')
            ->add('idPlanta')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Upao\FundoBundle\Entity\AbonoPlanta'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'upao_fundobundle_abonoplanta';
    }
}
