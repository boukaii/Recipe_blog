<?php

namespace App\Controller\Recipe;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RecipeDetailsRepository;

class RecipeDetailsController extends AbstractController
{
    #[Route('/recipe/details', name: 'app_recipe_details')]
    public function index(RecipeDetailsRepository $RecipeDetailsRepository): Response
    {

        $recipeDetails = $RecipeDetailsRepository->findAll();

        return $this->render('recipe/recipe_details.html.twig', [
            'controller_name' => 'RecipeDetailsController',
            'recipeDetails' => $recipeDetails,
        ]);
    }
}
