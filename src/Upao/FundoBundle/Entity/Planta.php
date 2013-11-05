<?php

namespace Upao\FundoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Upao\FundoBundle\Twig\FundoExtension;

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
     * @ORM\JoinColumn(name="id_pedido", referencedColumnName="id")
     * })
     */
    private $idPedido;

    /**
     * @var \Upao\FundoBundle\Entity\TipoPlanta
     *
     * @ORM\ManyToOne(targetEntity="Upao\FundoBundle\Entity\TipoPlanta")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_tipo_planta", referencedColumnName="id")
     * })
     */
    private $idTipoPlanta;


    public function getCodigo()
    {
        return $this->toAlpha($this->columna) . $this->fila;
    }

    private function toAlpha($data)
    {
        $alphabet = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        $alpha_flip = array_flip($alphabet);
        if ($data <= 25) {
            return strtoupper($alphabet[$data]);
        } elseif ($data > 25) {
            $dividend = ($data + 1);
            $alpha = '';
            while ($dividend > 0) {
                $modulo = ($dividend - 1) % 26;
                $alpha = $alphabet[$modulo] . $alpha;
                $dividend = floor((($dividend - $modulo) / 26));
            }
            return strtoupper($alpha);
        }

    }

    static function toNumber($data)
    {
        $alphabet = array('a', 'b', 'c', 'd', 'e',
            'f', 'g', 'h', 'i', 'j',
            'k', 'l', 'm', 'n', 'o',
            'p', 'q', 'r', 's', 't',
            'u', 'v', 'w', 'x', 'y',
            'z'
        );
        $alpha_flip = array_flip($alphabet);
        $return_value = -1;
        $length = strlen($data);
        for ($i = 0; $i < $length; $i++) {
            $return_value += ($alpha_flip[$data[$i]] + 1) * pow(26, ($length - $i - 1));
        }
        return $return_value + 1;
    }

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