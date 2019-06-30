<?php

namespace ContactListBundle\Controller;

use ContactListBundle\Entity\Email;
use ContactListBundle\Form\EmailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EmailController
 * @package ContactListBundle\Controller
 * @Route("/Email")
 */
class EmailController extends Controller
{
    /**
     * @Route("/new/", name="new_email_form", methods={"GET"})
     */
    public function newEmailAction()
    {
        $email = new Email();
        $form = $this->createForm(EmailType::class, $email);

        return $this->render('@ContactList/Email/newEmailForm.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/{id}/modify/", name="save_new_email", methods={"POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function saveNewEmailAction(Request $request)
    {
        $email = new Email();
        $form = $this->createForm(EmailType::class, $email);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->flush();

            return $this->redirectToRoute('');
        }
        return $this->render('@ContactList/Email/newEmailForm.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param $id
     * @Route("/{id}/", name="show_email_by_id", requirements={"id" = "\d+"}, methods={"GET"})
     * @return Response
     */
    public function showEmailById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Email');
        $email = $repository->find($id);

        return $this->render('@ContactList/Email/showEmailById.html.twig', ['email' => $email]);

    }

    /**
     * @Route("/", name="show_all_emails", methods={"GET"})
     */
    public function showAllAddress()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Address');
        /** @var Email[] $emails */
        $emails = $repository->findAll();

        return $this->render('@ContactList/Email/showAllEmails.html.twig', ['emails' => $emails]);
    }

    /**
     * @param $id
     * @return Response
     * @Route("/{id}/modify/", name="modify_email_form", methods={"GET"}, requirements={"id" = "\d+"})
     */
    public function modifyEmailFormAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Email");
        $email = $repository->find($id);

        $form = $this->createForm(EmailType::class, $email);

        return $this->render('@ContactList/Email/modifyEmailForm.html.twig', ['form' => $form->createView(), 'id' => $email->getId()]);

    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/{id}/modify/", name="modify_Email", methods={"POST"})
     * @return RedirectResponse|Response
     */
    public function modifyEmailAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Email");
        $email = $repository->find($id);

        $form = $this->createForm(EmailType::class, $email);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData();
            $em->flush();

            return $this->redirectToRoute('show_all_persons');
        }
        return $this->render('@ContactList/Email/modifyEmailForm.html.twig', ['form' => $form->createView(), 'id' => $email->getId()]);
    }

    /**
     * @param $id
     * @Route("/{id}/delete/", methods={"GET"}, name="delete_Email_question")
     * @return Response
     */
    public function deleteEmailQuestionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactListBundle:Email");
        $email = $repository->find($id);

        return $this->render('@ContactList/Email/deleteEmailForm.html.twig');
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @Route("/{id}/delete/", name="delete_Email", methods={"POST"})
     */
    public function deleteEmailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactListBundle:Email');
        $email = $repository->find($id);

        $em->remove($email);
        $em->flush();

        return $this->redirectToRoute('show_all_persons');

    }
}

