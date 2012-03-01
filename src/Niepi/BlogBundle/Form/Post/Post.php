<?php
// src/Niepi/BlogBundle/Form/Post/Post.php

namespace NIepi\BlogBundle\Form\Post;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Post extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('Title');
        $builder->add('content');
    }

    public function getName()
    {
        return 'post';
    }
}