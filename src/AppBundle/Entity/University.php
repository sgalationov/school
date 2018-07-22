<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 19.06.2018
 * Time: 17:11
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class University
 * @package AppBundle\Entity
 * @ORM\Entity()
 */
class University
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ArrayCollection|Student[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Student", mappedBy="university")
     */
    protected $students;

    /**
     * @var ArrayCollection|Employee
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Employee", mappedBy="university")
     */
    protected $employees;

    /**
     * @var string|null
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Введите название университета")
     */
    protected $name;

    /**
     * @var string|null
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Введите адресс")
     */
    protected $address;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    protected $country;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    protected $city;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->employees = new ArrayCollection();
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
    public function setId(int $id)
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return Employee|ArrayCollection
     */
    public function getEmployees()
    {
        return $this->employees;
    }

    /**
     * @param Employee|ArrayCollection $employees
     */
    public function setEmployees($employees)
    {
        $this->employees = $employees;
    }

    /**
     * @return null|string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param null|string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return null|string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param null|string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return null|string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param null|string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    public function __toString()
    {
        return $this->getName(). ', ' . $this->getCountry() . ', ' . $this->getCity();
    }
}