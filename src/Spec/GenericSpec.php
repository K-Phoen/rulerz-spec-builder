<?php

namespace RulerZ\Spec;

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