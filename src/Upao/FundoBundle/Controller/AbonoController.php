<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Upao\FundoBundle\Entity\Abono;
use Upao\FundoBundle\Form\AbonoType;
use Upao\FundoBundle\Util\Util;

/**
 * Abono controller.
 *
 */
class AbonoController extends Controller
{

    /**
     * Lists all Abono entities.
     *
     */
    public function indexAction()
    {

        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();


        $data = array();

        if ($request->isXmlHttpRequest()) {

            $entities = $em->getRepository('UpaoFundoBundle:Abono')
                ->createQueryBuilder('a')
                ->orderBy('a.fecha', 'DESC')
                ->getQuery()
                ->getResult();

            foreach ($entities as $abono) {
                $url = $this->generateUrl('abono_show', array('id' => $abono->getId()));

                $data['results'][] = array(
                    'fecha' => $abono->getFecha()->format('Y-m-d'),
                    'empleado' => $abono->getIdEmpleado()->getNombre(),
                    'descripcion' => Util::truncate($abono->getDescripcion(), 50),
                    'observacion' => Util::truncate($abono->getObservacion(), 50),
                    'id' => '<a href="'.$url.'" class="btn btn-info">Detalle</a>',
                );
            }


            return new Response(json_encode($data), 200, array(
                'Content-Type' => 'application/json'
            ));

        } else {

            return $this->render('UpaoFundoBundle:Abono:index.html.twig', array());
        }

    }

    /**
     * Creates a new Abono entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Abono();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('abono_show', array('id' => $entity->getId())));
        }

        return $this->render('UpaoFundoBundle:Abono:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Abono entity.
     *
     * @param Abono $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Abono $entity)
    {
        $form = $this->createForm(new AbonoType(), $entity, array(
            'action' => $this->generateUrl('abono_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Abono entity.
     *
     */
    public function newAction()
    {
        $entity = new Abono();
        $form = $this->createCreateForm($entity);

        return $this->render('UpaoFundoBundle:Abono:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Abono entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Abono')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Abono entity.');
        }

        $plantas = array();
        $abonoPlantas = $em->getRepository('UpaoFundoBundle:AbonoPlanta')
            ->findBy(
                array(
                    'idAbono' => $entity->getId(),
                ));

        foreach ($abonoPlantas as $abonoPlanta) {
            $plantas[] = $abonoPlanta->getIdPlanta();
        }


        return $this->render('UpaoFundoBundle:Abono:show.html.twig', array(
            'entity' => $entity,
            'plantas' => $plantas,

        ));
    }

    /**
     * Displays a form to edit an existing Abono entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Abono')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Abono entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Abono:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Abono entity.
     *
     * @param Abono $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Abono $entity)
    {
        $form = $this->createForm(new AbonoType(), $entity, array(
            'action' => $this->generateUrl('abono_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Abono entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Abono')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Abono entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('abono_edit', array('id' => $id)));
        }

        return $this->render('UpaoFundoBundle:Abono:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Abono entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UpaoFundoBundle:Abono')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Abono entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('abono'));
    }

    /**
     * Creates a form to delete a Abono entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('abono_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
