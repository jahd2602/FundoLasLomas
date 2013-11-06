<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Upao\FundoBundle\Entity\Empleado;
use Upao\FundoBundle\Form\EmpleadoType;

/**
 * Empleado controller.
 *
 */
class EmpleadoController extends Controller
{

    /**
     * Lists all Empleado entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();


        $data = array();

        if ($request->isXmlHttpRequest()) {

            $entities = $em->getRepository('UpaoFundoBundle:Empleado')
                ->createQueryBuilder('e')
                ->orderBy('e.nombre', 'ASC')
                ->getQuery()
                ->getResult();

            foreach ($entities as $empleado) {

                $url = $this->generateUrl('empleado_edit', array('id' => $empleado->getId()));


                $data['results'][] = array(
                    'nombre' => $empleado->getNombre(),
                    'dni' => $empleado->getDni(),
                    'telefono' => $empleado->getTelefono(),
                    'id' => '<a href="' . $url . '" class="btn btn-modal btn-primary">Editar</a>',
                );
            }


            return new \Symfony\Component\HttpFoundation\Response(json_encode($data), 200, array(
                'Content-Type' => 'application/json'
            ));

        } else {
            return $this->render('UpaoFundoBundle:Empleado:index.html.twig');
        }

    }

    /**
     * Creates a new Empleado entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Empleado();
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
                    'message' => 'Se registró el empleado correctamente'

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
                return $this->redirect($this->generateUrl('empleado'));

            }


        }

        return $this->render('UpaoFundoBundle:Empleado:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Empleado entity.
     *
     * @param Empleado $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Empleado $entity)
    {
        $form = $this->createForm(new EmpleadoType(), $entity, array(
            'action' => $this->generateUrl('empleado_create'),
            'method' => 'POST',
        ));

        // $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Empleado entity.
     *
     */
    public function newAction()
    {
        $entity = new Empleado();
        $form = $this->createCreateForm($entity);

        return $this->render('UpaoFundoBundle:Empleado:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Empleado entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Empleado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Empleado entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Empleado:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing Empleado entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Empleado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Empleado entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Empleado:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Empleado entity.
     *
     * @param Empleado $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Empleado $entity)
    {
        $form = $this->createForm(new EmpleadoType(), $entity, array(
            'action' => $this->generateUrl('empleado_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Empleado entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Empleado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Empleado entity.');
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
                    'message' => 'Se actualizo el empleado correctamente'

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
                return $this->redirect($this->generateUrl('empleado'));

            }

        }


        return $this->render('UpaoFundoBundle:Empleado:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Empleado entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UpaoFundoBundle:Empleado')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Empleado entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('empleado'));
    }

    /**
     * Creates a form to delete a Empleado entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('empleado_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
