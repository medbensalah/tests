<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Personne;
use App\Entity\Section;
use App\Entity\SocialMedia;
use App\Form\PersonneType;
use Doctrine\ORM\Decorator\EntityManagerDecorator;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/addFake", name="personne.add.fake")
     */

    public function addFakePersonne(EntityManagerInterface $manager) {
        $personne = new Personne();
        $personne->setFirstname('Mohamed');
        $personne->setName('Ben Salah');
        $personne->setCin('54531510');
        $personne->setAge('21');
        $personne->setPath('im.jpg');
        $personne->setJob('Student');

        $socialMedia = new SocialMedia();
        $socialMedia->setFb('facebook');
        $socialMedia->setLinkedin('Linked In');

        $personne->setSocialMedia($socialMedia);

        $cours = new Cours();
        $cours->setDesignation('web');
        $cours2 = new Cours();
        $cours2->setDesignation('algo');

        $manager->persist($cours);
        $manager->persist($cours2);

        $section = new Section();
        $section->setDesignation('GL');

        $manager->persist($section);

        $personne->addCour($cours);
        $personne->addCour($cours2);

        $personne->setSection($section);

        $manager->persist($personne);

        $manager->flush();
        return $this->redirectToRoute('personne');
    }

    /**
     * @Route("/add", name="personne.add")
     */

    public function addPersonne() {
        $personne = new Personne();

        $form = $this->createForm(PersonneType::class, $personne);
        return $this->render('personne/edit.html.twig', array(
            'form'=>$form->createView()
        ));
    }

}
