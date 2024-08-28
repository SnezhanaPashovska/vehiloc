<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\VoitureRepository;
use App\Entity\Voiture;

class VoituresController extends AbstractController
{

    public function __construct(
        private VoitureRepository $voitureRepository,
    )
    {

    }

    
    #[Route('/', name: 'app_home')]
    public function index(VoitureRepository $voitureRepository): Response
    {
        $voitures = $voitureRepository->findAll();

        return $this->render('accueil.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    #[Route('/voiture/{id}', name: 'app_car')]
    public function voiture(int $id): Response
    {
        $voiture = $this->voitureRepository->find($id);
       

        if(!$voiture) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('voiture.html.twig', [
            'voiture' => $voiture,
        ]);
    }
}
