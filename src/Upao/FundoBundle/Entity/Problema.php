<?php

namespace Upao\FundoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Problema
 *
 * @ORM\Table(name="problema")
 * @ORM\Entity
 */
class Problema
{
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=false)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @var boolean
     *
     * @ORM\Column(name="resuelto", type="boolean", nullable=true)
     */
    private $resuelto;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Upao\FundoBundle\Entity\Planta
     *
     * @ORM\ManyToOne(targetEntity="Upao\FundoBundle\Entity\Planta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_planta", referencedColumnName="id")
     * })
     */
    private $idPlanta;



    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Problema
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Problema
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
     * Set resuelto
     *
     * @param boolean $resuelto
     * @return Problema
     */
    public function setResuelto($resuelto)
    {
        $this->resuelto = $resuelto;
    
        return $this;
    }

    /**
     * Get resuelto
     *
     * @return boolean 
     */
    public function getResuelto()
    {
        return $this->resuelto;
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
     * Set idPlanta
     *
     * @param \Upao\FundoBundle\Entity\Planta $idPlanta
     * @return Problema
     */
    public function setIdPlanta(\Upao\FundoBundle\Entity\Planta $idPlanta = null)
    {
        $this->idPlanta = $idPlanta;
    
        return $this;
    }

    /**
     * Get idPlanta
     *
     * @return \Upao\FundoBundle\Entity\Planta 
     */
    public function getIdPlanta()
    {
        return $this->idPlanta;
    }
}