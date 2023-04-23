<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
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
    
    #[Route('/mentions-legales', name: 'mentions_legales')]
    public function mentionLegale(): Response
    {
        return $this->render('pages/mentions-legales.html.twig',[         
        ]);
    }

    #[Route('/send-mail', name: 'send_mail')]
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


        $email = (new Email())
            ->from($request->request->get('email'))
            ->to($_ENV['MAILER_CONTACT'])
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Contact : ' . $request->request->get('sujet'))
            // ->text()
            ->htmlTemplate('emails/sendEmail.html.twig')
            ->context([
                'username' => $request->request->get('firstname') .' '.$request->request->get('lastname'),
                'email' => $request->request->get('email'),
                'sujet' => $request->request->get('sujet'),
                'message' => $request->request->get('message'),
            ]);
            // ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);



        if ($success) {
            return $this->json([
                'success' => true,
                'message' => 'Votre message a bien été envoyé, je vous répondrai dans les plus brefs délais'
            ]);
        }else{
            return $this->json([
                'success' => false,
                'message' => 'Une erreur est survenue, veuillez réessayer'
            ]);
        }
    }
}
