<?php

namespace Upao\FundoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fumigacion
 *
 * @ORM\Table(name="fumigacion")
 * @ORM\Entity
 */
class Fumigacion
{
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=false)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", nullable=true)
     */
    private $observacion;

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
     * @var \Upao\FundoBundle\Entity\Empleado
     *
     * @ORM\ManyToOne(targetEntity="Upao\FundoBundle\Entity\Empleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_empleado", referencedColumnName="id")
     * })
     */
    private $idEmpleado;



    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Fumigacion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return Fumigacion
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;
    
        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Fumigacion
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
     * Set idEmpleado
     *
     * @param \Upao\FundoBundle\Entity\Empleado $idEmpleado
     * @return Fumigacion
     */
    public function setIdEmpleado(\Upao\FundoBundle\Entity\Empleado $idEmpleado = null)
    {
        $this->idEmpleado = $idEmpleado;
    
        return $this;
    }

    /**
     * Get idEmpleado
     *
     * @return \Upao\FundoBundle\Entity\Empleado 
     */
    public function getIdEmpleado()
    {
        return $this->idEmpleado;
    }
}