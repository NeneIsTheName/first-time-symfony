<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PokemonRepository;
use App\Entity\Pokemon;
use App\Form\PokemonType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class PokemonController extends AbstractController
{
    #[Route('/pokemons', name: 'pokemon_index')]
    public function index(PokemonRepository $repository): Response
    {
        return $this->render('pokemon/index.html.twig', [
            'pokemons' => $repository->findAll(),
        ]);
    }

    #[Route('/pokemon/{id<\d+>}', name: "pokemon_show")]
    public function show(Pokemon $pokemon): Response
    {
        return $this->render('pokemon/pokemon.html.twig', [
            'pokemon' => $pokemon,
        ]);
    }

    #[Route('/pokemon/new', name: "pokemon_new")]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $pokemon = new Pokemon;

        $form = $this->createForm(PokemonType::class, $pokemon);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($pokemon);

            $manager->flush();

            $this->addFlash(
                'notice',
                'Pokemon created succesfully!'
            );

            return $this->redirectToRoute("pokemon_show", [
                "id" => $pokemon->getId(),
            ]);
        }

        return $this->render('pokemon/new.html.twig', [
            "form" => $form,
        ]);
    }

    #[Route('/pokemon/{id<\d+>}/edit', name: "pokemon_edit")]
    public function edit(Pokemon $pokemon, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(PokemonType::class, $pokemon);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->flush();

            $this->addFlash(
                'notice',
                'Pokemon updated succesfully!'
            );

            return $this->redirectToRoute("pokemon_show", [
                "id" => $pokemon->getId(),
            ]);
        }

        return $this->render('pokemon/edit.html.twig', [
            "form" => $form,
        ]);
    }

    #[Route('/pokemon/{id<\d+>}/delete', name: "pokemon_delete")]
    public function delete(Pokemon $pokemon, Request $request, EntityManagerInterface $manager): Response
    {
        if($request->isMethod(('POST'))){
            $manager->remove($pokemon);

            $manager->flush();

            $this->addFlash(
                'notice',
                "Pokemon deleted successfully"
            );

            return $this->redirectToRoute('pokemon_index');
        }

        return $this->render("pokemon/delete.html.twig", [
            "id" => $pokemon->getId(),
        ]);
    }
}
