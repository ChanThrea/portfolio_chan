<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Form\CompetencesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompetencesController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }
    
    /**
     * @Route("/competences", name="app_competences")
     */
    public function index(Request $request): Response
    {
        $competences = new Competences();
        $form = $this->createForm(CompetencesType::class, $competences);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) { 
            
            $this->manager->persist($competences); 
            $this->manager->flush();
            return $this->redirectToRoute('app_home'); 
        }    
        return $this->render('competences/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/all/competences", name="app_all_competences")
     */
    public function allcomp(): Response
    {
        $allcompetences = $this->manager->getRepository(Competences::class)->findAll();
        
        return $this->render('competences/allcompetences.html.twig', [
            'competences' => $allcompetences,
        ]);
    }


}
