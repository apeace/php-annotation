<?php

namespace Annotation;

class Parser {

    /**
     * @param string $comment
     */
    public static function parse($comment) {
        print_r(self::extractAnnotationStrings($comment));
    }

    /**
     * @param string $comment
     * @return string[]
     */
    public static function extractAnnotationStrings($comment) {
        // split comment into lines using os-agnostic newline regex
        $lines = preg_split('/\R/', $comment);

        $annotationStrings = [];
        foreach($lines as $line) {
            $matches = null;
            // match comment lines that begin with @, and remove
            // the leading spaces and asterisks
            preg_match('/^\s*\**\s*(@.*)/', $line, $matches);
            if ($matches) {
                $annotationStrings[] = $matches[1];
            }
        }

        return $annotationStrings;
    }

}