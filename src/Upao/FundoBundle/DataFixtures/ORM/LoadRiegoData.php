<?php

namespace Upao\FundoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Faker;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraints\Date;
use Upao\FundoBundle\Entity\Abono;
use Upao\FundoBundle\Entity\AbonoPlanta;
use Upao\FundoBundle\Entity\Empleado;
use Upao\FundoBundle\Entity\Fumigacion;
use Upao\FundoBundle\Entity\FumigacionPlanta;
use Upao\FundoBundle\Entity\Planta;
use Upao\FundoBundle\Entity\Proveedor;
use Upao\FundoBundle\Entity\Riego;
use Upao\FundoBundle\Entity\RiegoPlanta;


class LoadRiegoData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
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
        $empleados = $manager->getRepository('UpaoFundoBundle:Empleado')->findAll();

        $fecha = new \DateTime();
        $fecha->setTimestamp(strtotime('01/01/2013'));


        for ($i = 0, $total = mt_rand(10,20); $i < $total; $i++) {

            $riego = new Riego();
            $riego->setFecha(clone $fecha);
            $riego->setIdEmpleado($empleados[mt_rand(0, count($empleados) - 1)]);
            $riego->setObservacion($lorem->paragraph(mt_rand(0, 2)));

            $manager->persist($riego);
            $fecha->add(new \DateInterval('P1D'));


            for ($j = 0, $totalRiego = mt_rand(10,20); $j < $totalRiego; $j++) {

                $riegoPlanta = new RiegoPlanta();
                $riegoPlanta->setIdRiego($riego);
                $riegoPlanta->setIdPlanta($plantas[$j]);


                $manager->persist($riegoPlanta);

            }


        }


        $manager->flush();
    }


    public function getUnique($field, $function)
    {
        $value = '';
        $em = $this->container->get('doctrine')->getEntityManager();

        while (true) {

            $value = $function();
            $existe = $em->getRepository('UpaoFundoBundle:Riego')
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
        return 8;
    }
}