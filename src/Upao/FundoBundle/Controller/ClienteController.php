<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Upao\FundoBundle\Entity\Cliente;
use Upao\FundoBundle\Form\ClienteType;

/**
 * Cliente controller.
 *
 */
class ClienteController extends Controller
{

    /**
     * Lists all Cliente entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request= $this->getRequest();



        $data = array();

        if ($request->isXmlHttpRequest()) {
            $entities = $em->getRepository('UpaoFundoBundle:Cliente')
                ->createQueryBuilder('c')
                ->orderBy('c.nombre', 'ASC')
                ->getQuery()
                ->getResult();

            foreach ($entities as $cliente) {

                $url = $this->generateUrl('cliente_edit', array('id' => $cliente->getId()));


                $data['results'][] = array(
                    'nombre' => $cliente->getNombre(),
                    'direccion' => $cliente->getDireccion(),
                    'telefono' => $cliente->getTelefono(),
                    'id' => '<a href="'.$url.'" class="btn btn-modal btn-primary">Editar</a>',
                );
            }


            return new \Symfony\Component\HttpFoundation\Response(json_encode($data), 200, array(
                'Content-Type' => 'application/json'
            ));

        } else {
        return $this->render('UpaoFundoBundle:Cliente:index.html.twig');
        }
    }
    /**
     * Creates a new Cliente entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Cliente();
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
                    'message' => 'Se registró el cliente correctamente'

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
                return $this->redirect($this->generateUrl('cliente'));

            }


        }

        return $this->render('UpaoFundoBundle:Cliente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Cliente entity.
    *
    * @param Cliente $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Cliente $entity)
    {
        $form = $this->createForm(new ClienteType(), $entity, array(
            'action' => $this->generateUrl('cliente_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Cliente entity.
     *
     */
    public function newAction()
    {
        $entity = new Cliente();
        $form   = $this->createCreateForm($entity);

        return $this->render('UpaoFundoBundle:Cliente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cliente entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Cliente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cliente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Cliente:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Cliente entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Cliente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cliente entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Cliente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Cliente entity.
    *
    * @param Cliente $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cliente $entity)
    {
        $form = $this->createForm(new ClienteType(), $entity, array(
            'action' => $this->generateUrl('cliente_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Cliente entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Cliente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cliente entity.');
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
                    'message' => 'Se actualizo el cliente correctamente'

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
                return $this->redirect($this->generateUrl('cliente'));

            }


        }


        return $this->render('UpaoFundoBundle:Cliente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Cliente entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UpaoFundoBundle:Cliente')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cliente entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cliente'));
    }

    /**
     * Creates a form to delete a Cliente entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cliente_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
