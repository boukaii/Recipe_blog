<?php

namespace App\Controller\Recipe;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RecipeRepository;

class RecipeController extends AbstractController
{
    #[Route('/recipe/{id}', name: 'app_recipe')]
    public function index($id, RecipeRepository $RecipeRepository): Response
    {

        $recipes = $RecipeRepository->find($id);

        return $this->render('recipe/recipe.html.twig', [
            'controller_name' => 'RecipeController',
            'recipes' => $recipes,
        ]);
    }
}
