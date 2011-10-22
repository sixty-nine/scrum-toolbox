<?php

namespace Sitronnier\SmBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sitronnier\SmBoxBundle\Entity\Day;
use Sitronnier\SmBoxBundle\Form\DayType;

/**
 * Day controller.
 *
 */
class DayController extends Controller
{
    /**
     * Lists all Day entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('SitronnierSmBoxBundle:Day')->findAll();

        return $this->render('SitronnierSmBoxBundle:Day:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Day entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SitronnierSmBoxBundle:Day')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Day entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SitronnierSmBoxBundle:Day:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Day entity.
     *
     */
    public function newAction()
    {
        $entity = new Day();
        $form   = $this->createForm(new DayType(), $entity);

        return $this->render('SitronnierSmBoxBundle:Day:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Day entity.
     *
     */
    public function createAction()
    {
        $entity  = new Day();
        $request = $this->getRequest();
        $form    = $this->createForm(new DayType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('day_show', array('id' => $entity->getId())));
            
        }

        return $this->render('SitronnierSmBoxBundle:Day:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Day entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SitronnierSmBoxBundle:Day')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Day entity.');
        }

        $editForm = $this->createForm(new DayType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SitronnierSmBoxBundle:Day:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Day entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SitronnierSmBoxBundle:Day')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Day entity.');
        }

        $editForm   = $this->createForm(new DayType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('day_edit', array('id' => $id)));
        }

        return $this->render('SitronnierSmBoxBundle:Day:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Day entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('SitronnierSmBoxBundle:Day')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Day entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('day'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
