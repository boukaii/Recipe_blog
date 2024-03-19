<?php

namespace App\Controller\Recipe;

use App\Entity\Recipe;
use App\Form\RecipeType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\RecipeRepository;
use App\Form\CommentType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;

class RecipeController extends AbstractController
{

    #[Route('/recette/new/', name: 'createRecipe')]
    public function createRecipe(Request $request, ManagerRegistry $manager): Response
    {
        $recipe = new Recipe();

        $recipeForm = $this->createForm(RecipeType::class, $recipe);

        $recipeForm->handleRequest($request);

        if ($recipeForm->isSubmitted() && $recipeForm->isValid()) {


            $imageFile = $recipeForm['image']->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gestion des erreurs de déplacement du fichier
                }
                $recipe->setImage($newFilename);
            }

            $user = $this->getUser();
            $recipe->setUser($user);

            $entityManager = $manager->getManager();
            $entityManager->persist($recipe);
            $entityManager->flush();

            return $this->redirectToRoute('mes_recettes');
        }

        return $this->render('recipe/createRecipe.html.twig', [
            'recetteForm' => $recipeForm->createView(),
        ]);
    }











    #[Route('/edit_recette/{id}', name: 'edit_recette')]
    public function editRecipe($id, Request $request, ManagerRegistry $manager, RecipeRepository $recipeRepository): Response
    {
        $recipe = $recipeRepository->find($id);

        if (!$recipe|| $recipe->getUser() !== $this->getUser()) {
            throw $this->createNotFoundException('Recette non trouvée ou vous n\'êtes pas autorisé à la modifier.');
        }

        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form['image']->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $recipe->setImage($newFilename);
            }

            $entityManager = $manager->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('mes_recettes');
        }

        return $this->render('recipe/editRecipe.html.twig', [
            'form' => $form->createView(),
        ]);
    }






    #[Route('/delete_recette/{id}', name: 'delete_recette')]
    public function deleteRecipe($id, ManagerRegistry $manager, RecipeRepository $recipeRepository): Response
    {
        $recipe = $recipeRepository->find($id);

        if (!$recipe || $recipe->getUser() !== $this->getUser()) {
            throw $this->createNotFoundException('Recette non trouvée ou vous n\'êtes pas autorisé à la supprimer.');
        }

        $entityManager = $manager->getManager();
        $entityManager->remove($recipe);
        $entityManager->flush();

        return $this->redirectToRoute('mes_recettes');
    }





    #[Route('/mes-recettes/', name: 'mes_recettes')]
    public function myRecipes(RecipeRepository $recipeRepository): Response
    {
        $user = $this->getUser();
        $myRecipes = $recipeRepository->findBy(['user' => $user]);

        return $this->render('recipe/myRecipes.html.twig', [
            'mesRecettes' => $myRecipes,
        ]);
    }






    #[Route('/toutes-les-recettes/', name: 'toutes_les_recettes')]
    public function fullRecipes(RecipeRepository $recipeRepository, Request $request, ManagerRegistry $manager, FormFactoryInterface $formFactory): Response
    {
        $fullRecipes = $recipeRepository->findAll();
        $commentForms = [];

        foreach ($fullRecipes as $recipe) {
            $commentForm = $formFactory->createNamedBuilder(
                'comment_' . $recipe->getId(),
                CommentType::class
            )
            ->getForm();

            $commentForms[$recipe->getId()] = $commentForm->createView();

            $commentForm->handleRequest($request);

            if (!$commentForm->isSubmitted()) {
                continue;
            }

            if ($commentForm->isValid()) {
                $comment = $commentForm->getData();
                $comment->setRecette($recipe);

                $user = $this->getUser();
                if ($user) {
                    $comment->setUser($user);
                } else {
                }

                $comment->setCreateAt(new \DateTime());

                $entityManager = $manager->getManager();
                $entityManager->persist($comment);
                $entityManager->flush();

                $commentForms[$recipe->getId()] = $formFactory->createNamedBuilder(
                    'comment_' . $recipe->getId(),
                    CommentType::class
                )->getForm()->createView();
            }
        }

        return $this->render('recipe/fullRecipes.html.twig', [
            'toutesLesRecettes' => $fullRecipes,
            'commentForms' => $commentForms,
        ]);
    }


}