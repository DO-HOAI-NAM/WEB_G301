<?php

namespace App\Form;

use App\Entity\Mark;
use App\Entity\Course;
use App\Entity\Student;
use App\Entity\Semester;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MarkType extends AbstractType
{
      public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('student')
            // ->add('teacher')
            ->add('student', EntityType::class, [
                'label' => 'Student Name',
                'required' => true,
                'class' => Student::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false
            ])
            // ->add('course', EntityType::class, [
            //     'label' => 'Subject Name',
            //     'required' => true,
            //     'class' => Course::class,
            //     'choice_label' => 'name',
            //     'multiple' => false,
            //     'expanded' => false
            // ])
            ->add('semester', EntityType::class, [
                'label' => 'Semester Name',
                'required' => true,
                'class' => Semester::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('assignment1', ChoiceType::class,
            [
                'label'=>'Mark Assignment 1',
                'required' => true,
                'choices' => [
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10
                ],
                'expanded' => false
            ])
            ->add('assignment2', ChoiceType::class,
            [
                'label'=>'Mark Assignment 2',
                'required' => true,
                'choices' => [
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                     '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10
                ],
                'expanded' => false
            ])
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}