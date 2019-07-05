<?php

namespace ContactListBundle\Controller;

use ContactListBundle\Entity\Person;
use ContactListBundle\Form\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends Controller
{
    /**
     * @Route("/new/", name="new_person", methods={"GET"})
     */
    public function newPersonAction()
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);

        return $this->render('@ContactList/formTemplate.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @Route("/new/", methods={"POST"}, name="create_new_person", methods={"POST"})
     */
    public function createNewPerson(Request $request)
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();
            $person->setUser($this->getUser());
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
     * @return Response
     */
    public function showPersonById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Person");
        $person = $repository->findPersonByIdWithUserId($id, $this->getUser()->getId());

        return $this->render('@ContactList/Person/showPersonById.html.twig', ['person' => $person]);

    }

    /**
     * @Route("/", name="show_all_persons", methods={"GET"})
     */
    public function showAllPersons()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Person");
        /** @var Person[] $persons */
        $persons = $repository->findPersonsByUserId($this->getUser()->getId());

        return $this->render("@ContactList/Person/showAllPerson.html.twig", ['persons' => $persons]);
    }

    /**
     * @param $id
     * @return RedirectResponse|Response
     * @Route("/{id}/modify/", name="modify_person_form", methods={"GET"})
     */
    public function modifyPersonFormAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository('ContactListBundle:Person')->find($id);
        $form = $this->createForm(PersonType::class, $person);


        return $this->render('@ContactList/formTemplate.html.twig', ['form' => $form->createView(),
            'person' => $person]);
    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/{id}/modify/", name="modify_person", methods={"POST"})
     * @return RedirectResponse
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
     * @return Response
     */
    public function deletePersonQuestionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Person");
        $person = $repository->find($id);

        return $this->render('@ContactList/Person/deletePersonForm.html.twig');

    }

    /**
     * @param $id
     * @return RedirectResponse
     * @Route("/{id}/delete/", name="delete_person", methods={"POST"})
     */
    public function deletePersonAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Person');
        $person = $repository->find($id);

        $em->remove($person);
        $em->flush();

        return $this->redirectToRoute('show_all_persons');
    }
}
