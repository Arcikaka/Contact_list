<?php

namespace ContactListBundle\Controller;

use ContactListBundle\Entity\Person;
use ContactListBundle\Form\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends Controller
{
    /**
     * @\Symfony\Component\Routing\Annotation\Route("new/", name="new_person", methods={"GET"})
     */
    public function newPersonAction()
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);

        return $this->render('@ContactList/newPersonForm.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/new/", methods={"POST"}, name="create_new_person", methods={"POST"})
     */
    public function createNewPerson(Request $request)
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            return $this->redirectToRoute('show_user_by_id', ['id' => $person->getId()]);
        }
        return $this->redirectToRoute('new_person', ['form' => $form->createView()]);
    }

    /**
     * @param $id
     * @Route("/{id}/", name="show_user_by_id", requirements={"id" = "\d+"}, methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPersonById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Person");
        $person = $repository->find($id);

        return $this->render('@ContactList/showPersonById.html.twig', ['person' => $person]);

    }

    /**
     * @Route("/", name="show_all_persons", methods={"GET"})
     */
    public function showAllPersons()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Person");
        /** @var Person[] $persons */
        $persons = $repository->findAll();

        return $this->render("@ContactList/showAll.html.twig", ['persons' => $persons]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/modify/", name="modify_person_form", methods={"GET"})
     */
    public function modifyPersonFormAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository('ContactListBundle:Person')->find($id);
        $form = $this->createForm(PersonType::class, $person);


        return $this->render('@ContactList/modyfiPersonForm.html.twig', ['form' => $form->createView(),
            'person' => $person]);
    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/{id}/modify/", name="modify_person", methods={"POST"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function modifyPersonActon(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Person");
        $person = $repository->find($id);
        $form = $this->createForm(PersonType::class, $person);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();
            $em->flush();

            return $this->redirectToRoute('show_user_by_id', ['id' => $person->getId()]);
        }
        return $this->redirectToRoute('modify_person_form', ['form' => $form->createView(), 'id' => $person->getId()]);
    }

    /**
     * @param $id
     * @Route("/{id}/delete/", name="delete_person_form", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deletePersonQuestionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Person");
        $person = $repository->find($id);

        return $this->render('@ContactList/deletePersonForm.html.twig');

    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/{id}/delete/", name="delete_person", methods={"POST"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deletePersonAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Person');
        $person = $repository->find($id);

        $em->remove($person);
        $em->flush();

        return $this->redirectToRoute('show_all_persons');
    }
}
