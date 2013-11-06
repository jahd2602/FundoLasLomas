<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Upao\FundoBundle\Entity\Riego;
use Upao\FundoBundle\Form\RiegoType;
use Upao\FundoBundle\Util\Util;

/**
 * Riego controller.
 *
 */
class RiegoController extends Controller
{

    /**
     * Lists all Riego entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request=$this->getRequest();

        $entities = $em->getRepository('UpaoFundoBundle:Riego')
            ->createQueryBuilder('r')
            ->orderBy('r.fecha', 'DESC')
            ->getQuery()
            ->getResult();

        $data = array();

        if ($request->isXmlHttpRequest()) {

            foreach ($entities as $riego) {
                $data['results'][] = array(
                    'fecha' => $riego->getFecha()->format('Y-m-d'),
                    'empleado' => $riego->getIdEmpleado()->getNombre(),
                    'observacion' => Util::truncate($riego->getObservacion(),50),
                    'id' => $riego->getId(),
                );
            }


            return new \Symfony\Component\HttpFoundation\Response(json_encode($data), 200, array(
                'Content-Type' => 'application/json'
            ));

        } else {
            return $this->render('UpaoFundoBundle:Riego:index.html.twig', array(
                'entities' => $entities,
            ));
        }

    }
    /**
     * Creates a new Riego entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Riego();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('riego_show', array('id' => $entity->getId())));
        }

        return $this->render('UpaoFundoBundle:Riego:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Riego entity.
    *
    * @param Riego $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Riego $entity)
    {
        $form = $this->createForm(new RiegoType(), $entity, array(
            'action' => $this->generateUrl('riego_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Riego entity.
     *
     */
    public function newAction()
    {
        $entity = new Riego();
        $form   = $this->createCreateForm($entity);

        return $this->render('UpaoFundoBundle:Riego:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Riego entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Riego')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Riego entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Riego:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Riego entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Riego')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Riego entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Riego:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Riego entity.
    *
    * @param Riego $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Riego $entity)
    {
        $form = $this->createForm(new RiegoType(), $entity, array(
            'action' => $this->generateUrl('riego_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Riego entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Riego')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Riego entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('riego_edit', array('id' => $id)));
        }

        return $this->render('UpaoFundoBundle:Riego:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Riego entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UpaoFundoBundle:Riego')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Riego entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('riego'));
    }

    /**
     * Creates a form to delete a Riego entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('riego_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
