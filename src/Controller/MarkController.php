<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Form\MarkType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/mark')]
class MarkController extends AbstractController
{
   #[Route('/', name: 'mark_index')]
    public function markIndex(ManagerRegistry $registry)
    {
        $marks = $registry->getRepository(Mark::class)->findAll();
        return $this->render('mark/index.html.twig', [
            'marks' => $marks
        ]);
    }
    #[Route('/delete/{id}', name: 'mark_delete')]
    public function markDelete(ManagerRegistry $registry, $id){
        //getRepository() method sẽ trả về một repository cho phép bạn query tới database.
        $mark = $registry->getRepository(Mark::class)->find($id);
        if ($mark == null) {
            $this->addFlash("Error","Mark not found !");
        }
        else{
            $marks = $registry->getRepository(Mark::class)->find($id);
            $manager = $registry->getManager();
            $manager->remove($marks);
            $manager->flush();
        }

        $this->addFlash('Success!!', 'Mark is deleted');
        return $this->redirectToRoute('mark_index');
    }
    #[Route('/detail/{id}', name: 'mark_detail')]
    public function markDetail(ManagerRegistry $registry, $id)
    {
        $mark = $registry->getRepository(Mark::class)->find($id);
        if ($mark == null) {
            $this->addFlash('error', 'Mark not found');
            return $this->redirectToRoute('mark_index');
        }
        return $this->render('mark/detail.html.twig', [
            'mark' => $mark
        ]);
    }
    #[Route('/add', name: 'mark_add')]
    //ManagerRegistry $doctrine số yêu cầu Symfony đưa dịch vụ Doctrine vào phương thức controller.
    public function markAdd(Request $request, ManagerRegistry $registry){
        $mark = new Mark();
        $form = $this->createForm(MarkType::class, $mark);
    // Để xử lý dữ liệu biểu mẫu, bạn sẽ cần gọi phương thức handleRequest ()
    // Đằng sau, điều này sử dụng một đối tượng NativeRequestHandler để đọc dữ liệu của các 
    // superglobals PHP chính xác (tức là $_POSThoặc $_GET) dựa trên phương thức HTTP được định cấu hình trên biểu mẫu (POST là mặc định)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $registry->getManager();
            //Persist tìm và nạp đối tượng từ doctrine
            $manager -> persist($mark);
            $manager -> flush();
            $this->addFlash('Success', 'Add mark successfull !!');
            return $this->redirectToRoute("mark_index");
        }
        return $this->renderForm('mark/add.html.twig',
                                [
                                    'markForm' => $form
                                ]);

    }
    #[Route('edit/{id}', name: 'mark_edit')]
    public function markEdit(Request $request ,ManagerRegistry $registry, $id){
        $mark = $registry->getRepository(Mark::class)->find($id);
        $form = $this->createForm(MarkType::class, $mark);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $registry->getManager();
            $manager -> persist($mark);
            $manager -> flush();
            $this->addFlash('Success', 'Add mark successfull !!');
            return $this->redirectToRoute("mark_index");
        }
        return $this->renderForm('mark/edit.html.twig',
                                [
                                    'markForm' => $form
                                ]);
    }
}