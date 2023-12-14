<?php

namespace App\Form;

use App\Entity\Review;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Ratting',TextType::class)
            ->add('Comment', TextType::class)
            ->add('Date', DateType::class,['widget' => 'single_text'])
            ->add('Product',EntityType::class,array('class'=>'App\Entity\Product','choice_label'=>"ProductName"))
            ->add('user',EntityType::class, array('class'=>'App\Entity\User','choice_label'=>"UserName"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
