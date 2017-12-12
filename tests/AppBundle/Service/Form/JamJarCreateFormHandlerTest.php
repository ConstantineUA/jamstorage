<?php

namespace Test\AppBundle\Service\Form;

use PHPUnit\Framework\TestCase;
use AppBundle\Service\Form\JamJarCreateFormHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\JamJar;

/**
 * JamJarCreateFormHandler test case.
 */
class JamJarCreateFormHandlerTest extends TestCase
{
    /**
     * @var JamJarCreateFormHandler
     */
    protected $jamJarCreateFormHandler;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->jamJarCreateFormHandler = new JamJarCreateFormHandler();
    }

    /**
     * Test that handleCreateRequest reads proper request data
     */
    public function testHandleCreateRequestReadsFormData()
    {
        $key = 'unique';

        $query = $this->createMock(ParameterBag::class);
        $post = $this->createMock(ParameterBag::class);

        $query
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo('uniqid'))
            ->willReturn($key);

        $post
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo($key));

        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request->query = $query;
        $request->request = $post;

        $this->jamJarCreateFormHandler->handleCreateRequest($request, null, function () {});
    }

    /**
     * Test that callback is run N times on a clone of original object
     */
    public function testHandleCreateRequestRunsCallbackNTimes()
    {
        $amount = 3;

        $formData = [
            'amount' => $amount,
        ];

        $query = $this->createMock(ParameterBag::class);
        $post = $this->createMock(ParameterBag::class);

        $post
            ->method('get')
            ->willReturn($formData);

        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request->query = $query;
        $request->request = $post;

        $stdObject = new \stdClass();

        $callback = $this->getMockBuilder('Callback')
            ->setMethods([ 'run' ])
            ->getMock();

        $callback
            ->expects($this->exactly($amount))
            ->method('run')
            ->with($this->callback(function ($clonedObject) use ($stdObject) {
                return $clonedObject instanceof \stdClass && $clonedObject !== $stdObject;
            }));

        $this->jamJarCreateFormHandler->handleCreateRequest($request, $stdObject, [ $callback, 'run' ]);
    }

    /**
     * Test that a field is added to the form for new jars
     */
    public function testUpdateFormAddsNewFieldForNewJars()
    {
        $jar = $this->createMock(JamJar::class);
        $formMapper = $this->createMock(FormMapper::class);

        $formMapper
            ->expects($this->once())
            ->method('add')
            ->with('amount', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', $this->callback(function ($params) {
                return is_array($params);
            }));

        $this->jamJarCreateFormHandler->updateForm($formMapper, $jar);
    }

    /**
     * Test that form isn't modified for saved jars
     */
    public function testUpdateFormIgnoresSavedJars()
    {
        $jar = $this->createMock(JamJar::class);

        $jar
            ->method('getId')
            ->willReturn(1);

        $formMapper = $this->createMock(FormMapper::class);

        $formMapper
            ->expects($this->never())
            ->method('add');

        $this->jamJarCreateFormHandler->updateForm($formMapper, $jar);
    }
}

