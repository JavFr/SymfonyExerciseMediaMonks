<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class PostAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper->add('title', TextType::class);
        $formMapper->add('body', TextareaType::class);
        $formMapper->add('slug', TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper->add('title');
        $datagridMapper->add('slug');
        $datagridMapper->add('createdAt');
        $datagridMapper->add('updatedAt');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper->addIdentifier('title');
        $listMapper->add('slug');
        $listMapper->add('createdAt');
        $listMapper->add('updatedAt');
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        // here we set the fields of the ShowMapper variable,
        // $showMapper (but this can be called anything)
        $showMapper
            ->tab('General')
                ->with('Addresses', [
                    'class'       => 'col-md-8',
                    'box_class'   => 'box box-solid box-danger',
                    'description' => 'Lorem ipsum',
                ])
            ->add('title')
            ->add('slug')
            ->add('createdAt');
    }
}
