<?php
/**
 * @author Thomas Ploch <thomas.ploch@meinfernbus.de>
 */

namespace Symfony\Component\Process\CommandGenerator;

use Symfony\Component\Process\ProcessUtils;

/**
 * Class CommandGenerator
 */
abstract class CommandGenerator implements CommandGeneratorInterface
{
    /**
     * @param string $argument
     *
     * @return string
     */
    public function escapeArgument($argument)
    {
        return ProcessUtils::escapeArgument((string) $argument);
    }
}
