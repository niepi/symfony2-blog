<?php
// src/Niepi/BlogBundle/Form/Post/CreateForm.php

namespace Niepi\BlogBundle\Form\Post;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CommentCreateForm extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('email','email');
        $builder->add('content','textarea');
    }

    public function getName()
    {
        return 'post';
    }

    public function getDefaultOptions(array $options)
{
    return array(
        'data_class' => 'Niepi\BlogBundle\Entity\Comment',
    );
}
}