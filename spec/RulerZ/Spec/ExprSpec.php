<?php

namespace spec\RulerZ\Spec;

use PhpSpec\ObjectBehavior;
use RulerZ\Spec\Specification;

class ExprSpec extends ObjectBehavior
{
    function it_can_build_conjunctions(Specification $spec, Specification $otherSpec)
    {
        $spec->getRule()->willReturn('a');
        $spec->getParameters()->willReturn(['foo' => 'param a']);

        $otherSpec->getRule()->willReturn('b');
        $otherSpec->getParameters()->willReturn(['bar' => 'param b']);

        $conjunction = $this::andX($spec, $otherSpec);
        $conjunction->getRule()->shouldReturn('(a) AND (b)');
        $conjunction->getParameters()->shouldReturn([
            'foo' => 'param a',
            'bar' => 'param b',
        ]);
    }

    function it_can_build_disjunctions(Specification $spec, Specification $otherSpec)
    {
        $spec->getRule()->willReturn('a');
        $spec->getParameters()->willReturn(['foo' => 'param a']);

        $otherSpec->getRule()->willReturn('b');
        $otherSpec->getParameters()->willReturn(['bar' => 'param b']);

        $disjunction = $this::orX($spec, $otherSpec);
        $disjunction->getRule()->shouldReturn('(a) OR (b)');
        $disjunction->getParameters()->shouldReturn([
            'foo' => 'param a',
            'bar' => 'param b',
        ]);
    }

    function it_can_build_a_negation(Specification $spec)
    {
        $spec->getRule()->willReturn('a');
        $spec->getParameters()->willReturn(['foo' => 'param a']);

        $negation = $this::not($spec);
        $negation->getRule()->shouldReturn('NOT (a)');
        $negation->getParameters()->shouldReturn(['foo' => 'param a']);
    }

    function it_can_build_a_equality()
    {
        $spec = $this::equals('column', 42);
        $spec->getRule()->shouldReturn('column = 42');
    }

    function it_can_build_a_difference()
    {
        $spec = $this::notEquals('column', 42);
        $spec->getRule()->shouldReturn('column != 42');
    }

    function it_can_build_an_identity()
    {
        $spec = $this::is('column', 42);
        $spec->getRule()->shouldReturn('column is 42');
    }

    function it_can_build_an_identity_negation()
    {
        $spec = $this::isNot('column', 42);
        $spec->getRule()->shouldReturn('NOT (column is 42)');
    }

    function it_can_build_a_strict_inferiority()
    {
        $spec = $this::lessThan('column', 42);
        $spec->getRule()->shouldReturn('column < 42');
    }

    function it_can_build_an_inferiority()
    {
        $spec = $this::lessThanEqual('column', 42);
        $spec->getRule()->shouldReturn('column <= 42');
    }

    function it_can_build_a_strict_superiority()
    {
        $spec = $this::moreThan('column', 42);
        $spec->getRule()->shouldReturn('column > 42');
    }

    function it_can_build_a_superiority()
    {
        $spec = $this::moreThanEqual('column', 42);
        $spec->getRule()->shouldReturn('column >= 42');
    }

    function it_can_build_an_inclusion()
    {
        $spec = $this::in('column', [42, 24]);
        $spec->getRule()->shouldReturn('column in [42, 24]');
    }

    function it_can_build_an_inclusion_negation()
    {
        $spec = $this::notIn('column', [42, 24]);
        $spec->getRule()->shouldReturn('NOT (column in [42, 24])');
    }

    function it_can_build_a_function_call()
    {
        $spec = $this::func('like', 'column', 'value');
        $spec->getRule()->shouldReturn("like('column', 'value')");
    }
}
