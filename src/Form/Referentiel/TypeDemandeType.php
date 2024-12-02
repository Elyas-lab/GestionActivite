<?php

namespace App\Form\Referentiel;

use App\Entity\Referentiel\TypeDemande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeDemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('isActive', CheckboxType::class, [
                'label' => 'Actif',  // L'étiquette pour le champ
                'required' => false, // Le champ est facultatif
                'value' => true, // La valeur "true" quand la case est cochée
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeDemande::class,
        ]);
    }
}
