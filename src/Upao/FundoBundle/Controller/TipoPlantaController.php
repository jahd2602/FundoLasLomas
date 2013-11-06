<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Upao\FundoBundle\Entity\TipoPlanta;
use Upao\FundoBundle\Form\TipoPlantaType;

/**
 * TipoPlanta controller.
 *
 */
class TipoPlantaController extends Controller
{

    /**
     * Lists all TipoPlanta entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();

        $entities = $em->getRepository('UpaoFundoBundle:TipoPlanta')
            ->createQueryBuilder('t')
            ->orderBy('t.nombre', 'ASC')
            ->getQuery()
            ->getResult();


        $data = array();

        if ($request->isXmlHttpRequest()) {

            foreach ($entities as $tipoPlanta) {
                $data['results'][] = array(
                    'nombre' => $tipoPlanta->getNombre(),
                    'descripcion' => $tipoPlanta->getDescripcion(),
                    'id' => $tipoPlanta->getId(),
                );
            }


            return new \Symfony\Component\HttpFoundation\Response(json_encode($data), 200, array(
                'Content-Type' => 'application/json'
            ));

        } else {
            return $this->render('UpaoFundoBundle:TipoPlanta:index.html.twig', array(
                'entities' => $entities,
            ));
        }

    }

    /**
     * Creates a new TipoPlanta entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TipoPlanta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tipoplanta_show', array('id' => $entity->getId())));
        }

        return $this->render('UpaoFundoBundle:TipoPlanta:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TipoPlanta entity.
     *
     * @param TipoPlanta $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TipoPlanta $entity)
    {
        $form = $this->createForm(new TipoPlantaType(), $entity, array(
            'action' => $this->generateUrl('tipoplanta_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TipoPlanta entity.
     *
     */
    public function newAction()
    {
        $entity = new TipoPlanta();
        $form = $this->createCreateForm($entity);

        return $this->render('UpaoFundoBundle:TipoPlanta:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoPlanta entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:TipoPlanta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoPlanta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:TipoPlanta:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing TipoPlanta entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:TipoPlanta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoPlanta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:TipoPlanta:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a TipoPlanta entity.
     *
     * @param TipoPlanta $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(TipoPlanta $entity)
    {
        $form = $this->createForm(new TipoPlantaType(), $entity, array(
            'action' => $this->generateUrl('tipoplanta_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing TipoPlanta entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:TipoPlanta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoPlanta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tipoplanta_edit', array('id' => $id)));
        }

        return $this->render('UpaoFundoBundle:TipoPlanta:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TipoPlanta entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UpaoFundoBundle:TipoPlanta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TipoPlanta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipoplanta'));
    }

    /**
     * Creates a form to delete a TipoPlanta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipoplanta_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
