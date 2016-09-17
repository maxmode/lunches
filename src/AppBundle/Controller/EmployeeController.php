<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Form\EmployeeType;
use AppBundle\Entity\Employee;
use FOS\RestBundle\View\View as ResponseView;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EmployeeController
 * @package AppBundle\Controller
 */
class EmployeeController extends Controller implements ClassResourceInterface
{
    /**
     * Get list of all employees
     *
     * @View(serializerGroups={"employee_list"})
     * @ApiDoc(section="Employee")
     *
     * @return Employee[]
     */
    public function cgetAction()
    {
        return $this->getDoctrine()->getRepository(Employee::class)->findAll();
    }

    /**
     * Add new employee to system
     *
     * @param Request $request
     *
     * @View(serializerGroups={"employee_list"})
     * @ApiDoc(
     *     section="Employee",
     *     parameters={
     *         {"name"="name", "dataType"="string", "required"=true, "description"="Employee name"}
     *     })
     *
     * @return ResponseView|FormInterface
     */
    public function postAction(Request $request)
    {
        /** @var FormFactory $formFactory */
        $formFactory = $this->get('form.factory');
        $form = $formFactory->createNamedBuilder(null, EmployeeType::class)->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $employee = $form->getData();
            $this->getDoctrine()->getManager()->persist($employee);
            $this->getDoctrine()->getManager()->flush();

            return new ResponseView($employee, Response::HTTP_CREATED);
        }

        return $form;
    }
}
