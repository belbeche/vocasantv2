<?php

namespace App\Controller\Front;

use App\Entity\Exo;
use App\Entity\User;
use App\Form\HPIQuestionnaireFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class HomeController extends AbstractController
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    #[Route('/', name: 'home_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('front/Accueil/home.html.twig');
    }
    
    #[Route('/hpi-evaluation', name: 'hpi_evaluation', methods: ['GET', 'POST'])]
    public function evaluate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Debugging to check if $exoUser is correctly retrieved
        $exoUser = $entityManager->getRepository(Exo::class)->findOneBy(['user' => $user]);
        
        if ($exoUser) {
            // Optional: Add a logger or dump here to inspect the content of $exoUser
            // dump($exoUser);
            return $this->redirectToRoute('user_stats', ['id' => $exoUser->getId()]);
        }

        // Handle the form submission
        $form = $this->createForm(HPIQuestionnaireFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $exo = new Exo();
            $exo->setUser($user);
            $exo->setTypeHpi($this->determineTypeHPI($data));
            $exo->setAutonomyLevel($this->calculateAutonomyLevel($data));
            $exo->setCreatedAt(new \DateTime());

            // Enregistrement des autres champs du formulaire
            $exo->setQuelAge($data['age']);
            $exo->setPathologie($data['pathologie'] ?? null);
            $exo->setAgeMaladie($data['age_maladie'] ?? null);
            $exo->setVivreQuotidien($data['vivre_quotidien'] ?? null);
            $exo->setDifficultes($data['difficultes'] ?? null);

            $entityManager->persist($exo);
            $entityManager->flush();

            return $this->redirectToRoute('user_stats', ['id' => $exo->getId()]);
        }

        return $this->render('front/evaluation/form.html.twig', [
            'evaluationForm' => $form->createView(),
        ]);
    }



    private function determineTypeHPI(array $data): string
    {
        if ($data['sensitivity'] === 'extremely_sensitive' && !empty($data['thought_pattern'])) {
            return 'HPE (Haut Potentiel Émotionnel)';
        }

        if ($data['curiosity'] === 'yes' && !empty($data['thought_process'])) {
            return 'HPI (Haut Potentiel Intellectuel)';
        }

        return 'Inconnu';
    }

    private function calculateAutonomyLevel(array $data): int
    {
        $score = 0;

        if (isset($data['perfectionism']) && $data['perfectionism'] === 'yes') {
            $score += 20;
        }

        if (isset($data['curiosity']) && $data['curiosity'] === 'yes') {
            $score += 20;
        }

        if (isset($data['difficultes'])) {
            switch ($data['difficultes']) {
                case 'Énormément':
                    $score -= 20;
                    break;
                case 'Beaucoup':
                    $score -= 10;
                    break;
                case 'De temps en temps':
                    $score += 0;
                    break;
                case 'Pas du tout':
                    $score += 10;
                    break;
            }
        }

        return min(100, max(0, $score)); // Assure que le score est entre 0 et 100.
    }


    private function sendEmailToSpecialist(User $user, Exo $exo): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('contact@scriptzenit.fr', 'HPI Diagnostic'))
            ->to('specialist@example.com')
            ->subject('Nouvelle demande d\'évaluation HPI/HPE/HPC')
            ->htmlTemplate('front/emails/specialist_notification.html.twig')
            ->context([
                'user' => $user,
                'type_hpi' => $exo->getTypeHpi(),
                'autonomy_level' => $exo->getAutonomyLevel(),
            ]);

        $this->mailer->send($email);
    }

    #[Route('/user-stats/{id}', name: 'user_stats')]
    public function userStats(string $id, EntityManagerInterface $entityManager): Response
    {
        $userStats = $entityManager->getRepository(Exo::class)->find($id);
        if (!$userStats) {
            throw $this->createNotFoundException('Les statistiques de l\'utilisateur n\'ont pas été trouvées.');
        }

        return $this->render('front/qcm/index.html.twig', [
            'users_stats' => $userStats,
        ]);
    }
}
