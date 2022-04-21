<?php

namespace App\Controller;

use App\Entity\Projets;
use App\Form\ProjetsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProjetsController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }
    /**
     * @Route("/admin/projets", name="app_projets")
     */
    public function index(Request $request, SluggerInterface $slugger): Response
    {
        $projets = new Projets();
        $formProjets = $this->createForm(ProjetsType::class, $projets);
        $formProjets->handleRequest($request);
        if ($formProjets->isSubmitted() && $formProjets->isValid()) {

            $photoProjets = $formProjets->get('image')->getData();

            if($photoProjets){
                $originalFilename = pathinfo
                ($photoProjets->getClientOriginalName(),PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.
                $photoProjets->guessExtension();
                try{
                    $photoProjets->move(
                        $this->getParameter('image'),
                        $newFilename
                    );
                }catch (FileException $e){

                }
                $projets->setImage($newFilename);
            }
            
            $this->manager->persist($projets);
            $this->manager->flush();
            return $this->redirectToRoute('app_projets');
        };

        return $this->render('projets/index.html.twig', [
            'formProjets' => $formProjets->createView(),
        ]);
    }

    /**
     * @Route("/all/projets", name="app_all_projets")
     */
    public function affichage(): Response
    {
        $allProjets = $this->manager->getRepository(Projets::class)->findAll();

        return $this->render('projets/allProjets.html.twig', [
            'Projets' => $allProjets,
        ]);
    }
    
     /**
     * @Route("/admin/delete/projets{id}", name="app_admin_delete_projets")
     */
    public function delete(Projets $projets): Response
    {
       $this->manager->remove($projets);
       $this->manager->flush();

       return $this->redirectToRoute('app_all_projets');
    }

     /**
     * @Route("/admin/single/projets{id}", name="app_single_projets")
     */
    public function affichageprojet(Projets $projets): Response
    {
        $Projets = $this->manager->getRepository(Projets::class)->find($projets);

        return $this->render('projets/singleprojets.html.twig', [
            'Projets' => $Projets,
        ]);
    }

     /**
     * @Route("/admin/edit/projets/{id}", name="app_admin_edit_projets")
     */
    public function edit(Projets $projets, Request $request, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProjetsType::class, $projets); // Création du formulaire
        $form->handleRequest($request); // Traitement du formulaire
        if ($form->isSubmitted() && $form->isValid()) {

            $photoProjets = $form->get('image')->getData();
       
            if($photoProjets){
           $originalFilename = pathinfo($photoProjets->getClientOriginalName(),PATHINFO_FILENAME);
           $safeFilename = $slugger->slug($originalFilename);
           $newFilename = $safeFilename.'-'.uniqid().'.'.$photoProjets->guessExtension();
             try {
                $photoProjets->move(
                    $this->getParameter('image'),
                    $newFilename
                );
             }catch (FileException $e){

             }
              $projets->setImage($newFilename);
            
            }

            $this->manager->persist($projets);
            $this->manager->flush();
            return $this->redirectToRoute('app_home');
    };

    return $this->render('projets/edit.html.twig', [
        'formProjets' => $form->createView(),
    ]);
    }
}
