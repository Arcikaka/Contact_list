<?php

namespace ContactListBundle\Controller;

use ContactListBundle\Entity\Groups;
use ContactListBundle\Form\GroupsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GroupsController
 * @package ContactListBundle\Controller
 * @Route("/groups")
 */
class GroupsController extends Controller
{
    /**
     * @Route("/new/", name="new_group_form", methods={"GET"})
     */
    public function newGroupAction()
    {
        $group = new Groups();
        $form = $this->createForm(GroupsType::class, $group);

        return $this->render('@ContactList/formTemplate.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/new/", name="save_new_group", methods={"POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function saveNewGroupAction(Request $request)
    {
        $group = new Groups();
        $form = $this->createForm(GroupsType::class, $group);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $group = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute('show_group_by_id', ['id' => $group->getId()]);
        }
        return $this->render('@ContactList/formTemplate.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param $id
     * @Route("/{id}/", name="show_group_by_id", requirements={"id" = "\d+"}, methods={"GET"})
     * @return Response
     */
    public function showGroupById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Groups');
        $group = $repository->find($id);

        return $this->render('@ContactList/Groups/showGroupById.html.twig', ['group' => $group]);

    }

    /**
     * @Route("/", name="show_all_groups", methods={"GET"})
     */
    public function showAllGroups()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Groups');
        /** @var Groups[] $groups */
        $groups = $repository->findAll();

        return $this->render('@ContactList/Groups/showAllGroups.html.twig', ['groups' => $groups]);
    }

    /**
     * @param $id
     * @return Response
     * @Route("/{id}/modify/", name="modify_group_form", methods={"GET"}, requirements={"id" = "\d+"})
     */
    public function modifyGroupFormAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Groups");
        $group = $repository->find($id);

        $form = $this->createForm(GroupsType::class, $group);

        return $this->render('@ContactList/formTemplate.html.twig', ['form' => $form->createView(), 'id' => $group->getId()]);

    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/{id}/modify/", name="modify_group", methods={"POST"})
     * @return RedirectResponse|Response
     */
    public function modifyGroupAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Groups");
        $group = $repository->find($id);

        $form = $this->createForm(GroupsType::class, $group);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $group = $form->getData();
            $em->flush();

            return $this->redirectToRoute('show_all_groups');
        }
        return $this->render('@ContactList/formTemplate.html.twig', ['form' => $form->createView(), 'id' => $group->getId()]);
    }

    /**
     * @param $id
     * @Route("/{id}/delete/", methods={"GET"}, name="delete_group_question")
     * @return Response
     */
    public function deleteGroupQuestionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Groups");
        $group = $repository->find($id);

        return $this->render('@ContactList/Groups/deleteGroupForm.html.twig');
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @Route("/{id}/delete/", name="delete_group", methods={"POST"})
     */
    public function deleteGroupAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Groups');
        $group = $repository->find($id);
        $personRepo = $em->getRepository('ContactListBundle:Person');
        $persons = $personRepo->findPersonWithGroup($id);
        foreach ($persons as $person){
            $person->removeGroups($group);
        }

        $em->remove($group);
        $em->flush();

        return $this->redirectToRoute('show_all_persons');

    }
}
