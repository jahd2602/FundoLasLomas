<?php

namespace Upao\FundoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planta
 *
 * @ORM\Table(name="planta")
 * @ORM\Entity
 */
class Planta
{
    /**
     * @var integer
     *
     * @ORM\Column(name="columna", type="integer", nullable=true)
     */
    private $columna;

    /**
     * @var integer
     *
     * @ORM\Column(name="fila", type="integer", nullable=true)
     */
    private $fila;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", nullable=true)
     */
    private $estado;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Upao\FundoBundle\Entity\Pedido
     *
     * @ORM\ManyToOne(targetEntity="Upao\FundoBundle\Entity\Pedido")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pedido", referencedColumnName="id")
     * })
     */
    private $idPedido;

    /**
     * @var \Upao\FundoBundle\Entity\TipoPlanta
     *
     * @ORM\ManyToOne(targetEntity="Upao\FundoBundle\Entity\TipoPlanta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipo_planta", referencedColumnName="id")
     * })
     */
    private $idTipoPlanta;



    /**
     * Set columna
     *
     * @param integer $columna
     * @return Planta
     */
    public function setColumna($columna)
    {
        $this->columna = $columna;
    
        return $this;
    }

    /**
     * Get columna
     *
     * @return integer 
     */
    public function getColumna()
    {
        return $this->columna;
    }

    /**
     * Set fila
     *
     * @param integer $fila
     * @return Planta
     */
    public function setFila($fila)
    {
        $this->fila = $fila;
    
        return $this;
    }

    /**
     * Get fila
     *
     * @return integer 
     */
    public function getFila()
    {
        return $this->fila;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Planta
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    
        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
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
     * Set idPedido
     *
     * @param \Upao\FundoBundle\Entity\Pedido $idPedido
     * @return Planta
     */
    public function setIdPedido(\Upao\FundoBundle\Entity\Pedido $idPedido = null)
    {
        $this->idPedido = $idPedido;
    
        return $this;
    }

    /**
     * Get idPedido
     *
     * @return \Upao\FundoBundle\Entity\Pedido 
     */
    public function getIdPedido()
    {
        return $this->idPedido;
    }

    /**
     * Set idTipoPlanta
     *
     * @param \Upao\FundoBundle\Entity\TipoPlanta $idTipoPlanta
     * @return Planta
     */
    public function setIdTipoPlanta(\Upao\FundoBundle\Entity\TipoPlanta $idTipoPlanta = null)
    {
        $this->idTipoPlanta = $idTipoPlanta;
    
        return $this;
    }

    /**
     * Get idTipoPlanta
     *
     * @return \Upao\FundoBundle\Entity\TipoPlanta 
     */
    public function getIdTipoPlanta()
    {
        return $this->idTipoPlanta;
    }
}