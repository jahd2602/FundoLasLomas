<?php

namespace Upao\FundoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cosecha
 *
 * @ORM\Table(name="cosecha")
 * @ORM\Entity
 */
class Cosecha
{
    /**
     * @var float
     *
     * @ORM\Column(name="kilos_primera", type="float", nullable=false)
     */
    private $kilosPrimera;

    /**
     * @var float
     *
     * @ORM\Column(name="kilos_segunda", type="float", nullable=false)
     */
    private $kilosSegunda;

    /**
     * @var float
     *
     * @ORM\Column(name="kilos_descarte", type="float", nullable=false)
     */
    private $kilosDescarte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return string
     */
    public function __toString(){
        return $this->getFecha()->format('Y-m-d');
    }

    /**
     * Set kilosPrimera
     *
     * @param float $kilosPrimera
     * @return Cosecha
     */
    public function setKilosPrimera($kilosPrimera)
    {
        $this->kilosPrimera = $kilosPrimera;
    
        return $this;
    }

    /**
     * Get kilosPrimera
     *
     * @return float 
     */
    public function getKilosPrimera()
    {
        return $this->kilosPrimera;
    }

    /**
     * Set kilosSegunda
     *
     * @param float $kilosSegunda
     * @return Cosecha
     */
    public function setKilosSegunda($kilosSegunda)
    {
        $this->kilosSegunda = $kilosSegunda;

        return $this;
    }

    /**
     * Get kilosSegunda
     *
     * @return float
     */
    public function getKilosSegunda()
    {
        return $this->kilosSegunda;
    }


    /**
     * Set kilosDescarte
     *
     * @param float $kilosDescarte
     * @return Cosecha
     */
    public function setKilosDescarte($kilosDescarte)
    {
        $this->kilosDescarte = $kilosDescarte;

        return $this;
    }

    /**
     * Get kilosDescarte
     *
     * @return float
     */
    public function getKilosDescarte()
    {
        return $this->kilosDescarte;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Cosecha
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
     * Set observaciones
     *
     * @param string $observaciones
     * @return Cosecha
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}