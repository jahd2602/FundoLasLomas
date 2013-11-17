<?php

namespace Upao\FundoBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrarCosechaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder->add('plantas', 'entity', array(
            'label' => 'Plantas',
            'label_attr' => array(
                'class' => 'control-label'
            ),
            'class' => 'UpaoFundoBundle:Planta',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('p')
                    ->where('p.estado = :estado')
                    ->setParameter('estado', 'SEMBRADA');
            },
            'empty_value' => 'Seleccione',
            'property' => 'codigo',
            'multiple' => true,
            'required' => true,
            'attr' => array(
                'class' => 'form-control rango-seleccionado',
                'data-codigo' => 'planta'
            ),
        ));


        $builder->add('kilos_primera', 'text', array(
            'label' => 'Kilos de Primera',
            'label_attr' => array(
                'class' => 'control-label'
            ),
            'attr' => array( //'location' => true
            ),
            'required' => true,
        ));

        $builder->add('kilos_segunda', 'text', array(
            'label' => 'Kilos de Segunda',
            'label_attr' => array(
                'class' => 'control-label'
            ),
            'attr' => array( //'location' => true
            ),
            'required' => true,
        ));

        $builder->add('kilos_descarte', 'text', array(
            'label' => 'Kilos de Descarte',
            'label_attr' => array(
                'class' => 'control-label'
            ),
            'attr' => array( //'location' => true
            ),
            'required' => true,
        ));



        $builder->add('observaciones', 'textarea', array(
            'label' => 'Observación',
            'label_attr' => array(
                'class' => 'control-label'
            ),
            'attr' => array( //'location' => true
            ),
            'required' => false,
        ));


        $builder->add('fecha', 'text', array(
            'label' => 'Fecha',
            'label_attr' => array(
                'class' => 'control-label'
            ),
            'attr' => array(
                'value' => (new \DateTime())->format('Y-m-d H:i'),
                'data-date-format' => 'yyyy-mm-dd hh:ii',
                'type' => 'datetime',
                'placeholder' => 'YYYY-MM-DD HH:mm',
                'class' => 'form-control datepicker'
            ),
            'required' => true,
        ));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_group' => array(
                'registrar'
            ),
            'csrf_protection' => true,
            //'data_class' => 'Upao\FundoBundle\Entity\Pedido'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'upao_fundobundle_registrar_sucursal';
    }
}
