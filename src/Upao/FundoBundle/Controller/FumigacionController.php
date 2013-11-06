<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Upao\FundoBundle\Entity\Fumigacion;
use Upao\FundoBundle\Form\FumigacionType;
use Upao\FundoBundle\Util\Util;

/**
 * Fumigacion controller.
 *
 */
class FumigacionController extends Controller
{

    /**
     * Lists all Fumigacion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();

        $data = array();

        if ($request->isXmlHttpRequest()) {

            $entities = $em->getRepository('UpaoFundoBundle:Fumigacion')
                ->createQueryBuilder('f')
                ->orderBy('f.fecha', 'DESC')
                ->getQuery()
                ->getResult();

            foreach ($entities as $fumigacion) {
                $url = $this->generateUrl('fumigacion_show', array('id' => $fumigacion->getId()));

                $data['results'][] = array(
                    'fecha' => $fumigacion->getFecha()->format('Y-m-d'),
                    'empleado' => $fumigacion->getIdEmpleado()->getNombre(),
                    'descripcion' => Util::truncate($fumigacion->getDescripcion(),50),
                    'observacion' => Util::truncate($fumigacion->getObservacion(),50),
                    'id' => '<a href="'.$url.'" class="btn btn-info">Detalle</a>',
                );
            }


            return new \Symfony\Component\HttpFoundation\Response(json_encode($data), 200, array(
                'Content-Type' => 'application/json'
            ));

        } else {
            return $this->render('UpaoFundoBundle:Fumigacion:index.html.twig');
        }

    }
    /**
     * Creates a new Fumigacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Fumigacion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fumigacion_show', array('id' => $entity->getId())));
        }

        return $this->render('UpaoFundoBundle:Fumigacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Fumigacion entity.
    *
    * @param Fumigacion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Fumigacion $entity)
    {
        $form = $this->createForm(new FumigacionType(), $entity, array(
            'action' => $this->generateUrl('fumigacion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Fumigacion entity.
     *
     */
    public function newAction()
    {
        $entity = new Fumigacion();
        $form   = $this->createCreateForm($entity);

        return $this->render('UpaoFundoBundle:Fumigacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Fumigacion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Fumigacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fumigacion entity.');
        }


        $plantas = array();
        $fumigacionesPlanta = $em->getRepository('UpaoFundoBundle:FumigacionPlanta')
            ->findBy(
                array(
                    'idFumigacion' => $entity->getId(),
                ));

        foreach ($fumigacionesPlanta as $fumigacionPlanta) {
            $plantas[] = $fumigacionPlanta->getIdPlanta();
        }


        return $this->render('UpaoFundoBundle:Fumigacion:show.html.twig', array(
            'entity'      => $entity,
            'plantas' => $plantas,       ));

    }

    /**
     * Displays a form to edit an existing Fumigacion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Fumigacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fumigacion entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UpaoFundoBundle:Fumigacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Fumigacion entity.
    *
    * @param Fumigacion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Fumigacion $entity)
    {
        $form = $this->createForm(new FumigacionType(), $entity, array(
            'action' => $this->generateUrl('fumigacion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Fumigacion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UpaoFundoBundle:Fumigacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fumigacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('fumigacion_edit', array('id' => $id)));
        }

        return $this->render('UpaoFundoBundle:Fumigacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Fumigacion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UpaoFundoBundle:Fumigacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Fumigacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('fumigacion'));
    }

    /**
     * Creates a form to delete a Fumigacion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fumigacion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
