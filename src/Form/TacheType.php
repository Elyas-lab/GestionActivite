<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\Referentiel\Statut;
use App\Entity\Tache;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheType extends AbstractType
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
            ->add('activite', EntityType::class, [
                'class' => Activite::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
