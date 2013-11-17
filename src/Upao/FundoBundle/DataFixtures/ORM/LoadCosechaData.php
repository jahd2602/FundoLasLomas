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
use Symfony\Component\Security\Acl\Exception\Exception;
use Symfony\Component\Validator\Constraints\Date;
use Upao\FundoBundle\Entity\Abono;
use Upao\FundoBundle\Entity\AbonoPlanta;
use Upao\FundoBundle\Entity\Cosecha;
use Upao\FundoBundle\Entity\CosechaPlanta;
use Upao\FundoBundle\Entity\Empleado;
use Upao\FundoBundle\Entity\Planta;
use Upao\FundoBundle\Entity\Proveedor;
use Upao\FundoBundle\Entity\Venta;


class LoadCosechaData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
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
        $clientes = $manager->getRepository('UpaoFundoBundle:Cliente')->findAll();

        $fecha = new \DateTime();
        $fecha->setTimestamp(strtotime('01/01/2013'));

        for ($i = 0, $total = mt_rand(10, 20); $i < $total; $i++) {

            $cosecha = new Cosecha();
            $cosecha->setKilosPrimera(mt_rand(100, 5000));
            $cosecha->setKilosSegunda(mt_rand(100, 5000));
            $cosecha->setKilosDescarte(mt_rand(100, 5000));
            $cosecha->setFecha(clone $fecha);
            $cosecha->setObservaciones($lorem->paragraph(mt_rand(0, 2)));

            $manager->persist($cosecha);
            $fecha->add(new \DateInterval('P1D'));


            for ($j = 0, $totalCosecha = mt_rand(20, 50); $j < $totalCosecha; $j++) {

                $cosechaPlanta = new CosechaPlanta();
                $cosechaPlanta->setIdCosecha($cosecha);
                $cosechaPlanta->setIdPlanta($plantas[$j]);


                $manager->persist($cosechaPlanta);


                for ($k = 0, $totalVenta = mt_rand(4, 10); $k < $totalVenta; $k++) {

                    $venta = new Venta();
                    $venta->setIdCosecha($cosecha);
                    $venta->setIdCliente($clientes[mt_rand(0, count($clientes) - 1)]);
                    $venta->setKilosVendidos(mt_rand(100, 5000));
                    $venta->setCosto(mt_rand(100, 5000));
                    $venta->setObservaciones($lorem->paragraph(mt_rand(0, 2)));
                    $manager->persist($venta);

                }

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
            $existe = $em->getRepository('UpaoFundoBundle:Cosecha')
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
        return 5;
    }
}