<?php

namespace App\Controller\Front;

use App\Entity\Exo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', 'home_index', methods: ['GET'])]
    public function index()
    {
        return $this->render('front/Accueil/home.html.twig');
    }

    #[Route('/nouveau/{id}', 'home_statistiques', methods: ['GET','POST'])]
     public function getNew(Request $request, EntityManagerInterface $entityManager, $id)
     {
         $lists_question = $entityManager->getRepository(Exo::class)->find($id);
 
         $lists_question->setCreatedAt(new \DateTimeImmutable());
 
         $form = $this->createFormBuilder($lists_question)
             ->add('nom', TextType::class)
             ->add('prenom', TextType::class)
             ->add('niveau', ChoiceType::class, [
                 'choices' => [
                     'Enormement' => '20',
                     'Beaucoup' => '40',
                     'De temps en temps' => '60',
                     'Pas du tout' => '80'
                 ],
                 'label' => 'Pour vous est-ce difficile de vivre quotidiennement ?',
             ])
             ->add('pathologie', TextType::class, [
                 'label' => 'Maladie(si existante)',
             ])
             ->add('age_maladie', TextType::class, [
                 'label' => '(Faculatatif)',
             ])
             ->add('quel_age', TextType::class, [
                 'label' => 'Votre age',
             ])
             ->add('vivre_quatidien', ChoiceType::class, [
                 'choices' => [
                     'Seul' => 'Laisser seul le malade vivre chez lui ',
                     'En Famille' => 'Vivre avec lui',
                     'Etablissement spécialisé' => 'Le placer dans un établissement',
                 ],
                 'label' => 'Comment vivez-vous ?',
             ])
             ->add('suivant', SubmitType::class, [
                 'attr' => [
                     'class' => 'btn btn-info'
                 ],
             ])
             ->getForm();
 
         $form->handleRequest($request);
 
         if ($form->isSubmitted() && $form->isValid()) {
             $entityManager->flush();
 
             return $this->redirectToRoute('home_exercices', ['id' => $lists_question->getId()]);
         }
         return $this->render("front/Qcm/new.html.twig", [
             'lists_question' => $form->createView(),
         ]);
     }

    #[Route('/modifier/{id}', 'home_statistique_edit', methods: ['GET','POST'])]
    public function getEdit($id, Request $request, EntityManagerInterface $entityManager)
    {
        $lists_question = $entityManager->getRepository(Exo::class)->find($id);

        $lists_question->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createFormBuilder($lists_question)
        ->add('nom', TextType::class)
        ->add('prenom', TextType::class)
        ->add('niveau', ChoiceType::class, [
            'choices' => [
                'Enormement' => '20',
                'Beaucoup' => '40',
                'De temps en temps' => '60',
                'Pas du tout' => '80'
            ],
            'label' => 'Pour vous est-ce difficile de vivre quotidiennement ?',
        ])
        ->add('pathologie', TextType::class, [
            'label' => 'Maladie(si existante)',
        ])
        ->add('age_maladie', TextType::class, [
            'label' => '(Faculatatif)',
        ])
        ->add('quel_age', TextType::class, [
            'label' => 'Votre age',
        ])
        ->add('vivre_quatidien', ChoiceType::class, [
            'choices' => [
                'Seul' => 'Laisser seul le malade vivre chez lui ',
                'En Famille' => 'Vivre avec lui',
                'Etablissement spécialisé' => 'Le placer dans un établissement',
            ],
            'label' => 'Mode de vie actuel',
        ])
        ->add('suivant', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-info'
            ],
        ])
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('home_exercices', ['id' => $lists_question->getId()]);
        }
        return $this->render("front/Qcm/edit.html.twig", [
            'edit_users' => $form->createView(),
        ]);
    }
    /**
    * Espace membre utilisateur
    */
    #[Route('/exercice/{id}', 'home_exercices', methods: ['GET'])]
    public function getWork(Request $request,EntityManagerInterface $entityManager, $id)
    {

        $users_stats = $entityManager
            ->getRepository(Exo::class)
            ->find($id);

        return $this->render('front/Qcm/index.html.twig', [
            'users_stats' => $users_stats,
        ]);
    }
}
