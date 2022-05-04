<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Entity\ClassRoom;
use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route("/teacher")]
class TeacherController extends AbstractController
{
    #[Route('/', name: 'teacher_index')]
    public function teacherIndex (ManagerRegistry $registry) {
        $classes = $registry->getRepository(ClassRoom::class)->findAll();
        $teachers = $registry->getRepository(Teacher::class)->findAll();
        return $this->render("teacher/index.html.twig",
        [
            'teachers' => $teachers,
            'classes' => $classes
        ]);
    }
 
    #[Route('/detail/{id}', name: 'teacher_detail')]
    public function teacherDetail (ManagerRegistry $registry, $id) {
        $classes = $registry->getRepository(ClassRoom::class)->findAll();
        $teacher = $registry->getRepository(Teacher::class)->find($id);
        if ($teacher == null) {
            $this->addFlash("Error","Teacher not found !");
            return $this->redirectToRoute("teacher_index");
        }
        return $this->render("teacher/detail.html.twig",
        [
            'teacher' => $teacher,
            'classes' => $classes
        ]);
    }
    #[Route('/search', name: 'teacher_search')]
    public function search(Request $request ,TeacherRepository $teacherRepository){
        $keyword = $request->get('name');
        $teachers = $teacherRepository->searchTeacher($keyword);
        return $this->render('teacher/index.html.twig', 
                            [
                                'teachers' => $teachers,
                            ]);
    }

    #[Route('/delete/{id}', name: 'teacher_delete')]
    public function teacherDelete (ManagerRegistry $registry, $id) {
        $classes = $registry->getRepository(ClassRoom::class)->findAll();
        $teacher = $registry->getRepository(Teacher::class)->find($id);
        if ($teacher == null) {
            $this->addFlash("Error","Teacher not found !");
        } else {
            $manager = $registry->getManager();
            $manager->remove($teacher);
            $manager->flush();
            $this->addFlash("Success", "Teacher delete succeed !");
        }
        return $this->redirectToRoute("teacher_index",[
            'classes' => $classes,
        ]);
    }

    #[Route('/add', name: 'teacher_add')]
   public function teacherAdd(Request $request, ManagerRegistry $registry) {
       $teacher = new Teacher;
       $classes = $registry->getRepository(ClassRoom::class)->findAll();
       $form = $this->createForm(TeacherType::class,$teacher);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $image = $teacher->getAvatar(); 
           $imgName = uniqid(); 
           $imgExtension = $image->guessExtension();
           $imageName = $imgName . '.' . $imgExtension;
           try {
             $image->move(
                $this->getParameter('teacher_image'),$imageName
             );
            } catch (FileException $e) {
           }
           $teacher->setAvatar($imageName);
           $manager = $registry->getManager();
           $manager->persist($teacher);
           $manager->flush();
           $this->addFlash("Success","Add teacher succeed !");
           return $this->redirectToRoute('teacher_index');
       }
       return $this->renderForm('teacher/add.html.twig',
                                [
                                    'classes' => $classes,
                                  'teacherForm' => $form
                                ]);
   }

   #[Route('/edit/{id}', name: 'teacher_edit')]
   public function teacherEdit(Request $request, ManagerRegistry $registry, $id) {
    $classes = $registry->getRepository(ClassRoom::class)->findAll();
       $teacher = $registry->getRepository(Teacher::class)->find($id);
       $form = $this->createForm(TeacherType::class, $teacher);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $imageFile = $form['avatar']->getData();
           if ($imageFile != null) {
               $image = $teacher->getAvatar();
               $imgName = uniqid();
               $imgExtension = $image->guessExtension();
               $imageName = $imgName . '.' . $imgExtension;
               try {
                   $image->move(
                       $this->getParameter('teacher_image'),
                       $imageName
                   );
               } catch (FileException $e) {
               }
               $teacher->setAvatar($imageName);
           }

           $manager = $registry->getManager();
           $manager->persist($teacher);
           $manager->flush();
           $this->addFlash("Success", "Edit teacher succeed !");
           return $this->redirectToRoute('teacher_index');
       }
       return $this->renderForm('teacher/edit.html.twig',
                                [
                                    'classes' => $classes,
                                    'teacherForm' => $form
                                ]);
   }
//    #[Route('/filter/{id}', name: 'teacher_filter')]
//    public function filter ($id, ManagerRegistry $registry) {
//        $classes = $registry->getRepository(ClassRoom::class)->findAll();
//        $class = $registry->getRepository(ClassRoom::class)->find($id);
//        $teachers = $class->getTeachers();
//        return $this->render("teacher/index.html.twig",
//                             [
//                                 'classes' => $classes,
//                                 'teachers' => $teachers
//                             ]);
//    }
//     #[Route('/asc', name:'semester_asc')]
//     public function sortAsc(ManagerRegistry $registry, SemesterRepository $semesterRepository){
//     $semesters = $semesterRepository->sortSemesterAsc();
//     return $this->render("semester/index.html.twig",[
//        'semesters' => $semesters 
//     ]);
// }
//      #[Route('/desc', name:'semester_desc')]
//     public function sortDesc(ManagerRegistry $registry, SemesterRepository $semesterRepository){
//     $semesters = $semesterRepository->sortSemesterDesc();
//     return $this->render("semester/index.html.twig",[
//        'semesters' => $semesters 
//     ]);
//     }
 
}


