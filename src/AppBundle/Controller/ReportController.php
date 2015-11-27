<?php

namespace AppBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Sale;
use AppBundle\Form\SaleType;
use AppBundle\Form\SearchReportType;

/**
 * Sale controller.
 *
 * @Route("/report")
 */
class ReportController extends Controller
{

    /**
     * Lists all Sale entities.
     *
     * @Route("/", name="report")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Sale();
        $form = $this->createForm(new SearchReportType(), $entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('AppBundle:Sale')
                ->getReport($form);
        } else {
            $entities = $em->getRepository('AppBundle:Sale')->dailyReport();
        }

        return array(
            'entities' => $entities,
             "form" => $form->createView(),
        );
    }

}
