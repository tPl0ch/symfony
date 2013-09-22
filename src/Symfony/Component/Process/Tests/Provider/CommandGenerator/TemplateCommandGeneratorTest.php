<?php
/**
 * @author Thomas Ploch <thomas.ploch@meinfernbus.de>
 */
namespace Symfony\Component\Process\Tests\Provider\CommandGenerator;

use Symfony\Component\Process\Provider\CommandGenerator\TemplateCommandGenerator;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class TemplateCommandGeneratorTest
 */
class TemplateCommandGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\Process\Provider\CommandGenerator\TemplateCommandGenerator
     */
    public $generator;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    public $accessor;

    public function testFactoryMethod()
    {
        $this->generator = TemplateCommandGenerator::create();

        $this->assertNull($this->generator->getCommandTemplate());
        $this->assertEmpty($this->generator->getPlaceholders());

        $this->generator = TemplateCommandGenerator::create('exec php -f test');

        $this->assertEquals('exec php -f test', $this->generator->getCommandTemplate());
        $this->assertEmpty($this->generator->getPlaceholders());

        $this->generator = TemplateCommandGenerator::create(null, array('%%test%%' => 'test'));

        $this->assertEquals(array('%%test%%' => 'test'), $this->generator->getPlaceholders());
        $this->assertNull($this->generator->getCommandTemplate());

        $this->generator = TemplateCommandGenerator::create('exec php -f test', array('%%test%%' => 'test'));

        $this->assertEquals(array('%%test%%' => 'test'), $this->generator->getPlaceholders());
        $this->assertEquals('exec php -f test', $this->generator->getCommandTemplate());
    }

    public function testIsReplacingCorrectly()
    {
        $this->generator = TemplateCommandGenerator::create(
            'exec php -f test --id=%%id%% --test-value=%%test%%',
            array(
                '%%id%%'   => 'id',
                '%%test%%' => 'child.value'
            )
        );

        $data = $this->getTestData();
        $expected = 'exec php -f test --id=23 --test-value=test';

        $this->assertEquals($expected, $this->generator->generate($data));
    }

    /**
     * @expectedException \LogicException
     */
    public function testThrowsLogicExceptionWhenNoCommandSet()
    {
        $this->generator = TemplateCommandGenerator::create();
        $this->generator->generate(null);
    }

    public function testHasFluentInterface()
    {
        $this->generator = TemplateCommandGenerator::create();

        $data = $this->getTestData();

        $expected = 'exec php -f test --id=23 --test-value=test';
        $result = $this->generator
            ->setCommandTemplate('exec php -f test --id=%%id%% --test-value=%%test%%')
            ->setPlaceholders(array(
                '%%id%%'   => 'id',
                '%%test%%' => 'child.value'
            ))
            ->generate($data)
        ;

        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException \Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException
     */
    public function testPropertyAccessorThrowsExceptionOnInvalidPath()
    {
        $this->generator = TemplateCommandGenerator::create(
            'exec php -f test --id=%%id%%',
            array(
                '%%id%%' => 'INVALID'
            )
        );

        $this->generator->generate($this->getTestData());
    }

    private function getTestData()
    {
        $data = new \stdClass();
        $data->id = 23;

        $data->child = new \stdClass();
        $data->child->value = 'test';

        return $data;
    }
}
