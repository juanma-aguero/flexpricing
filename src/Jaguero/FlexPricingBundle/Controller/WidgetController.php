<?php

namespace Jaguero\FlexPricingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jaguero\FlexPricingBundle\Entity\Pricing;
use Jaguero\FlexPricingBundle\Form\Type\PricingType;

/**
 * Pricing widgets.
 */
class WidgetController extends Controller
{
    /**
     * Lists all Pricing entities.
     * @Method("GET")
     * @Template()
     */
    public function allEnabledAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('JagueroFlexPricingBundle:Pricing')->findAll();

        return array(
            'pricing_list' => $entities,
        );
    }

}
