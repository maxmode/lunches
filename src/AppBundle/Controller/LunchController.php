<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\View\View as ResponseView;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Lunch;
use AppBundle\Form\LunchType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactory;

/**
 * Class LunchController
 * @package AppBundle\Controller
 */
class LunchController extends Controller implements ClassResourceInterface
{
    /**
     * Get details for the Lunch occasion
     *
     * @View(serializerGroups={"lunch_details", "lunch_receipt_src", "employee_list", "lunch_employee"})
     * @ParamConverter("lunch", class="AppBundle:Lunch")
     * @ApiDoc(section="Lunch Occasion")
     *
     * @return Lunch[]
     */
    public function getAction($lunch)
    {
        return $lunch;
    }

    /**
     * Post new Lunch occasion
     *
     * @param Request $request
     *
     * @View(serializerGroups={"lunch_details", "lunch_receipt_src", "employee_list", "lunch_employee"})
     * @ApiDoc(
     *     section="Lunch Occasion",
     *     parameters={
     *         {"name"="employee", "dataType"="string", "required"=true, "description"="Employee ID"},
     *         {"name"="occasionDate", "dataType"="string", "format"="2012-05-30 14:47", "required"=false,
     *             "description"="Date/Time of occasion"},
     *         {"name"="placeName", "dataType"="string", "required"=false, "description"="Place name"},
     *         {"name"="placeAddress", "dataType"="string", "required"=false, "description"="Place Address"},
     *         {"name"="ammount", "dataType"="string", "required"=false, "description"="Receipt sum"},
     *         {"name"="description", "dataType"="textarea", "required"=true,
     *             "description"="Description of the occasion"},
     *         {"name"="receipt[src]", "dataType"="textarea", "required"=true,
     *             "description"="Picture of receipt, base-64 encoded, as a value of img src attribute"}
     *     })
     *
     * @return ResponseView|FormInterface
     */
    public function postAction(Request $request)
    {
        /** @var FormFactory $formFactory */
        $formFactory = $this->get('form.factory');
        $form = $formFactory->createNamedBuilder(null, LunchType::class)->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            /** @var Lunch $entity */
            $entity = $form->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($entity);
            $manager->persist($entity->getReceipt());
            $manager->flush();

            return new ResponseView($entity, Response::HTTP_CREATED);
        }

        return $form;
    }
}
