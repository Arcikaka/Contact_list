<?php

namespace ContactListBundle\Controller;

use ContactListBundle\Entity\Address;
use ContactListBundle\Form\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends Controller
{
    //TODO make action for Address form, and action for saving new Address into the database

    /**
     * @\Symfony\Component\Routing\Annotation\Route("newAddress/", name="new_Address_form", methods={"GET"})
     */
    public function newAddressAction()
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);

        return $this->render('@ContactList/newAddressForm.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("{id}/modify/", name="save_new_Address", methods={"POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function saveNewAddressAction(Request $request)
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            return $this->redirectToRoute('');
        }
        return $this->render('@ContactList/newAddressForm.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @param $id
     * @Route("{id}/modify/", name="modify_Address", methods={"POST"})
     * @return RedirectResponse|Response
     */
    public function modifyAddressAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Address");
        $address = $repository->find($id);

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();
            $em->flush();

            return $this->redirectToRoute('show_all_persons');
        }
        return $this->render('@ContactList/modifyAddressForm.html.twig', ['form' => $form->createView(), 'id' => $address->getId()]);
    }

    /**
     * @param $id
     * @Route("{id}/delete/", methods={"GET"}, name="delete_Address_question")
     * @return Response
     */
    public function deleteAddressQuestionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Address");
        $address = $repository->find($id);

        return $this->render('@ContactList/deleteAddressForm.html.twig');
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @Route("{id}/delete/", name="delete_Address", methods={"POST"})
     */
    public function deleteAddressAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Address');
        $address = $repository->find($id);

        $em->remove($address);
        $em->flush();

        return $this->redirectToRoute('show_all_persons');

    }
}
