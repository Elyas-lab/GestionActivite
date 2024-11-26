<?php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\Projet;
use App\Entity\Referentiel\Statut;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('date_debut_estimee', null, [
                'widget' => 'single_text',
            ])
            ->add('date_fin_estimee', null, [
                'widget' => 'single_text',
            ])
            ->add('date_debut_reel', null, [
                'widget' => 'single_text',
            ])
            ->add('date_fin_reel', null, [
                'widget' => 'single_text',
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
