<?php

namespace Upao\FundoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstadoAmbiente
 *
 * @ORM\Table(name="estado_ambiente")
 * @ORM\Entity
 */
class EstadoAmbiente
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var float
     *
     * @ORM\Column(name="temperatura", type="float", nullable=false)
     */
    private $temperatura;

    /**
     * @var float
     *
     * @ORM\Column(name="humedad", type="float", nullable=false)
     */
    private $humedad;

    /**
     * @var float
     *
     * @ORM\Column(name="presion_ambiental", type="float", nullable=false)
     */
    private $presionAmbiental;

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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return EstadoAmbiente
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
     * Set temperatura
     *
     * @param float $temperatura
     * @return EstadoAmbiente
     */
    public function setTemperatura($temperatura)
    {
        $this->temperatura = $temperatura;
    
        return $this;
    }

    /**
     * Get temperatura
     *
     * @return float 
     */
    public function getTemperatura()
    {
        return $this->temperatura;
    }

    /**
     * Set humedad
     *
     * @param float $humedad
     * @return EstadoAmbiente
     */
    public function setHumedad($humedad)
    {
        $this->humedad = $humedad;
    
        return $this;
    }

    /**
     * Get humedad
     *
     * @return float 
     */
    public function getHumedad()
    {
        return $this->humedad;
    }

    /**
     * Set presionAmbiental
     *
     * @param float $presionAmbiental
     * @return EstadoAmbiente
     */
    public function setPresionAmbiental($presionAmbiental)
    {
        $this->presionAmbiental = $presionAmbiental;
    
        return $this;
    }

    /**
     * Get presionAmbiental
     *
     * @return float 
     */
    public function getPresionAmbiental()
    {
        return $this->presionAmbiental;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return EstadoAmbiente
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