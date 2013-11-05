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
     * @ORM\Column(name="total_kilos", type="float", nullable=false)
     */
    private $totalKilos;

    /**
     * @var float
     *
     * @ORM\Column(name="kilos_disponibles", type="float", nullable=false)
     */
    private $kilosDisponibles;

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
     * Set totalKilos
     *
     * @param float $totalKilos
     * @return Cosecha
     */
    public function setTotalKilos($totalKilos)
    {
        $this->totalKilos = $totalKilos;
    
        return $this;
    }

    /**
     * Get totalKilos
     *
     * @return float 
     */
    public function getTotalKilos()
    {
        return $this->totalKilos;
    }

    /**
     * Set kilosDisponibles
     *
     * @param float $kilosDisponibles
     * @return Cosecha
     */
    public function setKilosDisponibles($kilosDisponibles)
    {
        $this->kilosDisponibles = $kilosDisponibles;
    
        return $this;
    }

    /**
     * Get kilosDisponibles
     *
     * @return float 
     */
    public function getKilosDisponibles()
    {
        return $this->kilosDisponibles;
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