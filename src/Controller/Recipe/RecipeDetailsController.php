<?php

namespace App\Controller\Recipe;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RecipeDetailsRepository;

class RecipeDetailsController extends AbstractController
{
    #[Route('/recipe/details/{id}', name: 'app_recipe_details')]
    public function index($id, RecipeDetailsRepository $recipeDetailsRepository): Response
    {
        $recipeDetails = $recipeDetailsRepository->findOneBy(['recipe' => $id]);

        if (!$recipeDetails) {
            throw $this->createNotFoundException('La recette demandée n\'a pas été trouvée');
        }
        
        return $this->render('recipe/recipe_details.html.twig', [
            'controller_name' => 'RecipeDetailsController',
            'recipeDetails' => $recipeDetails,
        ]);
    }
}
