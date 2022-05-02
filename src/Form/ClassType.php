<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\ClassRoom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ClassID', TextType::class)
            ->add('teachers', EntityType::class, [
                'class' => Teacher::class, 
                'required' => false,
                'choice_label' => "name",
                'multiple' => true,
                'expanded' => false
            ])
            ->add('student', EntityType::class, [
                'class' => Student::class, 
                'required' => false,
                'choice_label' => "name",
                'multiple' => true,
                'expanded' => false
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClassRoom::class,
        ]);
    }
}
