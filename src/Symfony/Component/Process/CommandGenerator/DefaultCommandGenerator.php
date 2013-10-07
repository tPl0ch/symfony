<?php
/**
 * @author Thomas Ploch <thomas.ploch@meinfernbus.de>
 */
namespace Symfony\Component\Process\CommandGenerator;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Class DefaultCommandGenerator
 */
class DefaultCommandGenerator extends CommandGenerator
{
    /**
     * @return static
     */
    public static function create()
    {
        return new static();
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
        return implode(' ', array_map(array($this, 'escapeArgument'), $commandData));
    }
}
