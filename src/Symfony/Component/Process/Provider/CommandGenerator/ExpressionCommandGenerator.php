<?php
/**
 * @author Thomas Ploch <thomas.ploch@meinfernbus.de>
 */
namespace Symfony\Component\Process\Provider\CommandGenerator;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Class ExpressionCommandGenerator
 */
class ExpressionCommandGenerator implements CommandGeneratorInterface
{
    /**
     * @var string
     */
    private $expression;

    /**
     * @var \Symfony\Component\ExpressionLanguage\ExpressionLanguage
     */
    private $language;

    /**
     * @param string             $expression
     * @param ExpressionLanguage $language
     *
     * @return ExpressionCommandGenerator
     */
    public static function create($expression = null, ExpressionLanguage $language = null)
    {
        return new self($expression, $language);
    }

    /**
     * @param string             $expression
     * @param ExpressionLanguage $language
     */
    public function __construct($expression = null, ExpressionLanguage $language = null)
    {
        $this->expression = $expression;
        $this->language   = $language;
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
        if (null === $this->expression || null === $this->language) {
            throw new \LogicException(
                "You must set an expression and an expression language to generate a command"
            );
        }

        $command =  $this
            ->language
            ->evaluate(
                $this->expression,
                array(
                    'data' => $commandData
                )
            )
        ;

        return $command;
    }

    /**
     * @param string $expression
     */
    public function setExpression($expression)
    {
        $this->expression = (string) $expression;
    }

    /**
     * @param \Symfony\Component\ExpressionLanguage\ExpressionLanguage $language
     */
    public function setLanguage(ExpressionLanguage $language)
    {
        $this->language = $language;
    }
}
