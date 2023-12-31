<?php

namespace App\Form;
use App\Entity\Sponsor;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class  TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
               // 'label' => false,
                'required'=>false
    ])
            ->add('creationDate', DateType::class,[
                'years'=>range(1900,date('Y')),
                ])
            ->add('coach')
//            ->add('sponsor')
//            ->add('sponsors',EntityType::class, array(
//                'class'    =>Sponsor::class,
//                'expanded' =>true,
//                'multiple' =>true,
//            ))
            ->add('wins')
            ->add('losses')
            ->add('draws')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
