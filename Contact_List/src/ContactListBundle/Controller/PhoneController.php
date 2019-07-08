<?php

namespace ContactListBundle\Controller;

use ContactListBundle\Entity\Phone;
use ContactListBundle\Form\PhoneType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PhoneController
 * @package ContactListBundle\Controller
 * @Route("/phone")
 */
class PhoneController extends Controller
{
    /**
     * @Route("/new/", name="new_phone_form", methods={"GET"})
     */
    public function newPhoneAction()
    {
        $phone = new Phone();
        $form = $this->createForm(PhoneType::class, $phone);

        return $this->render('@ContactList/formTemplate.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/new/", name="save_new_phone", methods={"POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function saveNewPhoneAction(Request $request)
    {
        $phone = new Phone();
        $form = $this->createForm(PhoneType::class, $phone);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $phone = $form->getData();
            $phone->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($phone);
            $em->flush();

            return $this->redirectToRoute('show_all_persons');
        }
        return $this->render('@ContactList/formTemplate.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param $id
     * @return Response
     * @Route("/{id}/", name="show_phone_by_id", methods={"GET"}, requirements={"id" = "\d+"})
     */
    public function showPhoneByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Phone');
        $phone = $repository->findPhoneByIdWithUser($id, $this->getUser());

        return $this->render('@ContactList/Phone/showPhoneById.html.twig', ['phone' => $phone]);
    }

    /**
     * @return Response
     * @Route("/", name="show_all_phones", methods={"GET"})
     */
    public function showAllPhonesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Phone');
        $phones = $repository->findPhoneByUser($this->getUser());

        return $this->render('@ContactList/Phone/showAllPhones.html.twig', ['phones' => $phones]);
    }

    /**
     * @param $id
     * @return Response
     * @Route("/{id}/modify/", name="modify_phone_form", methods={"GET"})
     */
    public function modifyPhoneFormAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Phone");
        $phone = $repository->findPhoneByIdWithUser($id, $this->getUser());

        $form = $this->createForm(PhoneType::class, $phone);

        return $this->render('@ContactList/formTemplate.html.twig', ['form' => $form->createView(), 'id' => $phone->getId()]);

    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/{id}/modify/", name="modify_phone", methods={"POST"})
     * @return RedirectResponse|Response
     */
    public function modifyPhoneAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Phone");
        $phone = $repository->findPhoneByIdWithUser($id, $this->getUser());

        $form = $this->createForm(PhoneType::class, $phone);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('show_all_persons');
        }
        return $this->render('@ContactList/formTemplate.html.twig', ['form' => $form->createView(), 'id' => $phone->getId()]);
    }

    /**
     * @param $id
     * @Route("/{id}/delete/", methods={"GET"}, name="delete_phone_question")
     * @return Response
     */
    public function deletePhoneQuestionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Phone");
        $phone = $repository->findPhoneByIdWithUser($id, $this->getUser());

        return $this->render('@ContactList/Phone/deletePhoneForm.html.twig');
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @Route("/{id}/delete/", name="delete_phone", methods={"POST"})
     */
    public function deletePhoneAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Phone');
        $phone = $repository->findPhoneByIdWithUser($id, $this->getUser());
        $personRepo = $em->getRepository('ContactListBundle:Person');
        $persons = $personRepo->findPersonWithPhone($id);
        foreach ($persons as $person) {
            $person->setPhone(null);
        }

        $em->remove($phone);
        $em->flush();

        return $this->redirectToRoute('show_all_persons');

    }
}
