<?php
/**
 * @author Thomas Ploch <thomas.ploch@meinfernbus.de>
 */
namespace Symfony\Component\Process\Provider\CommandGenerator;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Class TemplateCommandGenerator
 */
class SimpleCommandGenerator implements CommandGeneratorInterface
{
    /**
     * @var string
     */
    private $command;

    /**
     * @param string $command
     *
     * @return TemplateCommandGenerator
     */
    public static function create($command)
    {
        return new self($command);
    }

    /**
     * @param string $command
     */
    public function __construct($command)
    {
        $this->command = $command;

    }

    /**
     * @param mixed $commandData
     *
     * @return string
     *
     * @throws \LogicException
     */
    public function generate($commandData)
    {
        return $this->command;
    }

    /**
     * @param string $command
     *
     * @return TemplateCommandGenerator
     */
    public function setCommand($command)
    {
        $this->command = (string) $command;

        return $this;
    }
}
