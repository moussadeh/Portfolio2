<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('pages/home.html.twig',[
        ]);
    }
    
    // #[Route('/mentions-legales', name: 'mentions_legales')]
    // public function mentionLegale(): Response
    // {
    //     return $this->render('pages/mentions-legales.html.twig',[         
    //     ]);
    // }

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
        // dd($request->request->all());

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
                'message' => 'Une erreur est survenue, veuillez réessayer'
            ]);
        }
    }
}
