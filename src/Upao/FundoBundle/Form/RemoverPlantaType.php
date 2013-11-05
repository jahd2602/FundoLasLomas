<?php

namespace Upao\FundoBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class RemoverPlantaType extends AbstractType
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
