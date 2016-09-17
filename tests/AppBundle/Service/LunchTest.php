<?php

namespace Tests\AppBundle\Service;

use AppBundle\Entity\Employee;
use AppBundle\Entity\EmployeeLunchReport;
use AppBundle\Service\Lunch;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Lunch as LunchEntity;

/**
 * Test for AppBundle\Service\Lunch
 */
class LunchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManager|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $manager;

    /**
     * @var Lunch
     */
    protected $service;

    protected function setUp()
    {
        $this->manager = $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()->getMock();

        $this->service = new Lunch($this->manager);
    }

    /**
     * @param EmployeeLunchReport $report
     * @param float               $expectedEmployeeA
     * @param float               $expectedEmployeeB
     * @param float               $expectedTotal
     *
     * @dataProvider processReportForEmployeesDataProvider
     */
    public function testProcessReportForEmployees($report, $expectedEmployeeA, $expectedEmployeeB, $expectedTotal)
    {
        $this->service->processReportForEmployees($report);

        /** @var Employee $employeeA */
        /** @var Employee $employeeB */
        list($employeeA, $employeeB) = array_values($report->getEmployees());
        $this->assertEquals($expectedEmployeeA, $employeeA->getLunchAmount());
        $this->assertEquals($expectedEmployeeB, $employeeB->getLunchAmount());
        $this->assertEquals($expectedTotal, $report->getTotalLunchAmount());
    }

    /**
     * @return array
     */
    public function processReportForEmployeesDataProvider()
    {
        $employeeA = new Employee();
        $employeeB = new Employee();

        $lunchA = new LunchEntity();
        $lunchB = new LunchEntity();
        $lunchC = new LunchEntity();

        $lunchA->setAmmount(.7);
        $lunchB->setAmmount(.1);
        $lunchC->setAmmount(1000000);

        $lunchA->setEmployee($employeeA);
        $lunchB->setEmployee($employeeA);
        $lunchC->setEmployee($employeeB);

        $report = new EmployeeLunchReport();
        $report->setLunches([$lunchA, $lunchB, $lunchC]);
        $report->setEmployees([$employeeA, $employeeB]);

        return [
            'case 1' => [
                'report' => $report,
                'expectedEmployeeA' => 0.8,
                'expectedEmployeeB' => 1000000,
                'expectedTotal'     => 1000000.8,
            ],
        ];
    }
}
