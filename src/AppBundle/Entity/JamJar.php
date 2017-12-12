<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity for a jar of jam
 *
 * @ORM\Entity
 */
class JamJar
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\JamType")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var \AppBundle\Entity\JamType
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Year")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var \AppBundle\Entity\Year
     */
    protected $year;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    protected $comment;
    /**
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \AppBundle\Entity\JamType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return \AppBundle\Entity\Year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param \AppBundle\Entity\JamType $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param \AppBundle\Entity\Year $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function __toString()
    {
        if ($this->getType() && $this->getYear()) {
            return sprintf('A jar of %s from %s', $this->getType()->getName(), $this->getYear()->getName());
        }

        return '';
    }
}

