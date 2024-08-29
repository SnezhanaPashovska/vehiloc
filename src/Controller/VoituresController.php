<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VoitureRepository;
use App\Entity\Voiture;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\VoitureType;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/voiture/ajouter', name: 'app_add_car')]
    public function add(Request $request): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voiture = $form->getData();

            $this->entityManager->persist($voiture);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_car', ['id' => $voiture->getId()]);
        }

        return $this->render('add.html.twig', [
            'form' => $form->createView(),
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
