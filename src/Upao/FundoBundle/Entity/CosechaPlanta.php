<?php

namespace Upao\FundoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CosechaPlanta
 *
 * @ORM\Table(name="cosecha_planta")
 * @ORM\Entity
 */
class CosechaPlanta
{
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
     * @var \Upao\FundoBundle\Entity\Cosecha
     *
     * @ORM\ManyToOne(targetEntity="Upao\FundoBundle\Entity\Cosecha")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cosecha", referencedColumnName="id")
     * })
     */
    private $idCosecha;



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
     * @return CosechaPlanta
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

    /**
     * Set idCosecha
     *
     * @param \Upao\FundoBundle\Entity\Cosecha $idCosecha
     * @return CosechaPlanta
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