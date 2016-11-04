<?php

use Annotate\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase {

    public function test_parse() {
        $this->assertTrue(Parser::parse('foo'));
    }

}