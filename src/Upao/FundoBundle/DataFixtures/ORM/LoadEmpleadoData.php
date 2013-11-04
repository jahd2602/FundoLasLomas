<?php

namespace Upao\FundoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Upao\FundoBundle\Entity\Empleado;
use Faker\Faker;
use Faker\Plugin\Utils;


class LoadEmpleadoData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{

    private $faker_name;
    private $faker_number;
    private $faker_identification;

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


        for ($i = 0, $total = mt_rand(50,100); $i < $total; $i++) {

            $empleado = new Empleado();

            $nombres = $this->faker_name->firstName();
            $apellidos = $this->faker_name->surname();
            $empleado->setNombre($nombres.' '.$apellidos);

            $empleado->setDni($this->faker_identification->dni($i));
            $empleado->setTelefono(mt_rand(0,3) == 0 ? $this->faker_number->mobile($i) : $this->faker_number->phone($i));

            $manager->persist($empleado);
        }


        $manager->flush();
    }

    public function getUniqueDni($i = 0)
    {
        $faker = $this->faker_identification;
        return $this->getUnique('dni', function () use ($faker, $i) {
            return $faker->dni($i);
        });
    }

    public function getUnique($field, $function)
    {
        $value = '';
        $em = $this->container->get('doctrine')->getEntityManager();

        while (true) {

            $value = $function();
            $existe = $em->getRepository('UpaoFundoBundle:Empleado')
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
        return 3;
    }
}