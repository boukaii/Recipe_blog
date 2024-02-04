<?php

namespace App\Controller\Recipe;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RecipeRepository;
use App\Entity\CategoryRecipe;


class RecipeController extends AbstractController
{
    #[Route('/recipe/{id}', name: 'app_recipe')]
    public function index(CategoryRecipe $category, RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->findBy(['categoryRecipe' => $category]);

        return $this->render('recipe/recipe.html.twig', [
            'controller_name' => 'RecipeController',
            'recipes' => $recipes,
        ]);
    }
}
