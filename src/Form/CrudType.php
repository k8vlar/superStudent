<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrudType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('creationDate')
            ->add('modificationDate')
            ->add('author')
          //  ->add('discipline')
          //  ->add('avatar')
            ->add('content')
          //  ->add('image')
          //  ->add('relation')
            ->add('matieres')
           // ->add('user')
            ->add('save', SubmitType::class, [
            'label' => 'envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
