<?php

namespace MSD\AdminBundle\Form\Connection;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('driver', 'hidden')
            ->add('host', 'text')
            ->add('port', 'integer')
            ->add('unixSocket', 'text', array('label' => 'Socket'))
            ->add('path', 'text')
            ->add('user', 'text')
            ->add('password', 'text')
            ->add('dbName', 'text', array('label' => 'DB-Name'))
            ->add('charset', 'text')
            ->add('save', 'submit');
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'msd_db_connection';
    }
}