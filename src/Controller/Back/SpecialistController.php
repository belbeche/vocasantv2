<?php

namespace App\Controller\Back;

use App\Entity\Specialist;
use App\Form\SpecialistType;
use App\Repository\SpecialistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpecialistController extends AbstractController
{
    #[Route('/specialists', name: 'specialist_index', methods: ['GET'])]
    public function index(SpecialistRepository $specialistRepository): Response
    {
        $specialists = $specialistRepository->findAll();

        return $this->render('back/specialist/index.html.twig', [
            'specialists' => $specialists,
        ]);
    }

    #[Route('/specialists/new', name: 'specialist_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $specialist = new Specialist();
        $form = $this->createForm(SpecialistType::class, $specialist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($specialist);
            $entityManager->flush();

            return $this->redirectToRoute('specialist_index');
        }

        return $this->render('back/specialist/new.html.twig', [
            'specialist' => $specialist,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/specialists/{id}', name: 'specialist_show', methods: ['GET'])]
    public function show(Specialist $specialist): Response
    {
        return $this->render('back/specialist/show.html.twig', [
            'specialist' => $specialist,
        ]);
    }

    #[Route('/specialists/{id}/edit', name: 'specialist_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Specialist $specialist,EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpecialistType::class, $specialist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('specialist_index');
        }

        return $this->render('back/specialist/edit.html.twig', [
            'specialist' => $specialist,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/specialists/{id}', name: 'specialist_delete', methods: ['DELETE'])]
    public function delete(Request $request, Specialist $specialist, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specialist->getId(), $request->request->get('_token'))) {
            $entityManager->remove($specialist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('specialist_index');
    }
}