<?php
/**
 * @author Thomas Ploch <thomas.ploch@meinfernbus.de>
 */
namespace Symfony\Component\Process\Provider\CommandGenerator;

/**
 * Interface CommandGeneratorInterface
 */
interface CommandGeneratorInterface
{
    /**
     * This method should return a command name for given data
     *
     * @param mixed $commandData
     *
     * @return string
     */
    public function generate($commandData);
}
