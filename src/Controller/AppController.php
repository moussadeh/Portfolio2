<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Service\AppManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $entityManager, AppManager $appManager): Response
    {
        $projects = $appManager->getProjects();
        $works = $appManager->getWorks();
        // Exclude mydigitalschool
        $works = array_filter($works, function($work){
            return $work->getCode() != 'mydigitalschool';
        });
        $skills = $appManager->getSkills();
        $specialties = $appManager->getSpecialities();

        return $this->render('pages/home.html.twig',[
            'projects' => $projects,
            'works' => $works,
            'skills' => $skills,
            'specialties' => $specialties
        ]);
    }
    
    #[Route('/mentions-legales', name: 'mentions_legales')]
    public function mentionLegale(): Response
    {
        return $this->render('pages/mentions-legales.html.twig',[         
        ]);
    }

    #[Route('/send-mail', name: 'send_mail', methods: ['POST'])]
    public function sendMail(Request $request, MailerInterface $mailer): JsonResponse
    {
        // $data =
        // return $this->render('pages/mentions-legales.html.twig',[         
        // ]);
        $token = $request->request->get('token');

        if (!$this->isCsrfTokenValid('send-mail', $token)) {
            return $this->json([
                'success' => false,
                'message' => 'Token Csrf est invalide'
            ]);
        }

        $resp = $this->validateFormContact($request->request->all());
        if ($resp['success'] == false) {
            return $this->json([
                'success' => false,
                'message' => $resp['message']
            ]);
        }
        try {
            
            $username = $request->request->get('firstname') .' '.$request->request->get('lastname');
            $email = (new TemplatedEmail())
            ->from(new Address($request->request->get('email'), 'Contact : '. $username))
            ->to($_ENV['MAILER_CONTACT'])
            ->subject($request->request->get('subject'))
            ->htmlTemplate('emails/sendEmail.html.twig')
            ->context([
                'username' => $username,
                'from' => $request->request->get('email'),
                'subject' => $request->request->get('subject'),
                'message' => $request->request->get('message'),
            ]);
            
            $mailer->send($email);
            return $this->json([
                'success' => true,
                'message' => 'Votre message a bien été envoyé, je vous répondrai dans les plus brefs délais'
            ]);
        } catch (\Throwable $th) {
            return $this->json([
                'success' => false,
                'message' => $_ENV['APP_ENV'] == 'dev' ? $th->getMessage() : 'Une erreur est survenue, veuillez réessayer'
            ]);
        }
    }

    private function validateFormContact($data): ?array
    {
        try {
            if (!isset($data['firstname']) || empty($data['firstname'])) {
                throw new \Exception('Veuillez renseigner votre prénom');
            }
            if (!isset($data['lastname']) || empty($data['lastname'])) {
                throw new \Exception('Veuillez renseigner votre nom');
            }
            if (!isset($data['email']) || empty($data['email'])) {
                throw new \Exception('Veuillez renseigner votre email');
            }
            // Vérif email valide 
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Veuillez renseigner un email valide');
            }
            if (!isset($data['subject']) || empty($data['subject'])) {
                throw new \Exception('Veuillez renseigner le sujet de votre message');
            }
            if (!isset($data['message']) || empty($data['message'])) {
                throw new \Exception('Veuillez renseigner votre message');
            }


            return [
                'success' => true,
            ];
        } catch (\Throwable $th) {
            //throw $th;
            return [
                'success' => false,
                'message' => $th->getMessage()
            ];
        }
    }


    #[Route('/projects/{code}', name: 'project')]
    public function projects(EntityManagerInterface $entityManager, string $code): Response
    {
        $project = $entityManager->getRepository(Projects::class)->findOneBy(['code' => $code]);
        if (!$project) {
            // Redirect 404 - NotFoundHttpException 
            throw new NotFoundHttpException();
        }else{
            // Similar projects 
            $projects = $entityManager->getRepository(Projects::class)->findSimilar($project);
            return $this->render('pages/project.html.twig',[
                'project' => $project,
                'projects' => $projects
            ]);
        }
        
    }



    #[Route('/animation-lottie', name: 'lottie')]
    public function animationLottie(): Response
    {
        return $this->render('pages/animation-lottie.html.twig',[         
        ]);
    }
}
