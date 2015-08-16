RulerZ Specification builder [![Build Status](https://travis-ci.org/K-Phoen/rulerz-spec-builder.svg?branch=master)](https://travis-ci.org/K-Phoen/rulerz-spec-builder)
============================

This library provides an object-oriented way to build Specifications for [RulerZ](https://github.com/K-Phoen/rulerz).

Usage
-----

```php
$spec = Expr::andX(
    Expr::equals('gender', 'F'),
    Expr::moreThan('points', 3000)
);
```

This is equivalent to `gender = "F" and points > 3000`

Here is a more complex example:

```php
$spec = Expr::orX(
    Expr::andX(
        Expr::equals('gender', 'F'),
        Expr::moreThan('points', 3000)
    ),
    Expr::andX(
        Expr::equals('gender', 'M'),
        Expr::moreThan('points', 6000)
    )
);
```

Which is equivalent to: `(gender = "F" and points > 3000) or (gender = "M" and points > 6000)`

See the [Expr](https://github.com/K-Phoen/rulerz-spec-builder/blob/master/src/Spec/Expr.php)
class for an exhaustive list of supported methods.

License
-------

This library is under the [MIT](LICENSE) license.
