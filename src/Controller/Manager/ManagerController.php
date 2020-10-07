<?php

namespace App\Controller\Manager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/manager")
 */
class ManagerController extends AbstractController
{
    /**
     * @Route("/", name="manager_index")
     */
    public function index()
    {
        return $this->render('manager/index.html.twig', [
            //Return all global statistics for the manager
            'controller_name' => 'ManagerController',
        ]);
    }
}
