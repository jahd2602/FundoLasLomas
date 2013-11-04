<?php

namespace Upao\FundoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FumigacionPlanta
 *
 * @ORM\Table(name="fumigacion_planta")
 * @ORM\Entity
 */
class FumigacionPlanta
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
     * @var \Upao\FundoBundle\Entity\Fumigacion
     *
     * @ORM\ManyToOne(targetEntity="Upao\FundoBundle\Entity\Fumigacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_fumigacion", referencedColumnName="id")
     * })
     */
    private $idFumigacion;

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
     * Set idFumigacion
     *
     * @param \Upao\FundoBundle\Entity\Fumigacion $idFumigacion
     * @return FumigacionPlanta
     */
    public function setIdFumigacion(\Upao\FundoBundle\Entity\Fumigacion $idFumigacion = null)
    {
        $this->idFumigacion = $idFumigacion;
    
        return $this;
    }

    /**
     * Get idFumigacion
     *
     * @return \Upao\FundoBundle\Entity\Fumigacion 
     */
    public function getIdFumigacion()
    {
        return $this->idFumigacion;
    }

    /**
     * Set idPlanta
     *
     * @param \Upao\FundoBundle\Entity\Planta $idPlanta
     * @return FumigacionPlanta
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