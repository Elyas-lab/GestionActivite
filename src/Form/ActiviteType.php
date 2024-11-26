<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\Projet;
use App\Entity\Referentiel\Statut;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('date_debut_estimee', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('date_fin_estimee', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('date_debut_reel', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('date_fin_reel', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('ressources', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'nom', 
                'multiple' => true,
                'expanded' => true, // Set to true if you want checkboxes instead of a select list
                'attr' => ['class' => 'form-select'],
            ])
            ->add('statut', EntityType::class, [
                'class' => Statut::class,
                'choice_label' => 'nom', 
                'attr' => ['class' => 'form-select'],
            ])
            ->add('projet_source', EntityType::class, [
                'class' => Projet::class,
                'choice_label' => 'titre',  
                'attr' => ['class' => 'form-select'],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activite::class,
        ]);
    }
}
