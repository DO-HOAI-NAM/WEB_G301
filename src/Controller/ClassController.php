<?php

namespace App\Controller;

use App\Form\ClassType;
use App\Entity\ClassRoom;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route("/class")]
class ClassController extends AbstractController
{
    #[Route('/', name: 'classIndex')]
    public function classIndex(ManagerRegistry $registry): Response
    {
        $classes = $registry->getRepository(ClassRoom::class)->findAll();
        return $this->render('class/index.html.twig', [
            'classes' => $classes
        ]);
    }
    #[Route("/detail/{id}", name: 'classDetail')]
    public function classDetail(ManagerRegistry $registry, $id)
    {
        $class = $registry->getRepository(ClassRoom::class)->find($id);
        if ($class == null) {
            return $this->redirectToRoute("classIndex");
        }
        return $this->render(
            'class/detail.html.twig',
            [
                'class' => $class
            ]
        );
    }
    #[Route('/delete/{id}', name: 'class_delete')]
    public function classDelete(ManagerRegistry $registry, $id)
    {
        $class = $registry->getRepository(ClassRoom::class)->find($id);
        $manager = $registry->getManager();
        $manager->remove($class);
        $manager->flush();
        return $this->redirectToRoute("classIndex", [
            'class' => $class
        ]);
    }
    #[Route('/add', name: 'class_add')]
    public function classAdd(Request $request, ManagerRegistry $registry)
    {
        $class = new ClassRoom;
        $form = $this->createForm(ClassType::class, $class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $registry->getManager();
            $manager->persist($class);
            $manager->flush();
            return $this->redirectToRoute('classIndex');
        }
        return $this->renderForm(
            'class/add.html.twig',
            [
                'classForm' => $form
            ]
        );
    }
    #[Route('/edit/{id}', name: 'classEdit')]
    public function classEdit(Request $request, ManagerRegistry $registry, $id)
    {
        $class = $registry->getRepository(ClassRoom::class)->find($id);
        $form = $this->createForm(ClassType::class, $class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $registry->getManager();
            $manager->persist($class);
            $manager->flush();
            return $this->redirectToRoute('classIndex');
        }
        return $this->renderForm(
            'class/edit.html.twig',
            [
                'classForm' => $form
            ]
        );
    }
}
