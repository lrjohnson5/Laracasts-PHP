<?php

use Core\Container;

test('it can resolve something out of the container', function () {
    // arrange
    $container = new Container();

    $container->bind('foo', function () {
        return 'bar';
    });

    // above could be replaced by a shorthand single-line arrow function:
    // $container->bind('foo', fn() => 'bar');

    // act
    $result = $container->resolve('foo');

    // assert or expect
    expect($result)->toEqual('bar');
});
