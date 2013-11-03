<?php

namespace Upao\FundoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Venta
 *
 * @ORM\Table(name="venta")
 * @ORM\Entity
 */
class Venta
{
    /**
     * @var float
     *
     * @ORM\Column(name="kilos_vendidos", type="float", nullable=true)
     */
    private $kilosVendidos;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @var float
     *
     * @ORM\Column(name="costo", type="float", nullable=false)
     */
    private $costo;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Upao\FundoBundle\Entity\Cliente
     *
     * @ORM\ManyToOne(targetEntity="Upao\FundoBundle\Entity\Cliente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cliente", referencedColumnName="id")
     * })
     */
    private $idCliente;

    /**
     * @var \Upao\FundoBundle\Entity\Cosecha
     *
     * @ORM\ManyToOne(targetEntity="Upao\FundoBundle\Entity\Cosecha")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cosecha", referencedColumnName="id")
     * })
     */
    private $idCosecha;



    /**
     * Set kilosVendidos
     *
     * @param float $kilosVendidos
     * @return Venta
     */
    public function setKilosVendidos($kilosVendidos)
    {
        $this->kilosVendidos = $kilosVendidos;
    
        return $this;
    }

    /**
     * Get kilosVendidos
     *
     * @return float 
     */
    public function getKilosVendidos()
    {
        return $this->kilosVendidos;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Venta
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    
        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set costo
     *
     * @param float $costo
     * @return Venta
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idCliente
     *
     * @param \Upao\FundoBundle\Entity\Cliente $idCliente
     * @return Venta
     */
    public function setIdCliente(\Upao\FundoBundle\Entity\Cliente $idCliente = null)
    {
        $this->idCliente = $idCliente;
    
        return $this;
    }

    /**
     * Get idCliente
     *
     * @return \Upao\FundoBundle\Entity\Cliente 
     */
    public function getIdCliente()
    {
        return $this->idCliente;
    }

    /**
     * Set idCosecha
     *
     * @param \Upao\FundoBundle\Entity\Cosecha $idCosecha
     * @return Venta
     */
    public function setIdCosecha(\Upao\FundoBundle\Entity\Cosecha $idCosecha = null)
    {
        $this->idCosecha = $idCosecha;
    
        return $this;
    }

    /**
     * Get idCosecha
     *
     * @return \Upao\FundoBundle\Entity\Cosecha 
     */
    public function getIdCosecha()
    {
        return $this->idCosecha;
    }
}