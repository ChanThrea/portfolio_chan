<?php

namespace App\Controller;

use App\Entity\Experiences;
use App\Form\ExperiencesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExperiencesController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/experiences", name="app_experiences")
     */
    public function index(Request $request): Response
    {
        $experiences = new Experiences(); 
        $form = $this->createForm(ExperiencesType::class, $experiences);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) { 
            


            $this->manager->persist($experiences);
            $this->manager->flush(); 
            return $this->redirectToRoute('app_experiences');
        }
        
        return $this->render('experiences/ajout.html.twig', [
            'myForm' => $form->createView()
        ]);
    }

/**
 * @Route("/all/experiences", name="app_all_experiences")
 */

    public function afficher(): Response
    {
        $experiences = $this->manager->getRepository(Experiences::class)->findAll();

        return $this->render('experiences/index.html.twig', [
            'experiences' => $experiences,
        ]);
    }
}
