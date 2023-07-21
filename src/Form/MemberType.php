<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('role', ChoiceType::class,[
                'choices'=>[
                    'Goalkeeper'=>'Goalkeeper',
                    'Defender'=>'Defender',
                    'Midfielder'=>'Midfielder',
                    'Striker'=>'Striker',
                ]
            ])
            ->add('age')
            //            ->add('sponsors',EntityType::class, array(
//                'class'    =>Sponsor::class,
//                'expanded' =>true,
//                'multiple' =>true,
//            ))
            ->add('team_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
