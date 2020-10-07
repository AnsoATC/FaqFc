<?php

namespace App\Controller\Manager;

use App\Entity\FcCategory;
use App\Form\FcCategoryType;
use App\Repository\FcCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fccategory")
 */
class FcCategoryController extends AbstractController
{
    /**
     * @Route("/", name="fc_category_index", methods={"GET","POST"})
     */
    public function index(FcCategoryRepository $fcCategoryRepository, Request $request): Response
    {
        //Handle new fc category creation
        $fcCategory = new FcCategory();
        $form = $this->createForm(FcCategoryType::class, $fcCategory);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $fcCategory->setCreatedAt(new \DateTime());
            $fcCategory->setAuthor($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fcCategory);
            $entityManager->flush();
        }

        return $this->render('manager/fc_category/index.html.twig', [
            'fc_category' => $fcCategory,
            'form' => $form->createView(),
            'fc_categories' => $fcCategoryRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fc_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FcCategory $fcCategory): Response
    {
        $form = $this->createForm(FcCategoryType::class, $fcCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fc_category_index');
        }

        return $this->render('manager/fc_category/edit.html.twig', [
            'fc_category' => $fcCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fc_category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, FcCategory $fcCategory): Response
    {
        if ($this->isCsrfTokenValid('delete' . $fcCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fcCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fc_category_index');
    }
}
