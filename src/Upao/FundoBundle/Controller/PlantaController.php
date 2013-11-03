<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Upao\FundoBundle\Entity\Planta;
use Upao\FundoBundle\Form\PlantaType;

/**
 * Planta controller.
 *
 */
class PlantaController extends Controller
{

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
            'form'   => $form->createView(),
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
        $form   = $this->createCreateForm($entity);

        return $this->render('UpaoFundoBundle:Planta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
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
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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
            ->getForm()
        ;
    }
}
