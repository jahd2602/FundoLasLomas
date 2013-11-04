<?php

namespace Upao\FundoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Upao\FundoBundle\Entity\TipoPlanta;


class LoadTipoPlantaData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{
    /**
     * @var Container
     */
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

        $palta = new TipoPlanta();
        $palta->setNombre('Palta Haz');
        $palta->setDescripcion('palta');
        $manager->persist($palta);

        $manzanas = new TipoPlanta();
        $manzanas->setNombre('Manzanas');
        $manzanas->setDescripcion('Manzanas');
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