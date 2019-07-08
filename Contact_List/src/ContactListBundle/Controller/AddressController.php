<?php

namespace ContactListBundle\Controller;

use ContactListBundle\Entity\Address;
use ContactListBundle\Form\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AddressController
 * @package ContactListBundle\Controller
 * @Route("/address")
 */
class AddressController extends Controller
{
    /**
     * @Route("/new/", name="new_address_form", methods={"GET"})
     */
    public function newAddressAction()
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);

        return $this->render('@ContactList/formTemplate.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/new/", name="save_new_address", methods={"POST"})
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
            $address->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            return $this->redirectToRoute('show_address_by_id', ['id' => $address->getId()]);
        }
        return $this->render('@ContactList/formTemplate.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param $id
     * @Route("/{id}/", name="show_address_by_id", requirements={"id" = "\d+"}, methods={"GET"})
     * @return Response
     */
    public function showAddressById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Address');
        $address = $repository->findAddressByIdWithUser($id, $this->getUser());

        return $this->render('@ContactList/Address/showAddressById.html.twig', ['address' => $address]);

    }

    /**
     * @Route("/", name="show_all_address", methods={"GET"})
     */
    public function showAllAddress()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Address');
        /** @var Address[] $addresses */
        $addresses = $repository->findAddressByUser($this->getUser());

        return $this->render('@ContactList/Address/showAllAddress.html.twig', ['addresses' => $addresses]);
    }

    /**
     * @param $id
     * @return Response
     * @Route("/{id}/modify/", name="modify_address_form", methods={"GET"})
     */
    public function modifyAddressFormAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $address = $em->getRepository('ContactListBundle:Address')->findAddressByIdWithUser($id, $this->getUser());
        $form = $this->createForm(AddressType::class, $address);


        return $this->render('@ContactList/formTemplate.html.twig', ['form' => $form->createView(),
            'address' => $address]);
    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/{id}/modify/", name="modify_address", methods={"POST"})
     * @return RedirectResponse|Response
     */
    public function modifyAddressAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Address");
        $address = $repository->findAddressByIdWithUser($id, $this->getUser());

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('show_all_address');
        }
        return $this->render('@ContactList/formTemplate.html.twig', ['form' => $form->createView(), 'id' => $address->getId()]);
    }

    /**
     * @param $id
     * @Route("/{id}/delete/", methods={"GET"}, name="delete_address_question")
     * @return Response
     */
    public function deleteAddressGetAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Address");
        $address = $repository->findAddressByIdWithUser($id, $this->getUser());

        return $this->render('@ContactList/Address/deleteAddressForm.html.twig');
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @Route("/{id}/delete/", name="delete_address", methods={"POST"})
     */
    public function deleteAddressAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Address');
        $address = $repository->findAddressByIdWithUser($id, $this->getUser());
        $personRepo = $em->getRepository('ContactListBundle:Person');
        $persons = $personRepo->findPersonWithAddress($id);
        foreach ($persons as $person){
            $person->setAddress(null);
        }

        $em->remove($address);
        $em->flush();

        return $this->redirectToRoute('show_all_persons');

    }
}
