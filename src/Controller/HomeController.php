<?php

namespace App\Controller;

use App\Entity\SearchTracker;
use App\Repository\FaqCategoryRepository;
use App\Service\SearchHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(FaqCategoryRepository $faqCategoryRepository, Request $request, SearchHelper $searchHelper)
    {
        //Default values
        $defaultSearchData = ['question' => ''];
        $responsesFound = null;
        $displaySearchSection = false;


        //Building search form
        $form = $this->createFormBuilder($defaultSearchData)
            ->setAction($this->generateUrl('app_home') . "#results")
            ->setMethod('POST')
            ->add('question', TextType::class, [
                'required' => true,
            ])
            ->getForm();

        //Form processing
        $form->handleRequest($request);

        //Validation of the form
        if ($form->isSubmitted() && $form->isValid()) {

            //Get submitted data
            $question = $form->get('question')->getData();
            $responsesFound = $searchHelper->search($question);

            //Track user search
            $SearchTracker = new SearchTracker();
            $entityManager = $this->getDoctrine()->getManager();
            $SearchTracker->setFaqFoundResult($responsesFound["fromFaq"]["count"]);
            $SearchTracker->setFcFoundResult($responsesFound["fromFc"]["count"]);
            $SearchTracker->setQuestion($question);
            $SearchTracker->setSearchedAt(new \DateTime());
            $entityManager->persist($SearchTracker);
            $entityManager->flush();

            //Display response section
            $displaySearchSection = true;
        }

        //Then send data to twig
        return $this->render('home/index.html.twig', [
            'faq_categories' => $faqCategoryRepository->findAll(),
            'responses' => $responsesFound,
            'form' => $form->createView(),
            'displaySearchSection' => $displaySearchSection
        ]);
    }

        /**
         * @Route("/sans",name="sans")
         */
    public function sansBlag(){
        return $this->render('fileName.html.twig',[
            
        ]);
    }
}
