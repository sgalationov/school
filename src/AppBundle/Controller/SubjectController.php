<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subject;
use AppBundle\Form\SubjectType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Subject controller.
 *
 * @Route("subject")
 */
class SubjectController extends Controller
{
    /**
     * Lists all subject entities.
     *
     * @Route("/", name="subject_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $subjects = $em->getRepository(Subject::class)->findAll();

        return $this->render('subject/index.html.twig', array(
            'subjects' => $subjects,
        ));
    }

    /**
     * Creates a new subject entity.
     *
     * @Route("/new", name="subject_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();

            return $this->redirectToRoute('subject_show', array('id' => $subject->getId()));
        }

        return $this->render('subject/new.html.twig', array(
            'subject' => $subject,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a subject entity.
     *
     * @Route("/{id}", name="subject_show")
     * @Method("GET")
     */
    public function showAction(Subject $subject)
    {
        return $this->render('subject/show.html.twig', array(
            'subject' => $subject,
        ));
    }

    /**
     * Displays a form to edit an existing subject entity.
     *
     * @Route("/{id}/edit", name="subject_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Subject $subject, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $subject = $em->getRepository(Subject::class)->find($id);

        if (!$subject) {
            throw $this->createNotFoundException('No task found for id '.$id);
        }

        $originalLectures = new ArrayCollection();

        // Создать ArrayCollection текущих объектов Tag в БД
        foreach ($subject->getLectures() as $lecture) {
            $originalLectures->add($lecture);
        }

        $editForm = $this->createForm(SubjectType::class, $subject);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // удалить отошения между тегом и Task
            foreach ($originalLectures as $lecture) {
                if (false === $subject->getSubjects()->contains($lecture)) {
                    // удалить Task из Tag
                    $lecture->getSubject()->removeElement($subject);

                    // если это было отношение многие-к-одному, удалить отношения, как это
                    // $tag->setTask(null);

                    $em->persist($lecture);

                    // если вы хотите удалить Tag полностью, вы также можете это сделать
                    // $em->remove($tag);
                }
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subject_edit', array('id' => $subject->getId()));
        }

        return $this->render('subject/edit.html.twig', array(
            'subject' => $subject,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a subject entity.
     *
     * @Route("/delete/{id}", name="subject_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Subject $subject)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($subject);
        $em->flush();

        return $this->redirectToRoute('subject_index');
    }
}
