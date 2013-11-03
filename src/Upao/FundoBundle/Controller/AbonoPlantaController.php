<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Upao\FundoBundle\Entity\AbonoPlanta;
use Upao\FundoBundle\Form\AbonoPlantaType;

/**
 * AbonoPlanta controller.
 *
 */
class AbonoPlantaController extends Controller
{

    /**
     * Lists all AbonoPlanta entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UpaoFundoBundle:AbonoPlanta')->findAll();

        return $this->render('UpaoFundoBundle:AbonoPlanta:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new AbonoPlanta entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new AbonoPlanta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('abonoplanta_show', array('id' => $entity->getId())));
        }

        return $this->render('UpaoFundoBundle:AbonoPlanta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a AbonoPlanta entity.
    *
    * @param AbonoPlanta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(AbonoPlanta $entity)
    {
        $form = $this->createForm(new AbonoPlantaType(), $entity, array(
            'action' => $this->generateUrl('abonoplanta_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AbonoPlanta entity.
     *
     */
    public function newAction()
    {
        $entity = new AbonoPlanta();
        $form   = $this->createCreateForm($entity);

        return $this->render('UpaoFundoBundle:AbonoPlanta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AbonoPlanta entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:AbonoPlanta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AbonoPlanta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:AbonoPlanta:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing AbonoPlanta entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:AbonoPlanta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AbonoPlanta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:AbonoPlanta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a AbonoPlanta entity.
    *
    * @param AbonoPlanta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AbonoPlanta $entity)
    {
        $form = $this->createForm(new AbonoPlantaType(), $entity, array(
            'action' => $this->generateUrl('abonoplanta_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing AbonoPlanta entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:AbonoPlanta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AbonoPlanta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('abonoplanta_edit', array('id' => $id)));
        }

        return $this->render('UpaoFundoBundle:AbonoPlanta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a AbonoPlanta entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UpaoFundoBundle:AbonoPlanta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AbonoPlanta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('abonoplanta'));
    }

    /**
     * Creates a form to delete a AbonoPlanta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('abonoplanta_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
