<?php

namespace App\Controller\Quizz;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuizzRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class QuizzController extends AbstractController
{
    #[Route('/quizz', name: 'quizz')]
    public function index(QuizzRepository $quizzRepository, Request $request, SessionInterface $session): Response
    {
        $quizzList = $quizzRepository->findAll();


        if ($request->query->get('reset')) {
            $session->remove('quizzIndex');
        }

        $quizzIndex = $session->get('quizzIndex', 0);

        $choix1 = $request->request->get('choix1', '');
        $choix2 = $request->request->get('choix2', '');
        $choix3 = $request->request->get('choix3', '');

        if ($request->isMethod('POST')) {
            $quizz = $quizzList[$quizzIndex];
            $reponseCorrecte = $quizz->getreponse_correct();

   
            $session->set("user_choice_$quizzIndex", [$choix1, $choix2, $choix3]);

            $quizzIndex++;

            if ($quizzIndex >= count($quizzList)) {
                return $this->redirectToRoute('resultat_quizz');
            }

            $session->set('quizzIndex', $quizzIndex);
        }

        return $this->render('quizz/quizz.html.twig', [
            'quizz' => $quizzList[$quizzIndex],
            'choix' => [
                'choix1' => $choix1,
                'choix2' => $choix2,
                'choix3' => $choix3,
            ],
        ]);
    }

    #[Route('/resultat_quizz', name: 'resultat_quizz')]
    public function resultatQuizz(QuizzRepository $quizzRepository, SessionInterface $session): Response
    {
        $quizzList = $quizzRepository->findAll();


        $userChoices = [];
        for ($i = 0; $i < count($quizzList); $i++) {
            $userChoices[] = $session->get("user_choice_$i", []);
        }

        return $this->render('quizz/resultat_quizz.html.twig', [
            'quizzList' => $quizzList,
            'userChoices' => $userChoices,
        ]);
    }
}
