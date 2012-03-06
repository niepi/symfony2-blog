<?php
// src/Niepi/BlogBundle/Form/Post/CreateForm.php

namespace Niepi\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Niepi\BlogBundle\Entity\Post;

class CommentCreateForm extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('email','email');
        $builder->add('content','textarea');
        $builder->add('post', new PostType());
    }

    public function getName()
    {
        return 'commentCreateForm';
    }

    public function getDefaultOptions(array $options)
{
    return array(
        'data_class' => 'Niepi\BlogBundle\Entity\Comment',
    );
}
}