<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation as JMS;

/**
 * EmployeeLunchReport
 */
class EmployeeLunchReport
{

    /**
     * @var \DateTime
     *
     * @JMS\Expose()
     * @JMS\SerializedName("startDate")
     * @JMS\Groups({"employee_lunch_report"})
     * @JMS\Type("DateTime<'Y-m-d'>")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @JMS\Expose()
     * @JMS\SerializedName("endDate")
     * @JMS\Groups({"employee_lunch_report"})
     * @JMS\Type("DateTime<'Y-m-d'>")
     */
    private $endDate;

    /**
     * @var float
     *
     * @JMS\Expose()
     * @JMS\SerializedName("totalLunchAmount")
     * @JMS\Groups({"employee_lunch_report"})
     */
    private $totalLunchAmount = 0;

    /**
     * @var Employee[]
     *
     * @JMS\Expose()
     * @JMS\SerializedName("employees")
     * @JMS\Groups({"employee_lunch_report_grouped"})
     */
    private $employees = [];

    /**
     * @var Lunch[]
     *
     * @JMS\Expose()
     * @JMS\SerializedName("lunches")
     * @JMS\Groups({"employee_lunch_report_flat"})
     */
    private $lunches = [];

    /**
     * @return float
     */
    public function getTotalLunchAmount()
    {
        return $this->totalLunchAmount;
    }

    /**
     * @param float $totalLunchAmount
     */
    public function setTotalLunchAmount($totalLunchAmount)
    {
        $this->totalLunchAmount = $totalLunchAmount;
    }

    /**
     * @return Employee[]
     */
    public function getEmployees()
    {
        return $this->employees;
    }

    /**
     * @param Employee[] $employees
     */
    public function setEmployees($employees)
    {
        $this->employees = $employees;
    }

    /**
     * @return Lunch[]
     */
    public function getLunches()
    {
        return $this->lunches;
    }

    /**
     * @param Lunch[] $lunches
     */
    public function setLunches($lunches)
    {
        $this->lunches = $lunches;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }
}
