<?php

namespace App\Form;

use App\Entity\Sponsor;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class  TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('creationDate')
            ->add('coach')
//            ->add('sponsor')
            ->add('sponsors',EntityType::class, array(
                'class'    =>Sponsor::class,
                'expanded' =>true,
                'multiple' =>true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
