<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Upao\FundoBundle\Entity\Pedido;
use Upao\FundoBundle\Form\PedidoType;

/**
 * Pedido controller.
 *
 */
class PedidoController extends Controller
{

    /**
     * Lists all Pedido entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UpaoFundoBundle:Pedido')->findAll();

        return $this->render('UpaoFundoBundle:Pedido:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Pedido entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Pedido();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pedido_show', array('id' => $entity->getId())));
        }

        return $this->render('UpaoFundoBundle:Pedido:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Pedido entity.
    *
    * @param Pedido $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Pedido $entity)
    {
        $form = $this->createForm(new PedidoType(), $entity, array(
            'action' => $this->generateUrl('pedido_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Pedido entity.
     *
     */
    public function newAction()
    {
        $entity = new Pedido();
        $form   = $this->createCreateForm($entity);

        return $this->render('UpaoFundoBundle:Pedido:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pedido entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Pedido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pedido entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Pedido:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Pedido entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Pedido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pedido entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Pedido:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Pedido entity.
    *
    * @param Pedido $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pedido $entity)
    {
        $form = $this->createForm(new PedidoType(), $entity, array(
            'action' => $this->generateUrl('pedido_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Pedido entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Pedido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pedido entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pedido_edit', array('id' => $id)));
        }

        return $this->render('UpaoFundoBundle:Pedido:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Pedido entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UpaoFundoBundle:Pedido')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pedido entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pedido'));
    }

    /**
     * Creates a form to delete a Pedido entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pedido_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
