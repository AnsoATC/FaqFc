<?php

namespace App\Controller\Manager;

use App\Entity\SearchTracker;
use App\Form\SearchTrackerType;
use App\Repository\SearchTrackerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/searchtracker")
 */
class SearchTrackerController extends AbstractController
{
    /**
     * @Route("/", name="search_tracker_index", methods={"GET"})
     */
    public function index(SearchTrackerRepository $searchTrackerRepository): Response
    {
        return $this->render('manager/search_tracker.html.twig', [
            'search_trackers' => $searchTrackerRepository->findAll(),
        ]);
    }
}
