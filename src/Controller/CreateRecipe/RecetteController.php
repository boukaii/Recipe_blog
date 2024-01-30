<?php

namespace App\Controller\CreateRecipe;

use App\Entity\Recette;
use App\Form\RecetteType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\RecetteRepository;
use App\Form\CommentType;
use App\Entity\Comment;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RecetteController extends AbstractController
{

    #[Route('/recette/new/', name: 'new_recette')]
    public function createRecette(Request $request, ManagerRegistry $manager): Response
    {
        $recette = new Recette();

        $recetteForm = $this->createForm(RecetteType::class, $recette);

        $recetteForm->handleRequest($request);

        if ($recetteForm->isSubmitted() && $recetteForm->isValid()) {
           

            $imageFile = $recetteForm['image']->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gestion des erreurs de déplacement du fichier
                }
                $recette->setImage($newFilename);
            }

            $user = $this->getUser();
            $recette->setUser($user);

            $entityManager = $manager->getManager();
            $entityManager->persist($recette);
            $entityManager->flush();

            return $this->redirectToRoute('mes_recettes');
        }

        return $this->render('recette/new_recette.html.twig', [
            'recetteForm' => $recetteForm->createView(),
        ]);
    }

    #[Route('/edit_recette/{id}', name: 'edit_recette')]
    public function editRecette($id, Request $request, ManagerRegistry $manager, RecetteRepository $recetteRepository): Response
    {
        $recette = $recetteRepository->find($id);
    
        if (!$recette || $recette->getUser() !== $this->getUser()) {
            throw $this->createNotFoundException('Recette non trouvée ou vous n\'êtes pas autorisé à la modifier.');
        }
    
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form['image']->getData();
    
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $recette->setImage($newFilename);
            }
    
            $entityManager = $manager->getManager();
            $entityManager->flush();
    
            return $this->redirectToRoute('mes_recettes');
        }
    
        return $this->render('recette/edit_recette.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/delete_recette/{id}', name: 'delete_recette')]
    public function deleteRecette($id, ManagerRegistry $manager, RecetteRepository $recetteRepository): Response
    {
        $recette = $recetteRepository->find($id);

        if (!$recette || $recette->getUser() !== $this->getUser()) {
            throw $this->createNotFoundException('Recette non trouvée ou vous n\'êtes pas autorisé à la supprimer.');
        }

        $entityManager = $manager->getManager();
        $entityManager->remove($recette);
        $entityManager->flush();

        return $this->redirectToRoute('mes_recettes');
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
    public function toutesLesRecettes(RecetteRepository $recetteRepository): Response
    {
        $toutesLesRecettes = $recetteRepository->findAll();

        return $this->render('recette/toutes_les_recettes.html.twig', [
            'toutesLesRecettes' => $toutesLesRecettes,
        ]);
    }
















    public function comment(RecetteRepository $recetteRepository, Request $request, ManagerRegistry $manager): Response
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