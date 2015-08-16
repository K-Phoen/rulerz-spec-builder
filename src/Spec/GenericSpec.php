<?php

namespace RulerZ\Spec;

/**
 * Represents a generic specification. This class should only be used by this
 * library, you should NOT use it.
 */
class GenericSpec implements Specification
{
    private $rule = '';
    private $parameters = [];

    public function __construct($rule, array $parameters = [])
    {
        $this->rule       = $rule;
        $this->parameters = $parameters;
    }

    /**
     * @inheritDoc
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * @inheritDoc
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}