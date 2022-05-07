<?php

namespace App\Entity;

use App\Repository\MarkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarkRepository::class)]
class Mark
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'marks')]
    private $student;

    #[ORM\Column(type: 'float')]
    private $assignment_1;

    #[ORM\Column(type: 'float')]
    private $assignment_2;

    #[ORM\ManyToOne(targetEntity: Semester::class, inversedBy: 'marks')]
    private $semester;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getAssignment1(): ?float
    {
        return $this->assignment_1;
    }

    public function setAssignment1(float $assignment_1): self
    {
        $this->assignment_1 = $assignment_1;

        return $this;
    }

    public function getAssignment2(): ?float
    {
        return $this->assignment_2;
    }

    public function setAssignment2(float $assignment_2): self
    {
        $this->assignment_2 = $assignment_2;

        return $this;
    }

    public function getSemester(): ?Semester
    {
        return $this->semester;
    }

    public function setSemester(?Semester $semester): self
    {
        $this->semester = $semester;

        return $this;
    }

    
}