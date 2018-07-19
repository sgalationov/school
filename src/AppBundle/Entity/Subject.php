<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 21.06.2018
 * Time: 15:50
 */

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Subject
 * @package AppBundle\Entity
 * @ORM\Entity()
 */
class Subject
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", options={"default":"название"})
     */
    protected $name;

    /**
     * @var ArrayCollection|Student[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Student")
     */
    protected $students;

    /**
     * @var ArrayCollection|Employee[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Employee")
     */
    protected $lecturers;

    /**
     * @var integer|null
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank(message="Введите количество часов")
     */
    protected $countHours;

    /**
     * @var ArrayCollection|Lecture[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Lecture", cascade={"persist"}, mappedBy="subject")
     */
    protected $lectures;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->lecturers = new ArrayCollection();
        $this->lectures = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Student[]|ArrayCollection
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * @param Student[]|ArrayCollection $students
     */
    public function setStudents($students)
    {
        $this->students = $students;
    }

    /**
     * @return Employee[]|ArrayCollection
     */
    public function getLecturers()
    {
        /*$criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()->)*/
        return $this->lecturers;
    }

    /**
     * @param Employee[]|ArrayCollection $lecturers
     */
    public function setLecturers($lecturers)
    {
        $this->lecturers = $lecturers;
    }

    /**
     * @return int|null
     */
    public function getCountHours()
    {
        return $this->countHours;
    }

    /**
     * @param int|null $countHours
     */
    public function setCountHours($countHours)
    {
        $this->countHours = $countHours;
    }

    public function __toString()
    {
        return $this->countHours.', '.$this->getCountHours();
    }

    /**
     * @return Lecture[]|ArrayCollection
     */
    public function getLectures()
    {
        return $this->lectures;
    }

    /**
     * @param Lecture $lecture
     */
    public function addLecture(Lecture $lecture)
    {
        if (!$this->lectures->contains($lecture)) {
            $this->lectures->add($lecture);
        }
    }

    /**
     * @param Lecture $lecture
     */
    public function removeLecture(Lecture $lecture)
    {
        if ($this->lectures->contains($lecture)) {
            $this->lectures->remove($lecture);
        }
        //$this->lectures->removeElement($lecture);
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
