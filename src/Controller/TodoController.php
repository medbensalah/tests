<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    /**
     * @Route("/todo", name="todo")
     */
    public function index(Request $request)
    {
        $session = $request->getSession();
        if(!$session->has('todos')){
            $todos =array('achat'=>'achatr cle usb',
                          'cours'=>'finaliser mon cours',
                          'correction'=>'corriger les examens');
            $session->set('todos', $todos);
            $this->addFlash('info','session initialisé avec succés');
        }

        return $this->render('todo/index.html.twig');
    }

    /**
     * @Route("/todo/add/{name}/{desc}",name="todo.add")
     */
    public function add(SessionInterface $session, $name, $desc) {
        if ($session->has('todos')) {
            $todos=$session->get('todos');
            if (isset($todos[$name])) {
                $this->addFlash('error', "le todo $name existe deja");
            }
            else {
                $todos[$name] = $desc;
                $session->set('todos', $todos);
                $this->addFlash('success', "le todo $name a ete ajoute avec succes");
            }
        }
        else {
            $this->addFlash('error', 'la session n exite pas');
        }
        return $this->redirectToRoute('todo');
    }

    /**
     * @Route("/todo/delete/{name}",name="todo.delete")
     */
    public function delete(SessionInterface $session, $name) {
        if ($session->has('todos')) {
            $todos=$session->get('todos');
            if (isset($todos[$name])) {
                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash('success', "le todo $name a ete supprime avec succes");
            }
            else {
                $this->addFlash('error', "le todo $name n\'existe pas");
            }
        }
        else {
            $this->addFlash('error', 'la session n exite pas');
        }
        return $this->redirectToRoute('todo');
    }

    /**
     * @Route("/todo/update/{name}/{desc}",name="todo.update")
     */
    public function update(SessionInterface $session, $name, $desc) {
        if ($session->has('todos')) {
            $todos=$session->get('todos');
            if (!isset($todos[$name])) {
                $this->addFlash('error', "le todo $name n\'existe pas");
            }
            else {
                $todos[$name] = $desc;
                $session->set('todos', $todos);
                $this->addFlash('success', "le todo $name a ete ajoute avec succes");
            }
        }
        else {
            $this->addFlash('error', 'la session n exite pas');
        }
        return $this->redirectToRoute('todo');
    }

    /**
     * @Route("/todo/logout", name="todo.logout")
     */
    public function logout(SessionInterface $session) {
        $session->clear();
        return $this->redirectToRoute('todo');
    }
}
