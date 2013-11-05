<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Upao\FundoBundle\Entity\Abono;
use Upao\FundoBundle\Entity\AbonoPlanta;
use Upao\FundoBundle\Entity\Cosecha;
use Upao\FundoBundle\Entity\CosechaPlanta;
use Upao\FundoBundle\Entity\Fumigacion;
use Upao\FundoBundle\Entity\FumigacionPlanta;
use Upao\FundoBundle\Entity\Pedido;
use Upao\FundoBundle\Entity\Planta;
use Upao\FundoBundle\Entity\Problema;
use Upao\FundoBundle\Entity\Riego;
use Upao\FundoBundle\Entity\RiegoPlanta;
use Upao\FundoBundle\Form\PlantaType;
use Upao\FundoBundle\Form\RegistrarAbonoType;
use Upao\FundoBundle\Form\RegistrarCosechaType;
use Upao\FundoBundle\Form\RegistrarProblemaType;
use Upao\FundoBundle\Form\RegistrarRiegoType;
use Upao\FundoBundle\Form\RegistrarSiembraType;
use Upao\FundoBundle\Form\RemovePlantaType;
use Upao\FundoBundle\Form\RemoverPlantaType;

/**
 * Planta controller.
 *
 */
class PlantaController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function sembrarAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $form = $this->createForm(new RegistrarSiembraType());

        if ($request->getMethod() === 'POST') {
            $data = array();

            $form->handleRequest($request);
            if ($form->isValid()) {

                $data = $form->getData();
                $rango = $data['posiciones'];
                $costo = (float)$data['costo'];


                $valores = explode(',', $rango);
                $celdas = array();
                foreach ($valores as $valor) {
                    $celdas[] = array(
                        'columna' => isset($valor[0]) ? Planta::toNumber(strtolower($valor[0])) : 0,
                        'fila' => isset($valor[1]) ? $valor[1] : 0,
                    );
                }


                $em->getConnection()->beginTransaction();

                try {

                    $pedido = new Pedido();
                    $pedido->setCosto($costo);
                    $pedido->setFecha(new \DateTime($data['fecha']));
                    $pedido->setIdProveedor($data['idProveedor']);

                    $em->persist($pedido);

                    foreach ($celdas as $celda) {


                        $planta = $em->getRepository('UpaoFundoBundle:Planta')
                            ->findOneBy(
                                array(
                                    'fila' => $celda['fila'],
                                    'columna' => $celda['columna'],
                                    'estado' => 'SEMBRADA'
                                ));

                        if ($planta) {
                            $planta->setEstado('REMOVIDA');
                            $em->persist($planta);
                        }

                        $planta = new Planta();
                        $planta->setColumna($celda['columna']);
                        $planta->setFila($celda['fila']);
                        $planta->setIdPedido($pedido);
                        $planta->setIdTipoPlanta($data['idTipoPlanta']);
                        $planta->setEstado('SEMBRADA');

                        $em->persist($planta);

                    }

                    $em->flush();
                    $em->getConnection()->commit();


                    $data = array(
                        'status' => 200,
                        'success' => true,
                        'message' => 'Se registró la siembra correctamente'

                    );

                } catch (Exception $e) {

                    $em->getConnection()->rollback();

                    $data = array(
                        'status' => 500,
                        'error' => true,
                        'message' => 'Error interno'

                    );
                }


            } else {
                $data = array(
                    'status' => 404,
                    'error' => true,
                    'message' => 'Llene los datos correctamente'
                );
            }

            if ($request->isXmlHttpRequest()) {

                return new Response(json_encode($data), $data['status'], array(
                    'Content-Type' => 'application/json'
                ));

            } else {
                $session->getFlashBag()->add($data['status'] === 200 ? 'ok' : 'error', $data['message']);
                return $this->redirect($this->generateUrl('inicio'));
            }

        } else {

            return $this->render('UpaoFundoBundle:Planta:sembrar.html.twig', array(
                'form' => $form->createView(),
            ));
        }

    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function removerAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $form = $this->createForm(new RemoverPlantaType());

        if ($request->getMethod() === 'POST') {
            $data = array();

            $form->handleRequest($request);
            if ($form->isValid()) {

                $data = $form->getData();
                $plantas = $data['plantas'];


                $em->getConnection()->beginTransaction();

                try {



                    foreach ($plantas as $planta) {

                        $planta->setEstado('REMOVIDA');
                        $em->persist($planta);

                    }

                    $em->flush();
                    $em->getConnection()->commit();


                    $data = array(
                        'status' => 200,
                        'success' => true,
                        'message' => 'Se removió las plantas seleccionadas correctamente'

                    );

                } catch (Exception $e) {

                    $em->getConnection()->rollback();

                    $data = array(
                        'status' => 500,
                        'error' => true,
                        'message' => 'Error interno'

                    );
                }


            } else {
                $data = array(
                    'status' => 404,
                    'error' => true,
                    'message' => 'Llene los datos correctamente'
                );
            }

            if ($request->isXmlHttpRequest()) {

                return new Response(json_encode($data), $data['status'], array(
                    'Content-Type' => 'application/json'
                ));

            } else {
                $session->getFlashBag()->add($data['status'] === 200 ? 'ok' : 'error', $data['message']);
                return $this->redirect($this->generateUrl('inicio'));
            }

        } else {

            return $this->render('UpaoFundoBundle:Planta:remover.html.twig', array(
                'form' => $form->createView(),
            ));
        }

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function abonarAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $form = $this->createForm(new RegistrarAbonoType());

        if ($request->getMethod() === 'POST') {
            $data = array();

            $form->handleRequest($request);
            if ($form->isValid()) {

                $data = $form->getData();
                $plantas = $data['plantas'];


                $em->getConnection()->beginTransaction();

                try {

                    $abono = new Abono();
                    $abono->setIdEmpleado($data['idEmpleado']);
                    $abono->setFecha(new \DateTime($data['fecha']));
                    $abono->setDescripcion($data['descripcion']);
                    $abono->setObservacion($data['observacion']);

                    $em->persist($abono);

                    foreach ($plantas as $planta) {

                        $riegoPlanta = new AbonoPlanta();
                        $riegoPlanta->setIdPlanta($planta);
                        $riegoPlanta->setIdAbono($abono);

                        $em->persist($riegoPlanta);

                    }

                    $em->flush();
                    $em->getConnection()->commit();


                    $data = array(
                        'status' => 200,
                        'success' => true,
                        'message' => 'Se registró el abonamiento correctamente'

                    );

                } catch (Exception $e) {

                    $em->getConnection()->rollback();

                    $data = array(
                        'status' => 500,
                        'error' => true,
                        'message' => 'Error interno'

                    );
                }


            } else {
                $data = array(
                    'status' => 404,
                    'error' => true,
                    'message' => 'Llene los datos correctamente'
                );
            }

            if ($request->isXmlHttpRequest()) {

                return new Response(json_encode($data), $data['status'], array(
                    'Content-Type' => 'application/json'
                ));

            } else {
                $session->getFlashBag()->add($data['status'] === 200 ? 'ok' : 'error', $data['message']);
                return $this->redirect($this->generateUrl('inicio'));
            }

        } else {

            return $this->render('UpaoFundoBundle:Planta:abonar.html.twig', array(
                'form' => $form->createView(),
            ));
        }

    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function fumigarAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $form = $this->createForm(new RegistrarAbonoType());

        if ($request->getMethod() === 'POST') {
            $data = array();

            $form->handleRequest($request);
            if ($form->isValid()) {

                $data = $form->getData();
                $plantas = $data['plantas'];


                $em->getConnection()->beginTransaction();

                try {

                    $fumigacion = new Fumigacion();
                    $fumigacion->setIdEmpleado($data['idEmpleado']);
                    $fumigacion->setFecha(new \DateTime($data['fecha']));
                    $fumigacion->setDescripcion($data['descripcion']);
                    $fumigacion->setObservacion($data['observacion']);

                    $em->persist($fumigacion);

                    foreach ($plantas as $planta) {

                        $fumigacionPlanta = new FumigacionPlanta();
                        $fumigacionPlanta->setIdPlanta($planta);
                        $fumigacionPlanta->setIdFumigacion($fumigacion);

                        $em->persist($fumigacionPlanta);

                    }

                    $em->flush();
                    $em->getConnection()->commit();


                    $data = array(
                        'status' => 200,
                        'success' => true,
                        'message' => 'Se registró la fumigación correctamente'

                    );

                } catch (Exception $e) {

                    $em->getConnection()->rollback();

                    $data = array(
                        'status' => 500,
                        'error' => true,
                        'message' => 'Error interno'

                    );
                }


            } else {
                $data = array(
                    'status' => 404,
                    'error' => true,
                    'message' => 'Llene los datos correctamente'
                );
            }

            if ($request->isXmlHttpRequest()) {

                return new Response(json_encode($data), $data['status'], array(
                    'Content-Type' => 'application/json'
                ));

            } else {
                $session->getFlashBag()->add($data['status'] === 200 ? 'ok' : 'error', $data['message']);
                return $this->redirect($this->generateUrl('inicio'));
            }

        } else {

            return $this->render('UpaoFundoBundle:Planta:fumigar.html.twig', array(
                'form' => $form->createView(),
            ));
        }

    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function cosecharAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $form = $this->createForm(new RegistrarCosechaType());

        if ($request->getMethod() === 'POST') {
            $data = array();

            $form->handleRequest($request);
            if ($form->isValid()) {

                $data = $form->getData();
                $plantas = $data['plantas'];


                $em->getConnection()->beginTransaction();

                try {

                    $cosecha = new Cosecha();
                    $cosecha->setKilosDisponibles($data['kilos_disponibles']);
                    $cosecha->setFecha(new \DateTime($data['fecha']));
                    $cosecha->setTotalKilos($data['total_kilos']);
                    $cosecha->setObservaciones($data['observaciones']);

                    $em->persist($cosecha);

                    foreach ($plantas as $planta) {

                        $cosechaPlanta = new CosechaPlanta();
                        $cosechaPlanta->setIdPlanta($planta);
                        $cosechaPlanta->setIdCosecha($cosecha);

                        $em->persist($cosechaPlanta);

                    }

                    $em->flush();
                    $em->getConnection()->commit();


                    $data = array(
                        'status' => 200,
                        'success' => true,
                        'message' => 'Se registró la fumigación correctamente'

                    );

                } catch (Exception $e) {

                    $em->getConnection()->rollback();

                    $data = array(
                        'status' => 500,
                        'error' => true,
                        'message' => 'Error interno'

                    );
                }


            } else {
                $data = array(
                    'status' => 404,
                    'error' => true,
                    'message' => 'Llene los datos correctamente'
                );
            }

            if ($request->isXmlHttpRequest()) {

                return new Response(json_encode($data), $data['status'], array(
                    'Content-Type' => 'application/json'
                ));

            } else {
                $session->getFlashBag()->add($data['status'] === 200 ? 'ok' : 'error', $data['message']);
                return $this->redirect($this->generateUrl('inicio'));
            }

        } else {

            return $this->render('UpaoFundoBundle:Planta:cosechar.html.twig', array(
                'form' => $form->createView(),
            ));
        }

    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function regarAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $form = $this->createForm(new RegistrarRiegoType());

        if ($request->getMethod() === 'POST') {
            $data = array();

            $form->handleRequest($request);
            if ($form->isValid()) {

                $data = $form->getData();
                $plantas = $data['plantas'];


                $em->getConnection()->beginTransaction();

                try {

                    $riego = new Riego();
                    $riego->setIdEmpleado($data['idEmpleado']);
                    $riego->setFecha(new \DateTime($data['fecha']));
                    $riego->setObservacion($data['observacion']);

                    $em->persist($riego);

                    foreach ($plantas as $planta) {

                        $riegoPlanta = new RiegoPlanta();
                        $riegoPlanta->setIdPlanta($planta);
                        $riegoPlanta->setIdRiego($riego);

                        $em->persist($riegoPlanta);

                    }

                    $em->flush();
                    $em->getConnection()->commit();


                    $data = array(
                        'status' => 200,
                        'success' => true,
                        'message' => 'Se registró el abonamiento correctamente'

                    );

                } catch (Exception $e) {

                    $em->getConnection()->rollback();

                    $data = array(
                        'status' => 500,
                        'error' => true,
                        'message' => 'Error interno'

                    );
                }


            } else {
                $data = array(
                    'status' => 404,
                    'error' => true,
                    'message' => 'Llene los datos correctamente'
                );
            }

            if ($request->isXmlHttpRequest()) {

                return new Response(json_encode($data), $data['status'], array(
                    'Content-Type' => 'application/json'
                ));

            } else {
                $session->getFlashBag()->add($data['status'] === 200 ? 'ok' : 'error', $data['message']);
                return $this->redirect($this->generateUrl('inicio'));
            }

        } else {

            return $this->render('UpaoFundoBundle:Planta:regar.html.twig', array(
                'form' => $form->createView(),
            ));
        }

    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function reportarProblemaAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $form = $this->createForm(new RegistrarProblemaType());

        if ($request->getMethod() === 'POST') {
            $data = array();

            $form->handleRequest($request);
            if ($form->isValid()) {

                $data = $form->getData();
                $plantas = $data['plantas'];


                $em->getConnection()->beginTransaction();

                try {


                    foreach ($plantas as $planta) {

                        $problema = new Problema();
                        $problema->setDescripcion($data['descripcion']);
                        $problema->setFecha(new \DateTime($data['fecha']));
                        $problema->setIdPlanta($planta);
                        $problema->setResuelto(false);
                        $em->persist($problema);

                    }

                    $em->flush();
                    $em->getConnection()->commit();


                    $data = array(
                        'status' => 200,
                        'success' => true,
                        'message' => 'Se registró el problema correctamente'

                    );

                } catch (Exception $e) {

                    $em->getConnection()->rollback();

                    $data = array(
                        'status' => 500,
                        'error' => true,
                        'message' => 'Error interno'

                    );
                }


            } else {
                $data = array(
                    'status' => 404,
                    'error' => true,
                    'message' => 'Llene los datos correctamente'
                );
            }

            if ($request->isXmlHttpRequest()) {

                return new Response(json_encode($data), $data['status'], array(
                    'Content-Type' => 'application/json'
                ));

            } else {
                $session->getFlashBag()->add($data['status'] === 200 ? 'ok' : 'error', $data['message']);
                return $this->redirect($this->generateUrl('inicio'));
            }

        } else {

            return $this->render('UpaoFundoBundle:Planta:reportar-problema.html.twig', array(
                'form' => $form->createView(),
            ));
        }

    }

    /**
     * Lists all Planta entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UpaoFundoBundle:Planta')->findAll();

        return $this->render('UpaoFundoBundle:Planta:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Planta entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Planta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('planta_show', array('id' => $entity->getId())));
        }

        return $this->render('UpaoFundoBundle:Planta:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Planta entity.
     *
     * @param Planta $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Planta $entity)
    {
        $form = $this->createForm(new PlantaType(), $entity, array(
            'action' => $this->generateUrl('planta_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Planta entity.
     *
     */
    public function newAction()
    {
        $entity = new Planta();
        $form = $this->createCreateForm($entity);

        return $this->render('UpaoFundoBundle:Planta:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Planta entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Planta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Planta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Planta:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing Planta entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Planta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Planta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Planta:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Planta entity.
     *
     * @param Planta $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Planta $entity)
    {
        $form = $this->createForm(new PlantaType(), $entity, array(
            'action' => $this->generateUrl('planta_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Planta entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Planta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Planta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('planta_edit', array('id' => $id)));
        }

        return $this->render('UpaoFundoBundle:Planta:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Planta entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UpaoFundoBundle:Planta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Planta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('planta'));
    }

    /**
     * Creates a form to delete a Planta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('planta_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
