<?php

namespace Upao\FundoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlantaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idPedido')
            ->add('idTipoPlanta')
            ->add('columna')
            ->add('fila')
            ->add('estado')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Upao\FundoBundle\Entity\Planta'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'upao_fundobundle_planta';
    }
}
