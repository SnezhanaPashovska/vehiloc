<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('prixQuotidien', NumberType::class, [
                'label' => 'Prix Quotidien',
            ])
            ->add('prixMensuel', NumberType::class, [
                'label' => 'Prix Mensuel',
            ])
            ->add('places', ChoiceType::class, [
                'label' => 'Nombre de places',
                'choices' => range(1, 9, 1),
                'choice_label' => function ($choice) {
                    return $choice;
                },
            ])
            ->add('isManuelle', ChoiceType::class, [
                'label' => 'Type de Boîte de Vitesses',
                'choices' => [
                    'Manuelle' => true,
                    'Automatique' => true,
                ],
             
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
