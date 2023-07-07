<?php

namespace App\Controller\Back;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewController extends AbstractController
{
    #[Route('/reviews', name: 'review_index', methods: ['GET'])]
    public function index(ReviewRepository $reviewRepository): Response
    {
        $reviews = $reviewRepository->findAll();

        return $this->render('back/review/index.html.twig', [
            'reviews' => $reviews,
        ]);
    }

    #[Route('/reviews/new', name: 'review_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('review_index');
        }

        return $this->render('back/review/new.html.twig', [
            'review' => $review,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reviews/{id}', name: 'review_show', methods: ['GET'])]
    public function show(Review $review): Response
    {
        return $this->render('back/review/show.html.twig', [
            'review' => $review,
        ]);
    }

    #[Route('/reviews/{id}/edit', name: 'review_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Review $review,EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('review_index');
        }

        return $this->render('back/review/edit.html.twig', [
            'review' => $review,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reviews/{id}', name: 'review_delete', methods: ['DELETE'])]
    public function delete(Request $request, Review $review, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$review->getId(), $request->request->get('_token'))) {
            $entityManager->remove($review);
            $entityManager->flush();
        }

        return $this->redirectToRoute('review_index');
    }
}
