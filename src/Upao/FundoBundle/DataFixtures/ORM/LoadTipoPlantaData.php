<?php

namespace Upao\FundoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Upao\FundoBundle\Entity;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadTipoPlantaData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $palta = new Entity\TipoPlanta();
        $palta->setNombre("Palta Haz");
        $palta->setDescripcion("palta");
        $manager->persist($palta);

        $manzanas = new Entity\TipoPlanta();
        $manzanas->setNombre("Manzanas");
        $manzanas->setDescripcion("Manzanas");
        $manager->persist($manzanas);


        $manager->flush();
    }


    public function getUnique($field, $function)
    {
        $value = '';
        $em = $this->container->get('doctrine')->getEntityManager();

        while (true) {

            $value = $function();
            $existe = $em->getRepository('UpaoFundoBundle:TipoPlanta')
                ->findBy(
                    array($field => $value)
                );

            if (!$existe) {
                break;
            }

        }


        return $value;
    }

    public function getOrder()
    {
        return 1;
    }
}