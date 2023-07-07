<?php

namespace App\Controller\Back;

use App\Entity\Job;
use App\Form\JobType;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JobController extends AbstractController
{
    #[Route('/jobs', name: 'job_index', methods: ['GET'])]
    public function index(JobRepository $jobRepository): Response
    {
        $jobs = $jobRepository->findAll();

        return $this->render('back/job/index.html.twig', [
            'jobs' => $jobs,
        ]);
    }

    #[Route('/jobs/new', name: 'job_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($job);
            $entityManager->flush();

            return $this->redirectToRoute('job_index');
        }

        return $this->render('job/new.html.twig', [
            'job' => $job,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/jobs/{id}', name: 'job_show', methods: ['GET'])]
    public function show(Job $job): Response
    {
        return $this->render('back/job/show.html.twig', [
            'job' => $job,
        ]);
    }

    #[Route('/jobs/{id}/edit', name: 'job_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Job $job, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('job_index');
        }

        return $this->render('back/job/edit.html.twig', [
            'job' => $job,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/jobs/{id}', name: 'job_delete', methods: ['DELETE'])]
    public function delete(Request $request, Job $job,EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$job->getId(), $request->request->get('_token'))) {
            $entityManager->remove($job);
            $entityManager->flush();
        }

        return $this->redirectToRoute('job_index');
    }
}