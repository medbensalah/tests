<?php

namespace App\Controller;

use App\Entity\Personne;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    /**
     * @Route("/personne", name="personne")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Personne::class);
        $personne = $repository->findAll();
        return $this->render('personne/index.html.twig', [
            'personnes' => $personne,
        ]);
    }
}
