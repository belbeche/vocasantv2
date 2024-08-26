<?php

namespace App\Controller\Back;

use App\Entity\Professionnel;
use App\Form\ProfessionnelFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/professionnel')]
class AdminProfessionnelController extends AbstractController
{
    #[Route('/', name: 'admin_professionnel_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $professionnels = $entityManager->getRepository(Professionnel::class)->findAll();

        return $this->render('admin/professionnel/index.html.twig', [
            'professionnels' => $professionnels,
        ]);
    }

    #[Route('/new', name: 'admin_professionnel_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $professionnel = new Professionnel();
        $form = $this->createForm(ProfessionnelFormType::class, $professionnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($professionnel);
            $entityManager->flush();

            return $this->redirectToRoute('admin_professionnel_index');
        }

        return $this->render('admin/professionnel/new.html.twig', [
            'professionnel' => $professionnel,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_professionnel_edit')]
    public function edit(Request $request, Professionnel $professionnel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfessionnelFormType::class, $professionnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_professionnel_index');
        }

        return $this->render('admin/professionnel/edit.html.twig', [
            'professionnel' => $professionnel,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_professionnel_delete')]
    public function delete(Professionnel $professionnel, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($professionnel);
        $entityManager->flush();

        return $this->redirectToRoute('admin_professionnel_index');
    }
}
