<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Upao\FundoBundle\Entity\Cosecha;
use Upao\FundoBundle\Form\CosechaType;
use Upao\FundoBundle\Util\Util;

/**
 * Cosecha controller.
 *
 */
class CosechaController extends Controller
{

    /**
     * Lists all Cosecha entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $entities = $em->getRepository('UpaoFundoBundle:Cosecha')
            ->createQueryBuilder('c')
            ->orderBy('c.fecha', 'DESC')
            ->getQuery()
            ->getResult();


        $data = array();

        if ($request->isXmlHttpRequest()) {

            foreach ($entities as $cosecha) {
                $data['results'][] = array(
                    'fecha' => $cosecha->getFecha()->format('Y-m-d'),
                    'total_kilos' => $cosecha->getTotalKilos(),
                    'kilos_disponibles' => $cosecha->getKilosDisponibles(),
                    'observaciones' => Util::truncate($cosecha->getObservaciones(), 50),
                    'id' => $cosecha->getId(),
                );
            }


            return new \Symfony\Component\HttpFoundation\Response(json_encode($data), 200, array(
                'Content-Type' => 'application/json'
            ));

        } else {
            return $this->render('UpaoFundoBundle:Cosecha:index.html.twig', array(
                'entities' => $entities,
            ));
        }
    }

    /**
     * Creates a new Cosecha entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Cosecha();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cosecha_show', array('id' => $entity->getId())));
        }

        return $this->render('UpaoFundoBundle:Cosecha:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Cosecha entity.
     *
     * @param Cosecha $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cosecha $entity)
    {
        $form = $this->createForm(new CosechaType(), $entity, array(
            'action' => $this->generateUrl('cosecha_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Cosecha entity.
     *
     */
    public function newAction()
    {
        $entity = new Cosecha();
        $form = $this->createCreateForm($entity);

        return $this->render('UpaoFundoBundle:Cosecha:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cosecha entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Cosecha')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cosecha entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Cosecha:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing Cosecha entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Cosecha')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cosecha entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Cosecha:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Cosecha entity.
     *
     * @param Cosecha $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Cosecha $entity)
    {
        $form = $this->createForm(new CosechaType(), $entity, array(
            'action' => $this->generateUrl('cosecha_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Cosecha entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Cosecha')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cosecha entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cosecha_edit', array('id' => $id)));
        }

        return $this->render('UpaoFundoBundle:Cosecha:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Cosecha entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UpaoFundoBundle:Cosecha')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cosecha entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cosecha'));
    }

    /**
     * Creates a form to delete a Cosecha entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cosecha_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
