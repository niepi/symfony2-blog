<?php
// src/Niepi/BlogBundle/Form/Post/PostType.php

namespace Niepi\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PostType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('id','hidden');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Niepi\BlogBundle\Entity\Post',
        );
    }

    public function getName()
    {
        return 'posttype';
    }
}