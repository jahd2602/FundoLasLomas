<?php

namespace Upao\FundoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Upao\FundoBundle\Entity\Cliente;
use Upao\FundoBundle\Entity\Pedido;
use Upao\FundoBundle\Entity\Planta;
use Upao\FundoBundle\Entity\Proveedor;
use Faker\Faker;
use Faker\Plugin\Utils;


class LoadClienteData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
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


        for ($i = 0, $total = mt_rand(20,40); $i < $total; $i++) {

            $cliente = new Cliente();

            $nombres = $this->faker_name->firstName();
            $apellidos = $this->faker_name->surname();

            $cliente->setNombre($nombres . ' ' . $apellidos);

            $cliente->setDireccion($this->faker_address->streetFull());
            $cliente->setTelefono(mt_rand(0, 1) == 0 ? $this->faker_number->mobile($i) : $this->faker_number->phone($i));
            $manager->persist($cliente);

        }


        $manager->flush();
    }


    public function getUnique($field, $function)
    {
        $value = '';
        $em = $this->container->get('doctrine')->getEntityManager();

        while (true) {

            $value = $function();
            $existe = $em->getRepository('UpaoFundoBundle:Cliente')
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
        return 4;
    }
}