<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeacherRepository::class)]
class Teacher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'date')]
    private $birthday;

    #[ORM\Column(type: 'float')]
    private $salary;

    #[ORM\Column(type: 'string', length: 255)]
    private $avatar;

    #[ORM\ManyToMany(targetEntity: ClassRoom::class, inversedBy: 'teachers')]
    private $classroom;

    #[ORM\ManyToMany(targetEntity: Course::class, inversedBy: 'teachers')]
    private $course;

    public function __construct()
    {
        $this->classroom = new ArrayCollection();
        $this->course = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar( $avatar): self
    { 
        if ($avatar != null) {
        $this->avatar = $avatar;
        }
        return $this;
    }

    /**
     * @return Collection<int, ClassRoom>
     */
    public function getClassroom(): Collection
    {
        return $this->classroom;
    }

    public function addClassroom(ClassRoom $classroom): self
    {
        if (!$this->classroom->contains($classroom)) {
            $this->classroom[] = $classroom;
        }

        return $this;
    }

    public function removeClassroom(ClassRoom $classroom): self
    {
        $this->classroom->removeElement($classroom);

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourse(): Collection
    {
        return $this->course;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->course->contains($course)) {
            $this->course[] = $course;
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        $this->course->removeElement($course);

        return $this;
    }
}
