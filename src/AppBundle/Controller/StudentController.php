<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Student;
use AppBundle\Form\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Student controller.
 *
 * @Route("student")
 */
class StudentController extends Controller
{
    /**
     * Lists all student entities.
     *
     * @Route("/", name="student_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $students = $em->getRepository(Student::class)->findAll();

        return $this->render('student/index.html.twig', array(
            'students' => $students,
        ));
    }

    /**
     * Lists all student entities.
     *
     * @Route("/print", name="student_print")
     * @Method("GET")
     */
    public function printAction()
    {
        $em = $this->getDoctrine()->getManager();

        $students = $em->getRepository(Student::class)->findAll();

        $pdf = $this
            ->get("white_october.tcpdf")
            ->create('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $format = '90x130';
        $filename = "Бейджи участников ".$format;
        $pdf->AddPage('L', explode('x', $format));
        $html = $this->renderView('student/list.html.twig', array(
            'students' => $students,
        ));
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

        return $pdf->Output($filename . '.pdf', 'I');
    }

    /**
     * Creates a new student entity.
     *
     * @Route("/new", name="student_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoder = $this->get('security.password_encoder');
            $student->setPassword($encoder->encodePassword($student, $form->get('password')->getData()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('student_show', array('id' => $student->getId()));
        }

        return $this->render('student/new.html.twig', array(
            'student' => $student,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a student entity.
     *
     * @Route("/{id}", name="student_show")
     * @Method("GET")
     */
    public function showAction(Student $student)
    {
        return $this->render('student/show.html.twig', array(
            'student' => $student,
        ));
    }

    /**
     * Displays a form to edit an existing student entity.
     *
     * @Route("/{id}/edit", name="student_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Student $student)
    {
        $editForm = $this->createForm(StudentType::class, $student);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('student_edit', array('id' => $student->getId()));
        }

        return $this->render('student/edit.html.twig', array(
            'student' => $student,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a student entity.
     *
     * @Route("/delete/{id}", name="student_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Student $student)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($student);
            $em->flush();

        return $this->redirectToRoute('student_index');
    }
}
