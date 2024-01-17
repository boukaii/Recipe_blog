<?php

namespace App\Controller\CreateRecipe;

use App\Entity\Recette;
use App\Form\RecetteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\RecetteRepository;
use App\Form\CommentType;
use App\Entity\Comment;

class RecetteController extends AbstractController
{

    #[Route('/recette/new/', name: 'new_recette')]
    public function createRecette(Request $request, ManagerRegistry $manager, RecetteRepository $RecetteRepository): Response
    {
        // Création d'une nouvelle instance de l'entité Post
        $recette = new Recette();
        $comment = new Comment();
        // Création du formulaire à partir du type de formulaire associé à l'entité Post
        $recetteForm = $this->createForm(RecetteType::class, $recette);
        $commentForm = $this->createForm(CommentType::class, $comment);

        // Traitement de la soumission du formulaire
        $recetteForm->handleRequest($request);
        $commentForm->handleRequest($request);

        // Vérification si le formulaire est soumis et valide
        if ($recetteForm->isSubmitted() && $recetteForm->isValid()) {
            // Associez la recette à l'utilisateur actuellement connecté
            $user = $this->getUser(); // Obtenez l'utilisateur actuel
            $recette->setUser($user);
            // Sauvegarde du post dans la base de données
            $entityManager = $manager->getManager();
            $entityManager->persist($recette);
            $entityManager->flush();

            // Redirection vers une page de confirmation ou une autre page de votre choix
            return $this->redirectToRoute('recette');
        }
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $user = $this->getUser();
            $comment->setUser($user);

            // Associez le commentaire à la recette, vous devrez peut-être ajuster ceci en fonction de votre logique
            $recette = $comment->getRecette();
            $comment->setRecette($recette);

            $entityManager = $manager->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('recette');
        }

        $recettes = $RecetteRepository->findAll();

        // Initialisation du tableau commentForms
        $commentForms = [];
        foreach ($recettes as $recette) {
            $commentForms[$recette->getId()] = $this->createForm(CommentType::class, new Comment())->createView();
        }
        // Affichage du formulaire
        return $this->render('recette/new_recette.html.twig', [
            'recettes' => $recettes,
            'recetteForm' => $recetteForm->createView(),
            'commentForms' => $commentForms,
        ]);
    }
    #[Route('recette/', name: 'recette')]
    public function index(RecetteRepository $RecetteRepository, Request $request, ManagerRegistry $manager): Response
    {
        // Récupération de tous les posts depuis la base de données
        $recettes = $RecetteRepository->findAll();

        // Création du formulaire de commentaire
        $commentForm = $this->createForm(CommentType::class, new Comment());

        // Pré-remplissage des champs "User" et "Create"
        $user = $this->getUser();
        $commentForm->get('user')->setData($user);

        $now = new \DateTime();
        $commentForm->get('createAt')->setData($now);

        // Traitement de la soumission du formulaire de commentaire
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            // Vous devez gérer ici la sauvegarde du commentaire en associant la recette appropriée
            $user = $this->getUser();
            $comment = $commentForm->getData();
            $comment->setUser($user);
            $entityManager = $manager->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            // Redirection ou autre action après la soumission du formulaire de commentaire
            return $this->redirectToRoute('recette');
        }

        // Affichage des recettes dans une vue Twig avec le formulaire de commentaire
        return $this->render('recette/recette.html.twig', [
            'recettes' => $recettes,
            'commentForm' => $commentForm->createView(),
        ]);
    }
}