<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Review;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Form\ReviewType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ReviewController extends AbstractController
{
    #[Route('/review', name: 'list_review')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $reviews = $doctrine->getRepository('App\Entity\Review')->findAll();
        return $this->render('review/index.html.twig', [
            'products' => $reviews,
        ]);

    }
    #[Route('/review/review byProduct/{id}', name: 'review_by_product')]
    public  function reviewByCatAction(ManagerRegistry $doctrine ,$id):Response
    {
        $product = $doctrine->getRepository(Product::class)->find($id);
        $reviews = $product->getProducts();
        $products = $doctrine->getRepository('App\Entity\Product')->findAll();
        return $this->render('review/index.html.twig', ['reviews' => $reviews,
            'product'=>$products]);
    }
    #[Route('/review/create', name: 'create_review', methods: ['GET', 'POST'])]
    public function createAction(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger)
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // upload file

            $em = $doctrine->getManager();
            $em->persist($review);
            $em->flush();

            $this->addFlash(
                'notice',
                'Review Added'
            );
            return $this->redirectToRoute('list_review');
        }
        return $this->renderForm('review/create.html.twig', ['form' => $form,]);
    }
    #[Route('/review/edit/{id}', name: 'edit_review', methods: ['GET', 'POT'])]
    public function editAction(ManagerRegistry $doctrine, int $id,Request $request): Response{
        $entityManager = $doctrine->getManager();
        $review = $entityManager->getRepository(Review::class)->find($id);
        $form = $this->createForm(ReviewType::class, @$review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $doctrine->getManager();
            $em->persist($review);
            $em->flush();
            return $this->redirectToRoute('list_review', [
                'id' => $review->getId()
            ]);

        }
        return $this->renderForm('review/edit.html.twig', ['form' => $form,]);
    }
    #[Route('/review/delete/{id}', name: 'delete_review', methods: ['GET', 'POT'])]
    public function deleteAction(ManagerRegistry $doctrine,$id)
    {
        $em = $doctrine->getManager();
        $review = $em->getRepository('App\Entity\Review')->find($id);
        $em->remove($review);
        $em->flush();

        $this->addFlash(
            'error',
            'Review is deleted'
        );

        return $this->redirectToRoute('list_review');
    }

}
