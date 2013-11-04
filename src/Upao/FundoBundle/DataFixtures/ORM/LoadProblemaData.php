<?php

namespace Upao\FundoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Faker;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraints\Date;
use Upao\FundoBundle\Entity\Abono;
use Upao\FundoBundle\Entity\AbonoPlanta;
use Upao\FundoBundle\Entity\Empleado;
use Upao\FundoBundle\Entity\Fumigacion;
use Upao\FundoBundle\Entity\FumigacionPlanta;
use Upao\FundoBundle\Entity\Planta;
use Upao\FundoBundle\Entity\Problema;
use Upao\FundoBundle\Entity\Proveedor;
use Upao\FundoBundle\Entity\Riego;
use Upao\FundoBundle\Entity\RiegoPlanta;


class LoadProblemaData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
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

        $lorem = Faker::lorem();

        $plantas = $manager->getRepository('UpaoFundoBundle:Planta')->findAll();

        $fecha = new \DateTime();
        $fecha->setTimestamp(strtotime('01/01/2013'));

        for ($i = 0, $total = mt_rand(100,200); $i < $total; $i++) {

            $problema = new Problema();
            $problema->setFecha(clone $fecha);
            $problema->setResuelto(mt_rand(0, 5) == 0 ? true : false);
            $problema->setIdPlanta($plantas[mt_rand(0, count($plantas) - 1)]);
            $problema->setDescripcion($lorem->paragraph(mt_rand(1, 2)));

            $manager->persist($problema);
            $fecha->add(new \DateInterval('P1D'));

        }

        $manager->flush();
    }


    public function getUnique($field, $function)
    {
        $value = '';
        $em = $this->container->get('doctrine')->getEntityManager();

        while (true) {

            $value = $function();
            $existe = $em->getRepository('UpaoFundoBundle:Problema')
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
        return 9;
    }
}