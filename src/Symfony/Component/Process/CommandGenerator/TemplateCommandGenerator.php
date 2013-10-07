<?php
/**
 * @author Thomas Ploch <thomas.ploch@meinfernbus.de>
 */
namespace Symfony\Component\Process\CommandGenerator;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Class TemplateCommandGenerator
 */
class TemplateCommandGenerator extends CommandGenerator
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $propertyAccessor;

    /**
     * @var string
     */
    private $commandTemplate;

    /**
     * @var array
     */
    private $placeholders;

    /**
     * @var array
     */
    private $processedProperties;

    /**
     * @param string $commandTemplate
     * @param array  $replace
     *
     * @return TemplateCommandGenerator
     */
    public static function create($commandTemplate = null, Array $replace = array())
    {
        return new self(
            PropertyAccess::createPropertyAccessor(),
            $commandTemplate,
            $replace
        );
    }

    /**
     * @param PropertyAccessor $propertyAccessor
     * @param null|string      $commandTemplate
     * @param array            $placeholders
     */
    public function __construct(PropertyAccessor $propertyAccessor, $commandTemplate = null, Array $placeholders = array())
    {
        $this->propertyAccessor    = $propertyAccessor;
        $this->commandTemplate     = $commandTemplate;
        $this->placeholders        = $placeholders;
        $this->processedProperties = array();

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
        if (null === $this->commandTemplate) {
            throw new \LogicException(
                "Can't generate a command without a template set. Please set a command template first."
            );
        }

        $this->processProperties($commandData);

        return $this->getCommand();
    }

    /**
     * @return string
     */
    public function getCommandTemplate()
    {
        return $this->commandTemplate;
    }

    /**
     * @return array
     */
    public function getPlaceholders()
    {
        return $this->placeholders;
    }

    /**
     * @param string $commandTemplate
     *
     * @return TemplateCommandGenerator
     */
    public function setCommandTemplate($commandTemplate)
    {
        $this->commandTemplate = (string) $commandTemplate;

        return $this;
    }

    /**
     * @param array $placeholders
     *
     * @return TemplateCommandGenerator
     */
    public function setPlaceholders($placeholders)
    {
        $this->placeholders = $placeholders;

        return $this;
    }

    /**
     * Processes the propertyPath values from the Placeholder array
     *
     * @param mixed $commandData
     *
     * @return array
     */
    private function processProperties($commandData)
    {
        $accessor = $this->propertyAccessor;

        return $this->processedProperties = array_map(
            function ($data) use ($commandData, $accessor) {
                return $this->escapeArgument(
                    $accessor->getValue($commandData, $data)
                );
            },
            array_values($this->placeholders)
        );
    }

    /**
     * Returns the processed Process command string
     *
     * @return string
     */
    private function getCommand()
    {
        return str_replace(
            array_keys($this->placeholders),
            $this->processedProperties,
            $this->commandTemplate
        );
    }
}
