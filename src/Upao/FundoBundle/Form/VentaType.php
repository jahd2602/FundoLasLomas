<?php

namespace Upao\FundoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VentaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idCliente', 'entity', array(
                'label' => 'Cliente',
                'label_attr' => array(
                    'class' => 'control-label'
                ),
                'class' => 'UpaoFundoBundle:Cliente',
                'empty_value' => 'Seleccione',
                'property' => 'nombre',
                'multiple' => false,
                'required' => true,
            ))
            ->add('idCosecha', 'entity', array(
                'label' => 'Cosecha',
                'label_attr' => array(
                    'class' => 'control-label'
                ),
                'class' => 'UpaoFundoBundle:Cosecha',
                'empty_value' => 'Seleccione',
                'multiple' => false,
                'required' => true,
            ))
            ->add('tipo', 'choice', array(
                 'label' => 'Tipo de Producto',
                 'label_attr' => array(
                     'class' => 'control-label'
                 ),
                 'empty_value' => 'Seleccione',
                 'choices' => array(
                     'PRIMERA' => 'Primera Calidad',
                     'SEGUNDA' => 'Segunda Calidad',
                     'DESCARTE' => 'Descarte',
                 ),
                 'required' => true,
                 'multiple' => false,
             ))
            ->add('kilosVendidos')
            ->add('observaciones')
            ->add('costo');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Upao\FundoBundle\Entity\Venta'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'upao_fundobundle_venta';
    }
}
