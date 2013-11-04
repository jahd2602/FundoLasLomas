<?php

namespace Upao\FundoBundle\Twig;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Container;

class FundoExtension extends \Twig_Extension
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct($container){
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('convertirLetra', array($this, 'convertirLetra')),
            new \Twig_SimpleFilter('buscarPlanta', array($this, 'buscarPlanta')),
        );
    }

    public function buscarPlanta($codigo, $columna, $fila)
    {


        $planta =  $this->em->getRepository('UpaoFundoBundle:Planta')
            ->findOneBy(
                array(
                    'fila' => $fila,
                    'columna' => $columna,
                    'estado' => 'SEMBRADA'
                ));


        return $planta;
    }

    public function convertirLetra($number, $uppercase = true)
    {
        $number -= 1;
        $letter = chr(($number % 26) + 97);
        $letter .= (floor($number / 26) > 0) ? str_repeat($letter, floor($number / 26)) : '';
        return ($uppercase ? strtoupper($letter) : $letter);

    }

    public function getName()
    {
        return 'fundo_extension';
    }
}