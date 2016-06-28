<?php

namespace Jaguero\FlexPricingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jaguero\FlexPricingBundle\Entity\Pricing;
use Jaguero\FlexPricingBundle\Form\Type\PricingType;
use Doctrine\ORM\QueryBuilder;

/**
 * Pricing controller.
 *
 * @Route("/admin/pricing")
 */
class AdminPricingController extends Controller
{
    /**
     * Lists all Pricing entities.
     *
     * @Route("/", name="admin_pricing")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('JagueroFlexPricingBundle:Pricing')->createQueryBuilder('p');
        $paginator = $this->get('knp_paginator')->paginate($qb, $request->query->get('page', 1), 20);
        return array(
            'paginator' => $paginator,
        );
    }

    /**
     * Finds and displays a Pricing entity.
     *
     * @Route("/{id}/show", name="admin_pricing_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Pricing $pricing)
    {
        $editForm = $this->createForm(new PricingType(), $pricing, array(
            'action' => $this->generateUrl('admin_pricing_update', array('id' => $pricing->getid())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($pricing->getId(), 'admin_pricing_delete');

        return array(

            'pricing' => $pricing, 'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),

        );
    }

    /**
     * Displays a form to create a new Pricing entity.
     *
     * @Route("/new", name="admin_pricing_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $pricing = new Pricing();
        $form = $this->createForm(new PricingType(), $pricing);

        return array(
            'pricing' => $pricing,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Pricing entity.
     *
     * @Route("/create", name="admin_pricing_create")
     * @Method("POST")
     * @Template("JagueroFlexPricingBundle:Pricing:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $pricing = new Pricing();
        $form = $this->createForm(new PricingType(), $pricing);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pricing);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_pricing_show', array('id' => $pricing->getId())));
        }

        return array(
            'pricing' => $pricing,
            'form' => $form->createView(),
        );
    }

    /**
     * Edits an existing Pricing entity.
     *
     * @Route("/{id}/update", name="admin_pricing_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("JagueroFlexPricingBundle:Pricing:edit.html.twig")
     */
    public function updateAction(Pricing $pricing, Request $request)
    {
        $editForm = $this->createForm(new PricingType(), $pricing, array(
            'action' => $this->generateUrl('admin_pricing_update', array('id' => $pricing->getid())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_pricing_show', array('id' => $pricing->getId())));
        }
        $deleteForm = $this->createDeleteForm($pricing->getId(), 'admin_pricing_delete');

        return array(
            'pricing' => $pricing,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Pricing entity.
     *
     * @Route("/{id}/delete", name="admin_pricing_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Pricing $pricing, Request $request)
    {
        $form = $this->createDeleteForm($pricing->getId(), 'admin_pricing_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pricing);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_pricing'));
    }

    /**
     * Create Delete form
     *
     * @param integer $id
     * @param string $route
     * @return \Symfony\Component\Form\Form
     */
    protected function createDeleteForm($id, $route)
    {
        return $this->createFormBuilder(null, array('attr' => array('id' => 'delete')))
            ->setAction($this->generateUrl($route, array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm();
    }

}
