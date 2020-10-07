<?php

namespace App\Form;

use App\Entity\FcCategory;
use App\Entity\Message;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                ['required' => true,]
            )
            ->add('category', EntityType::class, [
                // looks for choices from this entity
                'class' => FcCategory::class,
                // uses the FcCategory.topic property as the visible option string
                'choice_label' => 'topic',
            ])
            ->add(
                'content',
                TextareaType::class,
                ['required' => true,]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
