<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
            ])

            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'h',
                    'Femme' => 'f',
                ],
            ])
            ->add('statutMarital')
            ->add('adresse')
            ->add('codePostal')
            ->add('ville')
            ->add('idCardFile', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Carte Nationale d\'Identité',
            ])
            ->add('shoulderImage', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Photo Buste',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
