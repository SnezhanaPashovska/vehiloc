<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\VoitureRepository;
use App\Entity\Voiture;

class VoituresController extends AbstractController
{
    private VoitureRepository $voitureRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(VoitureRepository $voitureRepository, EntityManagerInterface $entityManager)
    {
        $this->voitureRepository = $voitureRepository;
        $this->entityManager = $entityManager;
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

    #[Route('/voiture/{id}/supprimer', name: 'app_car_delete')]
    public function supprimer(int $id): Response 
    {
        $voiture = $this->voitureRepository->find($id);

        if (!$voiture) {
            return $this->redirectToRoute('app_home');
        }

        //Supprimer la voiture
        $this->entityManager->remove($voiture);
        $this->entityManager->flush();

        //Redirection vers la page d'accueil
        return $this->redirectToRoute('app_home');
    }
}
