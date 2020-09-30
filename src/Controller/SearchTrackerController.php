<?php

namespace App\Controller;

use App\Entity\SearchTracker;
use App\Form\SearchTrackerType;
use App\Repository\SearchTrackerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/search/tracker")
 */
class SearchTrackerController extends AbstractController
{
    /**
     * @Route("/", name="search_tracker_index", methods={"GET"})
     */
    public function index(SearchTrackerRepository $searchTrackerRepository): Response
    {
        return $this->render('search_tracker/index.html.twig', [
            'search_trackers' => $searchTrackerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="search_tracker_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $searchTracker = new SearchTracker();
        $form = $this->createForm(SearchTrackerType::class, $searchTracker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($searchTracker);
            $entityManager->flush();

            return $this->redirectToRoute('search_tracker_index');
        }

        return $this->render('search_tracker/new.html.twig', [
            'search_tracker' => $searchTracker,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="search_tracker_show", methods={"GET"})
     */
    public function show(SearchTracker $searchTracker): Response
    {
        return $this->render('search_tracker/show.html.twig', [
            'search_tracker' => $searchTracker,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="search_tracker_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SearchTracker $searchTracker): Response
    {
        $form = $this->createForm(SearchTrackerType::class, $searchTracker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('search_tracker_index');
        }

        return $this->render('search_tracker/edit.html.twig', [
            'search_tracker' => $searchTracker,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="search_tracker_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SearchTracker $searchTracker): Response
    {
        if ($this->isCsrfTokenValid('delete'.$searchTracker->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($searchTracker);
            $entityManager->flush();
        }

        return $this->redirectToRoute('search_tracker_index');
    }
}
