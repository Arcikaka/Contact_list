<?php

namespace ContactListBundle\Controller;

use ContactListBundle\Entity\Phone;
use ContactListBundle\Form\PhoneType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhoneController extends Controller
{
    //TODO make action for phone form and action for saving phone into the database
    /**
     * @\Symfony\Component\Routing\Annotation\Route("/newPhone/", name="new_phone_form", methods={"GET"})
     */
    public function newPhoneAction()
    {
        $phone = new Phone();
        $form = $this->createForm(PhoneType::class, $phone);

        return $this->render('@ContactList/newPhoneForm.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/{id}/modify/phone/", name="save_new_phone", methods={"POST"})
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($phone);
            $em->flush();

            return $this->redirectToRoute('show_all_persons');
        }
        return $this->render('@ContactList/newPhoneForm.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/{id}/modify/phone/", name="modify_phone", methods={"POST"})
     * @return RedirectResponse|Response
     */
    public function modifyPhoneAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Phone");
        $phone = $repository->find($id);

        $form = $this->createForm(PhoneType::class, $phone);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $phone = $form->getData();
            $em->flush();

            return $this->redirectToRoute('show_all_persons');
        }
        return $this->render('@ContactList/modifyPhoneForm.html.twig', ['form' => $form->createView(), 'id' => $phone->getId()]);
    }

    /**
     * @param $id
     * @Route("/{id}/delete/phone/", methods={"GET"}, name="delete_phone_question")
     * @return Response
     */
    public function deletePhoneQuestionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Phone");
        $phone = $repository->find($id);

        return $this->render('@ContactList/deletePhoneForm.html.twig');
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @Route("/{id}/delete/phone/", name="delete_phone", methods={"POST"})
     */
    public function deletePhoneAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Phone');
        $phone = $repository->find($id);

        $em->remove($phone);
        $em->flush();

        return $this->redirectToRoute('show_all_persons');

    }
}
