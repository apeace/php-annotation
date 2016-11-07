<?php

namespace Annotation;

class Parser {

    /**
     * @param string $comment
     * @return string[]
     */
    public static function extractAnnotationLines($comment) {
        // split comment into lines using os-agnostic newline regex
        $lines = preg_split('/\R/', $comment);

        $annotationStrings = [];
        foreach($lines as $line) {
            $matches = null;
            // match comment lines that begin with @, and remove
            // the leading spaces and asterisks
            preg_match('/^(\s|\*)*(@.*)/', $line, $matches);
            if ($matches) {
                $annotationStrings[] = $matches[2];
            }
        }

        return $annotationStrings;
    }

    public static function parseAnnotationLine($line) {
        $matches = null;
        preg_match('/@(\S+)/', $line, $matches);
        if (!$matches) {
            throw new Exception('Does not match expected pattern');
        }
        return new Annotation($line, $matches[1], []);
    }

}