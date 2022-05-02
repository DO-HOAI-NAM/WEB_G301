<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Teacher;
use App\Entity\ClassRoom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'minlength' => 0,
                    'maxlength' => 50,
                ]
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('salary', MoneyType::class)
            ->add('avatar', FileType::class, [
                'required' => false,
                'data_class' => null,
                'required' => is_null($builder->getdata()->getImage()) 
            ])
            ->add('classroom', EntityType::class, [
                'class' => ClassRoom::class,
                'choice_label' => "ClassID",
                'multiple' => true,
                'expanded' => false
            ])
            ->add('course', EntityType::class,[
                'class' => Course::class,
                'choice_label' => "ClassID",
                'multiple' => true,
                'expanded' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }
}
