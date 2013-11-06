<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Upao\FundoBundle\Entity\Problema;
use Upao\FundoBundle\Form\ProblemaType;
use Upao\FundoBundle\Util\Util;

/**
 * Problema controller.
 *
 */
class ProblemaController extends Controller
{

    /**
     * Lists all Problema entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();


        $data = array();

        if ($request->isXmlHttpRequest()) {
            $entities = $em->getRepository('UpaoFundoBundle:Problema')
                ->createQueryBuilder('p')
                ->orderBy('p.fecha', 'DESC')
                ->getQuery()
                ->getResult();

            foreach ($entities as $problema) {

                $url = $this->generateUrl('problema_show', array('id' => $problema->getId()));


                $data['results'][] = array(
                    'fecha' => $problema->getFecha()->format('Y-m-d'),
                    'descripcion' => Util::truncate($problema->getDescripcion(), 50),
                    'planta' => $problema->getIdPlanta()->getCodigo(),
                    'resuelto' => $problema->getResuelto() ? 'SI' : 'NO',
                    'id' => '<a href="' . $url . '" class="btn btn-modal btn-danger">Detalle</a>',
                );
            }


            return new \Symfony\Component\HttpFoundation\Response(json_encode($data), 200, array(
                'Content-Type' => 'application/json'
            ));

        } else {
            return $this->render('UpaoFundoBundle:Problema:index.html.twig');
        }


    }

    /**
     * Creates a new Problema entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Problema();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('problema_show', array('id' => $entity->getId())));
        }

        return $this->render('UpaoFundoBundle:Problema:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Problema entity.
     *
     * @param Problema $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Problema $entity)
    {
        $form = $this->createForm(new ProblemaType(), $entity, array(
            'action' => $this->generateUrl('problema_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Problema entity.
     *
     */
    public function newAction()
    {
        $entity = new Problema();
        $form = $this->createCreateForm($entity);

        return $this->render('UpaoFundoBundle:Problema:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Problema entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Problema')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Problema entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Problema:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),));
    }


    public function resolverAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $id = $request->get('id');

        $entity = $em->getRepository('UpaoFundoBundle:Problema')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Problema entity.');
        }

        $entity->setResuelto(true);

        $data = array();


        try {


            $em->persist($entity);
            $em->flush();


            $data = array(
                'status' => 200,
                'success' => true,
                'message' => 'Se resolvio el problema correctamente'

            );

        } catch (Exception $e) {


            $data = array(
                'status' => 500,
                'error' => true,
                'message' => 'Error interno'

            );
        }



        if ($request->isXmlHttpRequest()) {


            return new \Symfony\Component\HttpFoundation\Response(json_encode($data), 200, array(
                'Content-Type' => 'application/json'
            ));

        } else {
            return $this->redirect($this->generateUrl('problema'));
        }
    }

    /**
     * Displays a form to edit an existing Problema entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Problema')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Problema entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Problema:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Problema entity.
     *
     * @param Problema $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Problema $entity)
    {
        $form = $this->createForm(new ProblemaType(), $entity, array(
            'action' => $this->generateUrl('problema_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Problema entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Problema')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Problema entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('problema_edit', array('id' => $id)));
        }

        return $this->render('UpaoFundoBundle:Problema:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Problema entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UpaoFundoBundle:Problema')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Problema entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('problema'));
    }

    /**
     * Creates a form to delete a Problema entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('problema_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
