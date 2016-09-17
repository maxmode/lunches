<?php

namespace AppBundle\Service;

use AppBundle\Entity\Employee;
use AppBundle\Entity\EmployeeLunchReport;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\Criteria;
use AppBundle\Entity\Lunch as LunchEntity;

/**
 * Service for Lunch entity
 */
class Lunch
{
    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * Lunch constructor.
     *
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param EmployeeLunchReport $report
     */
    public function findEmployeesForReport(EmployeeLunchReport $report)
    {
        $employees = $report->getEmployees();
        if ($employees instanceof ArrayCollection) {
            $employees = $employees->toArray();
        }
        if (!$employees) {
            $employees = $this->manager->getRepository(Employee::class)->findAll();
        }
        $report->setEmployees($employees);
    }

    /**
     * @param EmployeeLunchReport $report
     */
    public function findLunchesForReport(EmployeeLunchReport $report)
    {
        $lunchCriteria = new Criteria();
        if ($report->getStartDate() && $report->getStartDate()->setTime(0, 0)) {
            $lunchCriteria->andWhere($lunchCriteria->expr()->gte('occasionDate', $report->getStartDate()));
        }
        if ($report->getEndDate() && $report->getEndDate()->setTime(23, 59)) {
            $lunchCriteria->andWhere($lunchCriteria->expr()->lte('occasionDate', $report->getEndDate()));
        }
        $lunchCriteria->andWhere($lunchCriteria->expr()->in('employee', $report->getEmployees()));

        $lunches = $this->manager->getRepository(LunchEntity::class)->matching($lunchCriteria)->toArray();
        $report->setLunches($lunches);
    }


    /**
     * @param EmployeeLunchReport $report
     */
    public function processReportForEmployees(EmployeeLunchReport $report)
    {
        $lunchAmmountTotal = 0;
        /** @var LunchEntity $lunch */
        foreach ($report->getLunches() as $lunch) {
            $lunchAmmountTotal = intval($lunchAmmountTotal * 100 +  $lunch->getAmmount() * 100) / 100;
            $lunch->getEmployee()->setLunchAmount(
                intval($lunch->getEmployee()->getLunchAmount() * 100 + $lunch->getAmmount() * 100) / 100
            );
            $lunch->getEmployee()->setLunches(array_merge($lunch->getEmployee()->getLunches(), [$lunch]));
        }
        $report->setTotalLunchAmount($lunchAmmountTotal);
    }
}
