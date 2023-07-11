<?php

namespace App\Form;

use App\Entity\Matches;
use App\Entity\Referees;
use App\Entity\Sponsor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RefereesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('start_date')
            ->add('matches')
//           ->add('matches',EntityType::class, array(
//               'class'    =>Matches::class,
//               'expanded' =>true,
//               'multiple' =>true,
//           ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Referees::class,
        ]);
    }
}
