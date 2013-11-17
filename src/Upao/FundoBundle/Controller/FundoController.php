<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Upao\FundoBundle\Util\Util;

class FundoController extends Controller
{
    public function indexAction()
    {
        return $this->render('UpaoFundoBundle:Fundo:index.html.twig');
    }

    public function regionAction()
    {
        $cantidadHectareas = floatval($this->container->getParameter('cantidad_hectareas')) * 10000;
        $tipoSiembra = $this->container->getParameter('tipo_siembra');

        $tipoSiembraArray = explode('x', $tipoSiembra);
        $tipoSiembraX = isset($tipoSiembraArray[0]) ? $tipoSiembraArray[0] : 1;
        $tipoSiembraY = isset($tipoSiembraArray[1]) ? $tipoSiembraArray[1] : 1;

        $espacioPlanta = $tipoSiembraX * $tipoSiembraY;
        $cantidadPlantas = floor($cantidadHectareas / $espacioPlanta);

        $filas = $espacioPlanta;
        $columnas = floor($cantidadPlantas / $filas);

        $ancho = ($columnas+1) * 40;

        $em = $this->getDoctrine()->getManager();

        $plantas = $em->getRepository('UpaoFundoBundle:Planta')
            ->findBy(
                array(
                    'estado' => 'SEMBRADA',
                ));


        $problemas = $em->getRepository('UpaoFundoBundle:Problema')
            ->findBy(
                array(
                    'resuelto' => 0,
                ));


        $bloques = array();

        for ($i = 1; $i <= $filas; $i++) {

            for ($j = 1; $j <= $columnas; $j++) {

                $plantaBloque = array();
                foreach ($plantas as $planta) {
                    if ($planta->getFila() == $i && $planta->getColumna() == $j) {
                        $plantaBloque = $planta;
                        break;
                    }
                }


                if (!empty($plantaBloque)) {

                    $estado = 'sembrado';
                    foreach ($problemas as $problema) {
                        if ($problema->getIdPlanta()->getId() == $plantaBloque->getId()) {
                            $estado = 'problema';
                            break;
                        }
                    }


                    $bloques[] = array(
                        'codigo' => Util::toAlpha($j - 1) . $i,
                        'planta' => $plantaBloque->getId(),
                        'estado' => $estado,
                        'fila' => $i,
                        'columna' => $j,
                        'tipo' => $plantaBloque->getIdTipoPlanta()->getNombre(),
                        'enlace' => $this->generateUrl(
                            'planta_show',
                            array('id' => $plantaBloque->getId())
                        ),
                    );


                } else {

                    $bloques[] = array(
                        'codigo' => Util::toAlpha($j - 1) . $i,
                        'planta' => '',
                        'estado' => 'vacio',
                        'fila' => $i,
                        'tipo' => '',
                        'columna' => $j,
                        'enlace' => '',
                    );

                }


            }

        }


        return $this->render('UpaoFundoBundle:Fundo:region.html.twig', array(
            'bloques' => $bloques,
            'ancho' => $ancho,
        ));
    }

    public function muestraAction($plantas)
    {
        $cantidadHectareas = floatval($this->container->getParameter('cantidad_hectareas')) * 10000;
        $tipoSiembra = $this->container->getParameter('tipo_siembra');

        $tipoSiembraArray = explode('x', $tipoSiembra);
        $tipoSiembraX = isset($tipoSiembraArray[0]) ? $tipoSiembraArray[0] : 1;
        $tipoSiembraY = isset($tipoSiembraArray[1]) ? $tipoSiembraArray[1] : 1;

        $espacioPlanta = $tipoSiembraX * $tipoSiembraY;
        $cantidadPlantas = floor($cantidadHectareas / $espacioPlanta);

        $filas = $espacioPlanta;
        $columnas = floor($cantidadPlantas / $filas);

        $ancho = ($columnas+1) * 40;

        $bloques = array();

        for ($i = 1; $i <= $filas; $i++) {

            for ($j = 1; $j <= $columnas; $j++) {

                $plantaBloque = array();
                foreach ($plantas as $planta) {
                    if ($planta->getFila() == $i && $planta->getColumna() == $j) {
                        $plantaBloque = $planta;
                        break;
                    }
                }


                if (!empty($plantaBloque)) {


                    $bloques[] = array(
                        'codigo' => Util::toAlpha($j - 1) . $i,
                        'planta' => $plantaBloque->getId(),
                        'estado' => 'sembrado',
                        'fila' => $i,
                        'tipo' => $plantaBloque->getIdTipoPlanta()->getNombre(),
                        'columna' => $j,
                        'enlace' => $this->generateUrl(
                            'planta_show',
                            array('id' => $plantaBloque->getId())
                        ),
                    );


                } else {

                    $bloques[] = array(
                        'codigo' => Util::toAlpha($j - 1) . $i,
                        'planta' => '',
                        'estado' => 'vacio',
                        'tipo' => '',
                        'fila' => $i,
                        'columna' => $j,
                        'enlace' => '',
                    );

                }


            }

        }


        return $this->render('UpaoFundoBundle:Fundo:muestra.html.twig', array(
            'bloques' => $bloques,
            'ancho' => $ancho,
        ));
    }
}
