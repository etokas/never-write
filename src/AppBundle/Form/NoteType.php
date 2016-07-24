<?php
/**
 * Created by PhpStorm.
 * User: sylva
 * Date: 19/07/2016
 * Time: 19:39
 */

namespace AppBundle\Form;


use AppBundle\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class);
        $builder->add('content', TextareaType::class);
    }

    public function configureOptions(OptionsResolver $options)
    {
        return [
            'data_class' => Note::class
        ];

    }


    public function getBlockPrefix()
    {
        return 'note_type';
    }

}