<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class to manage Year entity through Sonata bundle
 */
class YearAdmin extends AbstractAdmin
{
    /**
     * {@inheritDoc}
     * @see \Sonata\AdminBundle\Admin\AbstractAdmin::configureFormFields()
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', TextType::class);
    }

    /**
     * {@inheritDoc}
     * @see \Sonata\AdminBundle\Admin\AbstractAdmin::configureDatagridFilters()
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }

    /**
     * {@inheritDoc}
     * @see \Sonata\AdminBundle\Admin\AbstractAdmin::configureListFields()
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
    }
}
