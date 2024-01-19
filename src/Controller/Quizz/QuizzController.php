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
        // Récupérer tous les quizz depuis la base de données
        $quizzList = $quizzRepository->findAll();


        // Réinitialiser l'index du quizz si demandé (par exemple, si l'utilisateur a terminé le quizz)
        if ($request->query->get('reset')) {
            $session->remove('quizzIndex');
        }




        // Initialiser l'index du quizz dans la session si ce n'est pas déjà fait
        $quizzIndex = $session->get('quizzIndex', 0);

        // Logique pour traiter le formulaire, récupérer les choix, etc.
        $choix1 = $request->request->get('choix1', '');
        $choix2 = $request->request->get('choix2', '');
        $choix3 = $request->request->get('choix3', '');

        if ($request->isMethod('POST')) {
            // Vérifier la réponse correcte
            $quizz = $quizzList[$quizzIndex];
            $reponseCorrecte = $quizz->getreponse_correct();

            // Enregistrez le choix de l'utilisateur dans la session ou une base de données
            // Ceci est un exemple, ajustez selon vos besoins
            $session->set("user_choice_$quizzIndex", [$choix1, $choix2, $choix3]);

            // Si l'une des réponses est correcte, passer au quizz suivant
            $quizzIndex++;

            // Si nous avons atteint le dernier quizz, redirigez vers la page finale
            if ($quizzIndex >= count($quizzList)) {
                return $this->redirectToRoute('resultat_quizz');
            }

            // Mettre à jour l'index du quizz dans la session
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
        // Récupérer tous les quizz depuis la base de données
        $quizzList = $quizzRepository->findAll();

        // Récupérer les choix de l'utilisateur depuis la session ou une base de données
        // Ceci est un exemple, ajustez selon vos besoins
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
