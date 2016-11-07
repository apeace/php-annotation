<?php

use Annotation\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase {

    const COMMENT = <<<DOCCOMMENT
/**
 * This is an example doc comment.
 *
 * @annotationPlain
 * @annotationArgsStringNoParens string string string
 * @annotationArgsEmpty()
 * @annotationArgsPositional(1, 'string', true)
 * @annotationArgsNamed(mynum=1, mystr='string', mybool=true)
 *
 * You might think @this is an annotation, but it is not.
 */
DOCCOMMENT;

    public function test_extract_annotation_lines() {
        $strings = Parser::extractAnnotationLines(self::COMMENT);
        $expected = [
            '@annotationPlain',
            '@annotationArgsStringNoParens string string string',
            '@annotationArgsEmpty()',
            '@annotationArgsPositional(1, \'string\', true)',
            '@annotationArgsNamed(mynum=1, mystr=\'string\', mybool=true)'
        ];
        $this->assertEquals($expected, $strings, 'Annotation lines not extracted correctly');
    }

    public function test_parse_annotation_line() {
        $line = '@annotationPlain';
        $expected = new \Annotation\Annotation($line, 'annotationPlain', []);
        $annotation = Parser::parseAnnotationLine($line);
        $this->assertEquals($expected, $annotation, '');

        $line = '@annotationStringNoParens string string string';
        $expected = new \Annotation\Annotation($line, 'annotationStringNoParens', ['string', 'string', 'string']);
        $annotation = Parser::parseAnnotationLine($line);
        $this->assertEquals($expected, $annotation, '');

        $line = '@annotationArgsEmpty()';
        $expected = new \Annotation\Annotation($line, 'annotationArgsEmpty', []);
        $annotation = Parser::parseAnnotationLine($line);
        $this->assertEquals($expected, $annotation, '');

        /*
        $line = '@annotationArgsPositional(1, \'string\', true)';
        $expected = new \Annotation\Annotation($line, 'annotationArgsPositional', [1, 'string', true]);
        $annotation = Parser::parseAnnotationLine($line);
        $this->assertEquals($expected, $annotation, '');
        */
    }

    public function test_parse_args() {
        $args = 'string string string';
        $expected = ['string', 'string', 'string'];
        $arr = Parser::parseArgs($args);
        $this->assertEquals($expected, $arr, '');

        $args = '    string string string      ';
        $expected = ['string', 'string', 'string'];
        $arr = Parser::parseArgs($args);
        $this->assertEquals($expected, $arr, '');

        $args = '()';
        $expected = [];
        $arr = Parser::parseArgs($args);
        $this->assertEquals($expected, $arr, '');

        $args = '(1, \'string\', true)';
        $expected = [1, 'string', true];
        $arr = Parser::parseArgs($args);
        $this->assertEquals($expected, $arr, '');
    }

}