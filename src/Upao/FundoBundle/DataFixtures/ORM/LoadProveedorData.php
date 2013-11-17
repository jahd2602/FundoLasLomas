<?php

namespace Upao\FundoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Upao\FundoBundle\Entity\Pedido;
use Upao\FundoBundle\Entity\Planta;
use Upao\FundoBundle\Entity\Proveedor;
use Faker\Faker;
use Faker\Plugin\Utils;


class LoadProveedorData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{

    private $faker_name;
    private $faker_number;
    private $faker_identification;
    private $faker_address;

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


        $this->faker_name = Faker::name();
        $this->faker_number = Faker::phoneNumber();
        $this->faker_identification = Faker::identification();
        $this->faker_address = Faker::address();


        $tiposPlanta = $manager->getRepository('UpaoFundoBundle:TipoPlanta')->findAll();

        $fecha = new \DateTime();
        $fecha->setTimestamp(strtotime('01/01/2013'));


        for ($i = 0, $total = mt_rand(10,20); $i < $total; $i++) {

            $proveedor = new Proveedor();
            $proveedor->setNombre('Proveedor' . $i);

            $nombres = $this->faker_name->firstName();
            $apellidos = $this->faker_name->surname();
            $proveedor->setContacto($nombres . ' ' . $apellidos);
            $proveedor->setDireccion($this->faker_address->streetFull());

            $proveedor->setRuc($this->faker_identification->ruc($i));
            $proveedor->setTelefono(mt_rand(0, 1) == 0 ? $this->faker_number->mobile($i) : $this->faker_number->phone($i));
            $manager->persist($proveedor);



            for ($j = 0, $totalPedido = mt_rand(1, 3); $j < $totalPedido; $j++) {
                $pedido = new Pedido();
                $pedido->setFecha(clone $fecha);
                $pedido->setCosto(mt_rand(500, 5000));
                $pedido->setCantidadAbono(mt_rand(500, 5000));
                $pedido->setIdProveedor($proveedor);

                $manager->persist($pedido);
                $fecha->add(new \DateInterval('P1D'));


                for ($k = 0, $totalPlanta = mt_rand(20, 50); $k < $totalPlanta; $k++) {
                    $planta = new Planta();
                    $planta->setColumna(mt_rand(1, 10));
                    $planta->setFila(mt_rand(1, 10));
                    $planta->setIdPedido($pedido);
                    $planta->setEstado(mt_rand(0, 5) == 0 ? 'REMOVIDA' : 'SEMBRADA');
                    $planta->setIdTipoPlanta($tiposPlanta[mt_rand(0, count($tiposPlanta) - 1)]);

                    $manager->persist($planta);
                }

            }

        }


        $manager->flush();
    }

    public function getUniqueRuc($i = 0)
    {
        $faker = $this->faker_identification;
        return $this->getUnique('ruc', function () use ($faker, $i) {
            return $faker->ruc($i);
        });
    }

    public function getUnique($field, $function)
    {
        $value = '';
        $em = $this->container->get('doctrine')->getEntityManager();

        while (true) {

            $value = $function();
            $existe = $em->getRepository('UpaoFundoBundle:Proveedor')
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
        return 2;
    }
}