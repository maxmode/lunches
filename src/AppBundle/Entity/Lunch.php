<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Lunch\Receipt;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * LunchOccasion
 *
 * @ORM\Table(name="lunch")
 * @ORM\Entity()
 */
class Lunch
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
     * @JMS\Groups({"lunch_details"})
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="occasionDate", type="datetime", nullable=true)
     *
     * @JMS\Expose()
     * @JMS\SerializedName("occasionDate")
     * @JMS\Groups({"lunch_details"})
     */
    private $occasionDate;

    /**
     * @var string
     *
     * @Assert\Length(max=255)
     *
     * @ORM\Column(name="placeName", type="string", length=255, nullable=true)
     *
     * @JMS\Expose()
     * @JMS\SerializedName("place")
     * @JMS\Groups({"lunch_details"})
     */
    private $placeName;

    /**
     * @var string
     *
     * @Assert\Length(max=255)
     *
     * @ORM\Column(name="placeAddress", type="string", length=255, nullable=true)
     *
     * @JMS\Expose()
     * @JMS\SerializedName("address")
     * @JMS\Groups({"lunch_details"})
     */
    private $placeAddress;

    /**
     * @var float
     *
     * @Assert\Range(min=0, max=1000000)
     *
     * @ORM\Column(name="ammount", type="decimal", precision=6, scale=2, nullable=true)
     *
     * @JMS\Expose()
     * @JMS\SerializedName("ammount")
     * @JMS\Groups({"lunch_details"})
     */
    private $ammount;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=500)
     *
     * @ORM\Column(name="description", type="text")
     *
     * @JMS\Expose()
     * @JMS\SerializedName("description")
     * @JMS\Groups({"lunch_details"})
     */
    private $description;

    /**
     * @var Receipt
     *
     * @Assert\NotBlank()
     *
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Lunch\Receipt")
     * @ORM\JoinColumn(name="receipt", referencedColumnName="id")
     *
     * @JMS\Expose()
     * @JMS\SerializedName("receipt")
     * @JMS\Groups({"lunch_receipt_src"})
     */
    private $receipt;

    /**
     * @var Employee
     *
     * @Assert\NotBlank()
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Employee")
     * @ORM\JoinColumn(name="employee", referencedColumnName="id")
     *
     * @JMS\Expose()
     * @JMS\SerializedName("employee")
     * @JMS\Groups({"lunch_employee"})
     */
    private $employee;

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
     * Set occasionDate
     *
     * @param \DateTime $occasionDate
     *
     * @return Lunch
     */
    public function setOccasionDate($occasionDate)
    {
        $this->occasionDate = $occasionDate;

        return $this;
    }

    /**
     * Get occasionDate
     *
     * @return \DateTime
     */
    public function getOccasionDate()
    {
        return $this->occasionDate;
    }

    /**
     * Set placeName
     *
     * @param string $placeName
     *
     * @return Lunch
     */
    public function setPlaceName($placeName)
    {
        $this->placeName = $placeName;

        return $this;
    }

    /**
     * Get placeName
     *
     * @return string
     */
    public function getPlaceName()
    {
        return $this->placeName;
    }

    /**
     * Set placeAddress
     *
     * @param string $placeAddress
     *
     * @return Lunch
     */
    public function setPlaceAddress($placeAddress)
    {
        $this->placeAddress = $placeAddress;

        return $this;
    }

    /**
     * Get placeAddress
     *
     * @return string
     */
    public function getPlaceAddress()
    {
        return $this->placeAddress;
    }

    /**
     * Set ammount
     *
     * @param float $ammount
     *
     * @return Lunch
     */
    public function setAmmount($ammount)
    {
        $this->ammount = $ammount;

        return $this;
    }

    /**
     * Get ammount
     *
     * @return float
     */
    public function getAmmount()
    {
        return $this->ammount;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Lunch
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Receipt
     */
    public function getReceipt()
    {
        return $this->receipt;
    }

    /**
     * @param Receipt $receipt
     */
    public function setReceipt($receipt)
    {
        $this->receipt = $receipt;
    }

    /**
     * Set employee
     *
     * @param \AppBundle\Entity\Employee $employee
     *
     * @return Lunch
     */
    public function setEmployee(\AppBundle\Entity\Employee $employee = null)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return \AppBundle\Entity\Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }
}
