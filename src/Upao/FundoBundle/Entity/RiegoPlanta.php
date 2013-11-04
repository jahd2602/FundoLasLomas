<?php

namespace Upao\FundoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RiegoPlanta
 *
 * @ORM\Table(name="riego_planta")
 * @ORM\Entity
 */
class RiegoPlanta
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
     * @var \Upao\FundoBundle\Entity\Riego
     *
     * @ORM\ManyToOne(targetEntity="Upao\FundoBundle\Entity\Riego")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_riego", referencedColumnName="id")
     * })
     */
    private $idRiego;



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
     * @return RiegoPlanta
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
     * Set idRiego
     *
     * @param \Upao\FundoBundle\Entity\Riego $idRiego
     * @return RiegoPlanta
     */
    public function setIdRiego(\Upao\FundoBundle\Entity\Riego $idRiego = null)
    {
        $this->idRiego = $idRiego;
    
        return $this;
    }

    /**
     * Get idRiego
     *
     * @return \Upao\FundoBundle\Entity\Riego 
     */
    public function getIdRiego()
    {
        return $this->idRiego;
    }
}