<?php

namespace App\Form;

use App\Entity\Faq;
use App\Entity\FaqCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FaqType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question', TextType::class,
            [ 'required' => true,])
            ->add('response', TextareaType::class,
            [ 'required' => true,])        
            ->add('category', EntityType::class, [
                // looks for choices from this entity
                'class' => FaqCategory::class,
                // uses the FaqCategory.name property as the visible option string
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Faq::class,
        ]);
    }
}
