<?php
/**
 * @author Thomas Ploch <thomas.ploch@meinfernbus.de>
 */
namespace Symfony\Component\Process\Provider;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Provider\CommandGenerator\CommandGeneratorInterface;

/**
 * Class ArrayProcessProvider
 */
class ArrayProcessProvider extends ProcessProvider
{
    /**
     * @var \ArrayIterator
     */
    private $iterator;

    /**
     * @param array                     $items
     * @param CommandGeneratorInterface $generator
     */
    public function __construct(Array $items, CommandGeneratorInterface $generator)
    {
        $this->iterator = new \ArrayIterator($items);
        $this->setCommandGenerator($generator);
    }

    /**
     * {@inheritDoc}
     */
    public function reset()
    {
        $this->iterator->rewind();
    }

    /**
     * @return \Symfony\Component\Process\Process
     */
    public function nextProcess()
    {
        $this->iterator->next();

        if ($this->isProcessed()) {
            return null;
        }

        $nextItem = $this->iterator->current();
        $key      = $this->iterator->key();
        $defaults = $this->getDefaults();

        if (is_string($key) && $key) {
            $this->setCurrentProcessName($key);
        }

        return new Process(
            $this->getCommandGenerator()->generate($nextItem),
            $defaults['cwd'],
            $defaults['env'],
            $defaults['stdin'],
            $defaults['timeout'],
            $defaults['options']
        );
    }

    /**
     * @return bool
     */
    public function isProcessed()
    {
        return $this->iterator->valid();
    }
}
