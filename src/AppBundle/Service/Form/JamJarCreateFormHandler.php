<?php

namespace AppBundle\Service\Form;

use Symfony\Component\HttpFoundation\Request;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Range;
use AppBundle\Entity\JamJar;

/**
 * Service class to process create an entity request by Sonata admin
 */
class JamJarCreateFormHandler
{
    /**
     * Default amount of jars to create
     *
     * @var integer
     */
    const DEFAULT_JARS_AMOUNT = 1;

    /**
     * Additional field to add to form
     *
     * @var string
     */
    const AMOUNT_FIELD = 'amount';

    /**
     * Fetch form data and run an object through callback function
     *
     * @param Request $request
     * @param mixed $object
     * @param callable $callback
     */
    public function handleCreateRequest(Request $request, $object, callable $callback)
    {
        $sonataUniqIdKey = 'uniqid';

        $uniqid = $request->query->get($sonataUniqIdKey);
        $formData = $request->request->get($uniqid);

        for ($i = 0; $i < $formData[self::AMOUNT_FIELD]; $i++) {
            $objectToSave = clone $object;

            $callback($objectToSave);
        }
    }

    /**
     * Adjust form to
     *
     * @param FormMapper $formMapper
     * @param JamJar $jar
     */
    public function updateForm(FormMapper $formMapper, JamJar $jar)
    {
        if ($jar->getId()) {
            return;
        }

        $minAmountToCreate = 1;

        $formMapper->add(self::AMOUNT_FIELD, IntegerType::class, [
            'mapped' => false,
            'data' => self::DEFAULT_JARS_AMOUNT,
            'constraints' => [
                new Range([
                    'min' => $minAmountToCreate,
                ])
            ],
        ]);
    }
}
