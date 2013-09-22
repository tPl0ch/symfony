<?php
/**
 * @author Thomas Ploch <thomas.ploch@meinfernbus.de>
 */
namespace Symfony\Component\Process\Provider;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessProviderInterface;
use Symfony\Component\Process\Provider\CommandGenerator\CommandGeneratorInterface;

/**
 * Class ProcessProvider
 */
abstract class ProcessProvider implements ProcessProviderInterface
{
    /**
     * @var int
     */
    private $index = 0;

    /**
     * @var string
     */
    private $currentProcessName;

    /**
     * @var \Symfony\Component\Process\Process
     */
    private $currentProcess;

    /**
     * @var \Symfony\Component\Process\Provider\CommandGenerator\CommandGeneratorInterface
     */
    private $commandGenerator;

    /**
     * @var array
     */
    private $defaults = array(
        'cwd'     => null,
        'env'     => null,
        'stdin'   => null,
        'timeout' => 60,
        'options' => array()
    );

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param CommandGeneratorInterface $commandGenerator
     *
     * @return ProcessProvider
     */
    public function setCommandGenerator(CommandGeneratorInterface $commandGenerator)
    {
        $this->commandGenerator = $commandGenerator;

        return $this;
    }

    /**
     * @return CommandGeneratorInterface
     */
    public function getCommandGenerator()
    {
        return $this->commandGenerator;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    protected function setCurrentProcessName($name)
    {
        $this->currentProcessName = (string) $name;

        return $this;
    }

    /**
     * @param array $defaults
     *
     * @return ProcessProvider
     */
    public function setDefaults(Array $defaults)
    {
        $this->defaults = array_merge($this->defaults, $defaults);

        return $this;
    }

    /**
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * {@inheritDoc}
     */
    final public function next()
    {
        $this->currentProcessName = null;
        $this->currentProcess     = $this->nextProcess();

        $this->index++;
    }

    /**
     * {@inheritDoc}
     */
    final public function current()
    {
        return $this->currentProcess;
    }

    /**
     * {@inheritDoc}
     */
    final public function key()
    {
        return $this->currentProcessName;
    }

    /**
     * {@inheritDoc}
     */
    final public function valid()
    {
        return $this->isProcessed();
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        $this->reset();

        $this->index = 0;
    }
}
