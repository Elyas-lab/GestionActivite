<?php

namespace App\Form\Referentiel;

use App\Entity\Referentiel\Groupe;
use App\Entity\Referentiel\Permission;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupePermissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('permissions', EntityType::class, [
                'class' => Permission::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
                'group_by' => function (Permission $permission) {
                    return $permission->getCategorie() ? $permission->getCategorie() : 'Non classé';
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Groupe::class,
        ]);
    }
}
