<?php

namespace App\Controller\CreateRecipe;

use App\Entity\Recette;
use App\Form\RecetteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RecetteRepository;
use App\Form\CommentType;
use App\Entity\Comment;
use Doctrine\Persistence\ManagerRegistry;

class RecetteController extends AbstractController
{
    private $commentFormRendered = false;

    #[Route('/recette/new/', name: 'new_recette')]
    public function createRecette(Request $request, ManagerRegistry $manager): Response
    {
        $recette = new Recette();
        $comment = new Comment();

        $recetteForm = $this->createForm(RecetteType::class, $recette);
        $commentForm = $this->createForm(CommentType::class, $comment);

        $recetteForm->handleRequest($request);
        $commentForm->handleRequest($request);

        if ($recetteForm->isSubmitted() && $recetteForm->isValid()) {
            $user = $this->getUser();
            $recette->setUser($user);

            $entityManager = $manager->getManager();
            $entityManager->persist($recette);
            $entityManager->flush();

            return $this->redirectToRoute('recette');
        }

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $user = $this->getUser();
            $comment->setUser($user);

            $recette = $comment->getRecette();
            $comment->setRecette($recette);
            $entityManager = $manager->getManager();

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('recette');
        }

        return $this->render('recette/new_recette.html.twig', [
            'recetteForm' => $recetteForm->createView(),
            'commentForm' => $commentForm->createView(),
        ]);
    }

    #[Route('/mes-recettes/', name: 'mes_recettes')]
    public function mesRecettes(RecetteRepository $recetteRepository): Response
    {
        $user = $this->getUser();
        $mesRecettes = $recetteRepository->findBy(['user' => $user]);

        return $this->render('recette/mes_recettes.html.twig', [
            'mesRecettes' => $mesRecettes,
        ]);
    }

    #[Route('/toutes-les-recettes/', name: 'toutes_les_recettes')]
    public function toutesLesRecettes(RecetteRepository $recetteRepository, Request $request, ManagerRegistry $manager): Response
    {
        $toutesLesRecettes = $recetteRepository->findAll();
        $commentForm = $this->createForm(CommentType::class, new Comment());

        return $this->render('recette/toutes_les_recettes.html.twig', [
            'toutesLesRecettes' => $toutesLesRecettes,
            'commentForm' => $commentForm->createView(),
            'commentFormRendered' => $this->commentFormRendered,
        ]);
    }

    public function index(RecetteRepository $recetteRepository, Request $request, ManagerRegistry $manager): Response
    {
        $recettes = $recetteRepository->findAll();

        $commentForm = $this->createForm(CommentType::class, new Comment());
        $user = $this->getUser();
        $commentForm->get('user')->setData($user);
        $now = new \DateTime();
        $commentForm->get('createAt')->setData($now);

        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $user = $this->getUser();
            $comment = $commentForm->getData();
            $comment->setUser($user);

            $entityManager = $manager->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('recette');
        }

        return $this->render('recette/toutes_les_recettes.html.twig', [
            'toutesLesRecettes' => $recettes,
            'commentForm' => $commentForm->createView(),
        ]);
    }
}