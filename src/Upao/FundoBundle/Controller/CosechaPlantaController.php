<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Upao\FundoBundle\Entity\CosechaPlanta;
use Upao\FundoBundle\Form\CosechaPlantaType;

/**
 * CosechaPlanta controller.
 *
 */
class CosechaPlantaController extends Controller
{

    /**
     * Lists all CosechaPlanta entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UpaoFundoBundle:CosechaPlanta')->findAll();

        return $this->render('UpaoFundoBundle:CosechaPlanta:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new CosechaPlanta entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new CosechaPlanta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cosechaplanta_show', array('id' => $entity->getId())));
        }

        return $this->render('UpaoFundoBundle:CosechaPlanta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a CosechaPlanta entity.
    *
    * @param CosechaPlanta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(CosechaPlanta $entity)
    {
        $form = $this->createForm(new CosechaPlantaType(), $entity, array(
            'action' => $this->generateUrl('cosechaplanta_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CosechaPlanta entity.
     *
     */
    public function newAction()
    {
        $entity = new CosechaPlanta();
        $form   = $this->createCreateForm($entity);

        return $this->render('UpaoFundoBundle:CosechaPlanta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CosechaPlanta entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:CosechaPlanta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CosechaPlanta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:CosechaPlanta:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing CosechaPlanta entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:CosechaPlanta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CosechaPlanta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:CosechaPlanta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a CosechaPlanta entity.
    *
    * @param CosechaPlanta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CosechaPlanta $entity)
    {
        $form = $this->createForm(new CosechaPlantaType(), $entity, array(
            'action' => $this->generateUrl('cosechaplanta_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CosechaPlanta entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:CosechaPlanta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CosechaPlanta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cosechaplanta_edit', array('id' => $id)));
        }

        return $this->render('UpaoFundoBundle:CosechaPlanta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CosechaPlanta entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UpaoFundoBundle:CosechaPlanta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CosechaPlanta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cosechaplanta'));
    }

    /**
     * Creates a form to delete a CosechaPlanta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cosechaplanta_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
