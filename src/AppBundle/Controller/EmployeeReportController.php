<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Entity\EmployeeLunchReport;
use AppBundle\Form\EmployeeLunchReportType;
use AppBundle\Service\Lunch;
use FOS\RestBundle\View\View as ResponseView;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LunchController
 * @package AppBundle\Controller
 */
class EmployeeReportController extends Controller implements ClassResourceInterface
{
    /**
     * Get a list of all these items, together with totals per employee
     *
     * @View()
     * @ApiDoc(
     *     section="Lunch Reports",
     *     parameters={
     *         {"name"="startDate", "dataType"="string", "format"="2012-05-30 14:47", "required"=false,
     *             "description"="Start day of report"},
     *         {"name"="endDate", "dataType"="string", "format"="2012-05-30 14:47", "required"=false,
     *             "description"="End day of report"},
     *         {"name"="employees[0]", "dataType"="string", "format"="html form checkbox array", "required"=false,
     *             "description"="Specify one or several Employee Id(s) to filter."},
     *         {"name"="expand[0]", "dataType"="string", "format"="html form checkbox array", "required"=false,
     *             "description"="Possible values: 'employee_lunch_report_grouped', 'employee_lunch_report_flat',
                        'lunch_receipt_src'."}
     *     }
     * )
     *
     * @return ResponseView|FormInterface
     */
    public function lunchesAction(Request $request)
    {
        /** @var FormFactory $formFactory */
        $formFactory = $this->get('form.factory');
        $form = $formFactory->createNamedBuilder(null, EmployeeLunchReportType::class, null, ['method' => 'GET'])
            ->getForm();
        $form->submit($request->query->all());
        if ($form->isValid()) {
            /** @var EmployeeLunchReport $report */
            $report = $form->getData();

            /** @var Lunch $service */
            $service = $this->get('app.service.lunch');
            $service->findEmployeesForReport($report);
            $service->findLunchesForReport($report);
            $service->processReportForEmployees($report);

            $groups = array_merge($form->get('expand')->getData(),
                ['employee_list', 'employee_lunch_report', 'lunch_details']);
            $view = new ResponseView($report);
            $context = new Context();
            $context->setGroups($groups);
            $view->setContext($context);

            return $view;
        }

        return $form;
    }
}
