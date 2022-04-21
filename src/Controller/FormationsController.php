<?php

namespace App\Controller;

use App\Entity\Formations;
use App\Form\FormationsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationsController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/formations", name="app_formations")
     */
    public function index(Request $request): Response
    {
        $formations = new Formations(); // Nouvelle instance de user (il hérite des propriétés du user)
        $form = $this->createForm(FormationsType::class, $formations); // Création du formulaire
        $form->handleRequest($request); // Traitement du formulaire
        if($form->isSubmitted() && $form->isValid()) { // Si le formulaire est soumis et validé alors..
            
            $this->manager->persist($formations); // On persister l'utilisateur (cela signifie elle prépare l'envoie des données)
            $this->manager->flush(); // On flush
            return $this->redirectToRoute('app_home'); // on redirige vers la page de connexion
        }
        
        return $this->render('formations/index.html.twig', [
            'myForm' => $form->createView() // On passe le formulaire à la vue, je pointe vers la fonction createView
        ]);
    }
    
    /**
     * @Route("/all/formations", name="app_all_formations")
     */
    public function affichage(): Response
    {
        $allformations = $this->manager->getRepository(Formations::class)->findAll();

        return $this->render('formations/allformations.html.twig', [
            'Formations' => $allformations,
        ]);
    }

     /**
     * @Route("/admin/delete/formations{id}", name="app_admin_delete_formations")
     */
    public function delete(Formations $formations): Response
    {
       $this->manager->remove($formations);
       $this->manager->flush();

       return $this->redirectToRoute('app_all_formations');
    }

     /**
     * @Route("/admin/edit/formations{id}", name="app_admin_edit_formations")
     */
    public function Edit(Formations $formations, Request $request): Response
    {
       
        $form = $this->createForm(FormationsType::class, $formations); // Création du formulaire
        $form->handleRequest($request); // Traitement du formulaire
        if($form->isSubmitted() && $form->isValid()) { // Si le formulaire est soumis et validé alors..
            

            $this->manager->persist($formations); // On persister l'utilisateur (cela signifie elle prépare l'envoie des données)
            $this->manager->flush(); // On flush
            return $this->redirectToRoute('app_all_formations'); // on redirige vers la page de connexion
        }
        
        return $this->render('formations/edit.html.twig', [
            'myForm' => $form->createView() // On passe le formulaire à la vue, je pointe vers la fonction createView
        ]);
    }
}
