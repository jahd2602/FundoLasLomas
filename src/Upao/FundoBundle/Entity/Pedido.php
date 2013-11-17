<?php

namespace Upao\FundoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedido
 *
 * @ORM\Table(name="pedido")
 * @ORM\Entity
 */
class Pedido
{
    /**
     * @var float
     *
     * @ORM\Column(name="costo", type="float", nullable=false)
     */
    private $costo;

    /**
     * @var float
     *
     * @ORM\Column(name="cantidad_abono", type="float", nullable=false)
     */
    private $cantidadAbono;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Upao\FundoBundle\Entity\Proveedor
     *
     * @ORM\ManyToOne(targetEntity="Upao\FundoBundle\Entity\Proveedor")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_proveedor", referencedColumnName="id")
     * })
     */
    private $idProveedor;


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getFecha()->format('Y-m-d');
    }


    /**
     * Set cantidadAbono
     *
     * @param float $cantidadAbono
     * @return Pedido
     */
    public function setCantidadAbono($cantidadAbono)
    {
        $this->cantidadAbono = $cantidadAbono;

        return $this;
    }

    /**
     * Get cantidadAbono
     *
     * @return float
     */
    public function getCantidadAbono()
    {
        return $this->cantidadAbono;
    }


    /**
     * Set costo
     *
     * @param float $costo
     * @return Pedido
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;

        return $this;
    }

    /**
     * Get costo
     *
     * @return float
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Pedido
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idProveedor
     *
     * @param \Upao\FundoBundle\Entity\Proveedor $idProveedor
     * @return Pedido
     */
    public function setIdProveedor(\Upao\FundoBundle\Entity\Proveedor $idProveedor = null)
    {
        $this->idProveedor = $idProveedor;

        return $this;
    }

    /**
     * Get idProveedor
     *
     * @return \Upao\FundoBundle\Entity\Proveedor
     */
    public function getIdProveedor()
    {
        return $this->idProveedor;
    }
}