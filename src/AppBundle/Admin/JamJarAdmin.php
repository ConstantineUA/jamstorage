<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Year;
use AppBundle\Entity\JamType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Range;
use AppBundle\Service\Form\JamJarCreateFormHandler;

/**
 * Class to manage JamJar entity through Sonata bundle
 */
class JamJarAdmin extends AbstractAdmin
{
    /**
     * @var JamJarCreateFormHandler
     */
    protected $handler;

    /**
     * Setter injection for formHandler
     *
     * @param JamJarCreateFormHandler $handler
     */
    public function setCreateFormHandler(JamJarCreateFormHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * {@inheritDoc}
     * @see \Sonata\AdminBundle\Admin\AbstractAdmin::configureFormFields()
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('type', EntityType::class, [
                'class' => JamType::class,
            ])
            ->add('year', EntityType::class, [
                'class' => Year::class,
            ])
            ->add('comment', TextType::class, [
                'required' => false,
            ]);

        $this->handler->updateForm($formMapper, $this->getSubject());
    }

    /**
     * Run request through form handler or same an object as is
     *
     * {@inheritDoc}
     * @see \Sonata\AdminBundle\Admin\AbstractAdmin::create()
     */
    public function create($object)
    {
        if ($this->handler) {
            $request = $this->getRequest();

            $this->handler->handleCreateRequest($request, $object, function ($object) {
                parent::create($object);
            });

        } else {
            parent::create($object);
        }
    }

    /**
     * {@inheritDoc}
     * @see \Sonata\AdminBundle\Admin\AbstractAdmin::configureDatagridFilters()
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('type')
            ->add('year')
            ->add('comment');
    }

    /**
     * {@inheritDoc}
     * @see \Sonata\AdminBundle\Admin\AbstractAdmin::configureListFields()
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('type')
            ->add('year')
            ->add('comment');
    }
}
