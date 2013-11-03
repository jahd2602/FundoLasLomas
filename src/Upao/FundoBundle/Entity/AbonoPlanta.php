<?php

namespace Upao\FundoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbonoPlanta
 *
 * @ORM\Table(name="abono_planta")
 * @ORM\Entity
 */
class AbonoPlanta
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
     * @var \Upao\FundoBundle\Entity\Abono
     *
     * @ORM\ManyToOne(targetEntity="Upao\FundoBundle\Entity\Abono")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_abono", referencedColumnName="id")
     * })
     */
    private $idAbono;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idAbono
     *
     * @param \Upao\FundoBundle\Entity\Abono $idAbono
     * @return AbonoPlanta
     */
    public function setIdAbono(\Upao\FundoBundle\Entity\Abono $idAbono = null)
    {
        $this->idAbono = $idAbono;
    
        return $this;
    }

    /**
     * Get idAbono
     *
     * @return \Upao\FundoBundle\Entity\Abono 
     */
    public function getIdAbono()
    {
        return $this->idAbono;
    }

    /**
     * Set idPlanta
     *
     * @param \Upao\FundoBundle\Entity\Planta $idPlanta
     * @return AbonoPlanta
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