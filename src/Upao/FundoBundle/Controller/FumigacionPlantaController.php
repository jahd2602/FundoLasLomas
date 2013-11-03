<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Upao\FundoBundle\Entity\FumigacionPlanta;
use Upao\FundoBundle\Form\FumigacionPlantaType;

/**
 * FumigacionPlanta controller.
 *
 */
class FumigacionPlantaController extends Controller
{

    /**
     * Lists all FumigacionPlanta entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UpaoFundoBundle:FumigacionPlanta')->findAll();

        return $this->render('UpaoFundoBundle:FumigacionPlanta:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new FumigacionPlanta entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new FumigacionPlanta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fumigacionplanta_show', array('id' => $entity->getId())));
        }

        return $this->render('UpaoFundoBundle:FumigacionPlanta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a FumigacionPlanta entity.
    *
    * @param FumigacionPlanta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(FumigacionPlanta $entity)
    {
        $form = $this->createForm(new FumigacionPlantaType(), $entity, array(
            'action' => $this->generateUrl('fumigacionplanta_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FumigacionPlanta entity.
     *
     */
    public function newAction()
    {
        $entity = new FumigacionPlanta();
        $form   = $this->createCreateForm($entity);

        return $this->render('UpaoFundoBundle:FumigacionPlanta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FumigacionPlanta entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:FumigacionPlanta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FumigacionPlanta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:FumigacionPlanta:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing FumigacionPlanta entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:FumigacionPlanta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FumigacionPlanta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:FumigacionPlanta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a FumigacionPlanta entity.
    *
    * @param FumigacionPlanta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FumigacionPlanta $entity)
    {
        $form = $this->createForm(new FumigacionPlantaType(), $entity, array(
            'action' => $this->generateUrl('fumigacionplanta_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing FumigacionPlanta entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:FumigacionPlanta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FumigacionPlanta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('fumigacionplanta_edit', array('id' => $id)));
        }

        return $this->render('UpaoFundoBundle:FumigacionPlanta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a FumigacionPlanta entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UpaoFundoBundle:FumigacionPlanta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FumigacionPlanta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('fumigacionplanta'));
    }

    /**
     * Creates a form to delete a FumigacionPlanta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fumigacionplanta_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
