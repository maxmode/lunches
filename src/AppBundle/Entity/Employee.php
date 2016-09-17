<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Employee
 *
 * @ORM\Table(name="employee")
 * @ORM\Entity()
 */
class Employee
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose()
     * @JMS\SerializedName("id")
     * @JMS\Groups({"employee_list"})
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     *
     * @JMS\Expose()
     * @JMS\SerializedName("name")
     * @JMS\Groups({"employee_list"})
     */
    private $name;

    /**
     * @var Lunch[]
     *
     * @JMS\Expose()
     * @JMS\SerializedName("lunches")
     * @JMS\Groups({"employee_lunch_report_grouped"})
     */
    private $lunches = [];

    /**
     * @var float
     *
     * @JMS\Expose()
     * @JMS\SerializedName("lunchAmount")
     * @JMS\Groups({"employee_lunch_report_grouped"})
     */
    private $lunchAmount = 0;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Employee
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @return float
     */
    public function getLunchAmount()
    {
        return $this->lunchAmount;
    }

    /**
     * @param string $lunchAmount
     */
    public function setLunchAmount($lunchAmount)
    {
        $this->lunchAmount = $lunchAmount;
    }
}
