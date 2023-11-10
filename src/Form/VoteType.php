<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Entity\Joueur;
use App\Entity\Vote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            //->add('noteVote')
             ->add('joueur',EntityType::class,
            [
                  'class' => Joueur::class,
                  
                  'choice_label'=>'nom',
                  'placeholder' => 'Select an author'
                ]) 
                
                
                ->add('noteVote',ChoiceType::class,[
                    'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5],
                    'multiple'=>false,
                    'expanded'=>true
                    ])

                   /*  ->add('date', DateType::class, [
                        'mapped' => false,]) */

                    ->add('vote',SubmitType::class)

                    ;
              
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vote::class,
        ]);
    }
}
