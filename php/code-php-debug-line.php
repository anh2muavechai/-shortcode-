<?php

function epic( $a, $b )
{
    fail( $a . ' ' . $b );
}

function fail( $string )
{
    $backtrace = debug_backtrace();

    print_r( $backtrace );
}

epic( 'Hello', 'World' );
Output:

Array
(
    [0] => Array
        (
            [file] => /Users/romac/Desktop/test.php
            [line] => 5
            [function] => fail
            [args] => Array
                (
                    [0] => Hello World
                )

        )

    [1] => Array
        (
            [file] => /Users/romac/Desktop/test.php
            [line] => 15
            [function] => epic
            [args] => Array
                (
                    [0] => Hello
                    [1] => World
                )

        )

)