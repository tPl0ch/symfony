<?php
/**
 * @author Thomas Ploch <thomas.ploch@meinfernbus.de>
 */
namespace Symfony\Component\Process;

/**
 * Interface ProcessProviderInterface
 */
interface ProcessProviderInterface extends \Iterator
{
    /**
     * This method should return a Process instance if there is any to create.
     * Otherwise return NULL,
     *
     * @return \Symfony\Component\Process\Process|null
     */
    public function nextProcess();

    /**
     * Should return true if all items have been processed.
     *
     * @return bool
     */
    public function isProcessed();

    /**
     * This method should reset the Provider to its original state.
     *
     * @return void
     */
    public function reset();
}
