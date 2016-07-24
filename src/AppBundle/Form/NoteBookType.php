<?php
/**
 * Created by PhpStorm.
 * User: sylva
 * Date: 19/07/2016
 * Time: 19:39
 */

namespace AppBundle\Form;


use AppBundle\Entity\NoteBook;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class);
    }

    public function configureOptions(OptionsResolver $options)
    {
        return [
            'data_class' => NoteBook::class
        ];

    }


    public function getBlockPrefix()
    {
        return 'notebook_type';
    }

}