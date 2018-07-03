<?php
/**
 * Created by PhpStorm.
 * User: Юрий
 * Date: 29.06.2018
 * Time: 22:28
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MenuController extends Controller
{
    /**
     * @Route("/menu", name="menu")
     */
    public function indexAction(Request $request)
    {
        $mas = ['employee', 'lecture', 'student', 'subject', 'university'];
        // replace this example code with whatever you need
        return $this->render('menu.html.twig', [
            'menu' => $mas
        ]);
    }
}