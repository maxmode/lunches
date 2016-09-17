<?php

namespace AppBundle\Entity\Lunch;

use AppBundle\Entity\Lunch;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * LunchOccasion
 *
 * @ORM\Table(name="lunch_receipt")
 * @ORM\Entity()
 */
class Receipt
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=2097150) //20MB - maximum encoded file size
     *
     * @ORM\Column(name="src", type="text")
     *
     * @JMS\Expose()
     * @JMS\SerializedName("src")
     * @JMS\Groups({"lunch_receipt_src"})
     */
    private $src;

    /**
     * @var Lunch
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Lunch", mappedBy="receipt")
     */
    private $lunch;

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
     * Set receipt
     *
     * @param string $src
     *
     * @return Receipt
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get receipt
     *
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @return Lunch
     */
    public function getLunch()
    {
        return $this->lunch;
    }

    /**
     * @param Lunch $lunch
     */
    public function setLunch($lunch)
    {
        $this->lunch = $lunch;
    }
}
