<?php

namespace App\Controller\Front;

use App\Entity\RendezVous;
use App\Entity\Professionnel;
use App\Form\RendezVousFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rendezvous')]
class RendezVousController extends AbstractController
{
    #[Route('/new', name: 'rendezvous_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rendezVous = new RendezVous();
        $form = $this->createForm(RendezVousFormType::class, $rendezVous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $rendezVous->setUser($user); // Assurez-vous que $user est bien une instance de User avec un UUID
            

            $entityManager->persist($rendezVous);
            $entityManager->flush();

            return $this->redirectToRoute('rendezvous_index');
        }

        return $this->render('front/rendezvous/new.html.twig', [
            'rendezVousForm' => $form->createView(),
        ]);
    }

    #[Route('/', name: 'rendezvous_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $rendezVous = $entityManager->getRepository(RendezVous::class)->findBy(['user' => $this->getUser()]);

        return $this->render('front/rendezvous/index.html.twig', [
            'rendezVousForm' => $rendezVous,
            'rendezVousList' => $rendezVous,
        ]);
    }

    #[Route('/rendezvous/{id}', name: 'rendezvous_show')]
    public function show(RendezVous $rendezVous): Response
    {
        return $this->render('front/rendezvous/show.html.twig', [
            'rendezVous' => $rendezVous,
        ]);
    }

    #[Route('/rendezvous/edit/{id}', name: 'rendezvous_edit')]
    public function edit(Request $request, RendezVous $rendezVous, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RendezVousFormType::class, $rendezVous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('rendezvous_show', ['id' => $rendezVous->getId()]);
        }

        return $this->render('front/rendezvous/edit.html.twig', [
            'rendezVousForm' => $form->createView(),
        ]);
    }
}
