<?php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\Referentiel\CanalDemande;
use App\Entity\Referentiel\SourceDemande;
use App\Entity\Referentiel\Statut;
use App\Entity\Referentiel\TypeDemande;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',null , ['required'=> true])
            ->add('description',null , ['required'=> true])
            ->add('date_creation', DateTimeType::class, [
                'widget' => 'single_text', // This renders the field as a single input box
                'attr' => ['class' => 'datepicker'],
                'required'=> true, 
            ])
            ->add('Source', EntityType::class, [
                'class' => SourceDemande::class,
                'choice_label' => 'nom',
                'required'=> true,
            ])
            ->add('type', EntityType::class, [
                'class' => TypeDemande::class,
                'choice_label' => 'nom',
                'required'=> true,
            ])
            ->add('canal', EntityType::class, [
                'class' => CanalDemande::class,
                'choice_label' => 'nom',
                'required'=> true,
            ])
            ->add('statut', EntityType::class, [
                'class' => Statut::class,
                'choice_label' => 'nom',
                'required'=> true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
