<?php

use Annotation\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase {

    const COMMENT = <<<DOCCOMMENT
/**
 * This is an example doc comment.
 *
 * @annotationPlain
 * @annotationArgsPositionalNoParens string string string
 * @annotationArgsEmpty()
 * @annotationArgsPositional(1, 'string', true)
 * @annotationArgsNamed(mynum=1, mystr='string', mybool=true)
 *
 * You might think @this is an annotation, but it is not.
 */
DOCCOMMENT;


    public function test_extract_annotation_strings() {
        $strings = Parser::extractAnnotationStrings(self::COMMENT);
        $expected = [
            '@annotationPlain',
            '@annotationArgsPositionalNoParens string string string',
            '@annotationArgsEmpty()',
            '@annotationArgsPositional(1, \'string\', true)',
            '@annotationArgsNamed(mynum=1, mystr=\'string\', mybool=true)'
        ];
        $this->assertEquals($expected, $strings, 'Annotation strings not extracted correctly');
    }

}