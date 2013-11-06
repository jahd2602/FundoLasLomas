<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Upao\FundoBundle\Entity\EstadoAmbiente;
use Upao\FundoBundle\Form\EstadoAmbienteType;
use Upao\FundoBundle\Util\Util;

/**
 * EstadoAmbiente controller.
 *
 */
class EstadoAmbienteController extends Controller
{

    /**
     * Lists all EstadoAmbiente entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request= $this->getRequest();


        $data = array();

        if ($request->isXmlHttpRequest()) {
            $entities = $em->getRepository('UpaoFundoBundle:EstadoAmbiente')
                ->createQueryBuilder('e')
                ->orderBy('e.fecha', 'DESC')
                ->getQuery()
                ->getResult();

            foreach ($entities as $estadoAmbiente) {


                $url = $this->generateUrl('estadoambiente_edit', array('id' => $estadoAmbiente->getId()));



                $data['results'][] = array(
                    'fecha' => $estadoAmbiente->getFecha()->format('Y-m-d'),
                    'humedad' => $estadoAmbiente->getHumedad(),
                    'presion_ambiental' => $estadoAmbiente->getPresionAmbiental(),
                    'temperatura' => $estadoAmbiente->getTemperatura(),
                //    'observaciones' => Util::truncate($estadoAmbiente->getObservaciones(),50),
                    'observaciones' => $estadoAmbiente->getObservaciones(),
                    'id' => '<a href="'.$url.'" class="btn btn-modal btn-primary">Editar</a>',
                );
            }


            return new \Symfony\Component\HttpFoundation\Response(json_encode($data), 200, array(
                'Content-Type' => 'application/json'
            ));

        } else {
            return $this->render('UpaoFundoBundle:EstadoAmbiente:index.html.twig');
        }
    }
    /**
     * Creates a new EstadoAmbiente entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new EstadoAmbiente();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $session = $request->getSession();


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            try {

                $em->persist($entity);
                $em->flush();

                $data = array(
                    'status' => 200,
                    'success' => true,
                    'message' => 'Se registró el estado del ambiente correctamente'

                );

            } catch (\Exception $e) {
                $data = array(
                    'status' => 500,
                    'error' => true,
                    'message' => 'Error interno'

                );
            }

            if ($request->isXmlHttpRequest()) {

                return new \Symfony\Component\HttpFoundation\Response(json_encode($data), $data['status'], array(
                    'Content-Type' => 'application/json'
                ));

            } else {
                $session->getFlashBag()->add($data['status'] === 200 ? 'ok' : 'error', $data['message']);
                return $this->redirect($this->generateUrl('estadoambiente'));

            }


        }

        return $this->render('UpaoFundoBundle:EstadoAmbiente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a EstadoAmbiente entity.
    *
    * @param EstadoAmbiente $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(EstadoAmbiente $entity)
    {
        $form = $this->createForm(new EstadoAmbienteType(), $entity, array(
            'action' => $this->generateUrl('estadoambiente_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new EstadoAmbiente entity.
     *
     */
    public function newAction()
    {
        $entity = new EstadoAmbiente();
        $form   = $this->createCreateForm($entity);

        return $this->render('UpaoFundoBundle:EstadoAmbiente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EstadoAmbiente entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:EstadoAmbiente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadoAmbiente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:EstadoAmbiente:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing EstadoAmbiente entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:EstadoAmbiente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadoAmbiente entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:EstadoAmbiente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a EstadoAmbiente entity.
    *
    * @param EstadoAmbiente $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EstadoAmbiente $entity)
    {
        $form = $this->createForm(new EstadoAmbienteType(), $entity, array(
            'action' => $this->generateUrl('estadoambiente_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

       // $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing EstadoAmbiente entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:EstadoAmbiente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadoAmbiente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $session = $request->getSession();


        if ($editForm->isValid()) {

            try {

                $em->flush();

                $data = array(
                    'status' => 200,
                    'success' => true,
                    'message' => 'Se actualizo el Estado ambiental correctamente'

                );

            } catch (\Exception $e) {
                $data = array(
                    'status' => 500,
                    'error' => true,
                    'message' => 'Error interno'

                );
            }

            if ($request->isXmlHttpRequest()) {

                return new \Symfony\Component\HttpFoundation\Response(json_encode($data), $data['status'], array(
                    'Content-Type' => 'application/json'
                ));

            } else {
                $session->getFlashBag()->add($data['status'] === 200 ? 'ok' : 'error', $data['message']);
                return $this->redirect($this->generateUrl('estadoambiente'));

            }

        }


        return $this->render('UpaoFundoBundle:EstadoAmbiente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a EstadoAmbiente entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UpaoFundoBundle:EstadoAmbiente')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EstadoAmbiente entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('estadoambiente'));
    }

    /**
     * Creates a form to delete a EstadoAmbiente entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estadoambiente_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
