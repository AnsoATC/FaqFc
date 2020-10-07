<?php

namespace App\Controller;

use App\Entity\Faq;
use App\Entity\FaqCategory;
use App\Form\FaqType;
use App\Repository\FaqRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/faq")
 */
class FaqController extends AbstractController
{
    /**
     * @Route("/category/{id}", name="faq_of_category", methods={"GET"})
     */
    public function faqOfCategory(FaqCategory $faqCategory, FaqRepository $faqRepository): Response
    {
        if (!$faqCategory) {
            throw $this->createNotFoundException(
                'Aucune catégorie de faq retrouvé avec cet id:  ' . $faqCategory->getId()
            );
        }

        return $this->render('faq/faqs_of_category.html.twig', [
            'faqs' => $faqRepository->findBy(['category' => $faqCategory]),
            'faqCategory' => $faqCategory
        ]);
    }

    /**
     * @Route("/", name="faq_index", methods={"GET","POST"})
     */
    public function index(FaqRepository $faqRepository, Request $request): Response
    {
        //Handle new Faq creation
        $faq = new Faq();
        $form = $this->createForm(FaqType::class, $faq);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($faq);
            $entityManager->flush();

            return $this->redirectToRoute('faq_index');
        }

        return $this->render('manager/faq/index.html.twig', [
            'faq' => $faq,
            'form' => $form->createView(),
            'faqs' => $faqRepository->findAll(),
        ]);
    }



    /**
     * @Route("/{id}/edit", name="faq_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Faq $faq): Response
    {

        if (!$faq) {
            throw $this->createNotFoundException(
                'Aucune faq retrouvé avec cet id:  ' . $faq->getId()
            );
        }

        $form = $this->createForm(FaqType::class, $faq);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('faq_index');
        }

        return $this->render('crud/faq/edit.html.twig', [
            'faq' => $faq,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="faq_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Faq $faq): Response
    {
        if ($this->isCsrfTokenValid('delete' . $faq->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($faq);
            $entityManager->flush();
        }

        return $this->redirectToRoute('faq_index');
    }
}
