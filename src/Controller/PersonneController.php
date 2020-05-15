<?php

namespace App\Controller;

use App\Entity\Personne;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    /**
     * @Route("/personne", name="personne")
     */
    public function index(Request $request)
    {
        $page = $request->query->get('page') ?? 1;
        $repository = $this->getDoctrine()->getRepository(Personne::class);
        $nbEnregistrements = $repository->count(array());
        $nbpage = ($nbEnregistrements % 10) ? $nbEnregistrements / 10 + 1 : $nbEnregistrements / 10;
        $personne = $repository->findBy(array(), ['id'=>'asc'], 10, ($page - 1) * 10);
        return $this->render('personne/index.html.twig', [
            'personnes' => $personne,
            'nbPages' => $nbpage,
            'currentPage' => $page,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="personne.delete")
     */
    public function delete($id) {
        $repository = $this->getDoctrine()->getRepository(Personne::class);
        $personne = $repository->find($id);
        if (!$personne) {
            $this->addFlash('error', "La suppression a echoué, la personne n'existe pas");
        }
        else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($personne);
            $manager->flush();
            $this->addFlash('success', "personne supprimé avec succés");
        }
        return $this->redirectToRoute('personne');
    }
}
