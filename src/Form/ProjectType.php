<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('linkWeb')
            ->add('linkGithub')
            ->add(
                'headerImageFile',
                FileType::class,
                [
                'label' => 'Image d\'en-tête',
                'required' => false
                ]
            )
            ->add(
                'pictureFiles',
                FileType::class,
                [
                'label' => 'Galerie photos',
                'required' => false,
                'multiple' => true
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
