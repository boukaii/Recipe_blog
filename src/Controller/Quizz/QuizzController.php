<?php
namespace App\Controller\Quizz;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuizzRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizzController extends AbstractController
{
    #[Route('/quizz', name: 'quizz')]
    public function index(QuizzRepository $quizzRepository, Request $request): Response
    {
        // Récupérer tous les quizz depuis la base de données
        $quizzList = $quizzRepository->findAll();

        // Logique pour traiter le formulaire, récupérer les choix, etc.
        $choix1 = $request->request->get('choix1', '');
        $choix2 = $request->request->get('choix2', '');
        $choix3 = $request->request->get('choix3', '');

        return $this->render('quizz/quizz.html.twig', [
            'quizzList' => $quizzList,
            'choix1' => $choix1,
            'choix2' => $choix2,
            'choix3' => $choix3,
        ]);
    }
}
