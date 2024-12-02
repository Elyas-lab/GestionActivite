<?php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\Projet;
use App\Entity\Referentiel\Statut;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType as TypeDateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('date_debut_estimee', TypeDateTimeType::class, [
                'widget' => 'single_text', // This renders the field as a single input box
                'attr' => ['class' => 'datepicker'], // Add custom class for JavaScript styling
            ])
            ->add('date_fin_estimee', TypeDateTimeType::class, [
                'widget' => 'single_text', // This renders the field as a single input box
                'attr' => ['class' => 'datepicker'], // Add custom class for JavaScript styling
            ])
            ->add('date_debut_reel',  TypeDateTimeType::class, [
                'widget' => 'single_text', // This renders the field as a single input box
                'attr' => ['class' => 'datepicker'], // Add custom class for JavaScript styling
            ])
            ->add('date_fin_reel',  TypeDateTimeType::class, [
                'widget' => 'single_text', // This renders the field as a single input box
                'attr' => ['class' => 'datepicker'], // Add custom class for JavaScript styling
            ])
            ->add('ressources', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('statut', EntityType::class, [
                'class' => Statut::class,
                'choice_label' => 'id',
            ])
            ->add('demande_source', EntityType::class, [
                'class' => Demande::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
