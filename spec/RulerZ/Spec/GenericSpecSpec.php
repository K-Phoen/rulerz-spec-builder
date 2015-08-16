<?php

namespace spec\RulerZ\Spec;

use PhpSpec\ObjectBehavior;

class GenericSpecSpec extends ObjectBehavior
{
    function it_simply_returns_the_rule_and_parameters()
    {
        $rule       = 'some dummy rule';
        $parameters = ['some' => 'parameter'];

        $this->beConstructedWith($rule, $parameters);

        $this->getRule()->shouldReturn($rule);
        $this->getParameters()->shouldReturn($parameters);
    }
}