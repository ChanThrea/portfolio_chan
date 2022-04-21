<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
   public function __construct(EntityManagerInterface $manager){
       $this->manager = $manager;
   }
   
    /**
     * @Route("/admin/contact", name="app_contact")
     */
    public function index(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $this->manager->persist($contact); // On persister l'utilisateur (cela signifie elle prépare l'envoie des données)
            $this->manager->flush(); // On flush
            return $this->redirectToRoute('app_home'); // on redirige vers la page de connexion
        }

        return $this->render('contact/index.html.twig', [
            'myForm' => $form->createView()
        ]);
        
    }

     /**
     * @Route("/admin/all/contact", name="app_admin_contact")
     */
    public function toutlesmessage(): Response
    {
       
        $message = $this->manager->getRepository(Contact::class)->findAll();
        return $this->render('contact/messagerie.html.twig', [

            'message' => $message,

        ]);
    }

    /**
     * @Route("/admin/delete/contact{id}", name="app_admin_delete_contact")
     */
    public function delete(Contact $contact): Response
    {
       $this->manager->remove($contact);
       $this->manager->flush();

       return $this->redirectToRoute('app_admin_contact');
    }
}
