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
        // extract annotation name. it is simply any characters
        // following the @, up to the first whitespace or open paren.
        $matches = null;
        preg_match('/^@([^\s(]+)/', $line, $matches);
        if (!$matches) {
            throw new Exception(sprintf('Could not match annotation name: `%s`', $line));
        }
        $name = $matches[1];

        // parse the rest of the line as args
        $args = self::parseArgs(substr($line, strlen($name)+1));

        return new Annotation($line, $name, $args);
    }

    public static function parseArgs($argString) {
        $argString = trim($argString);

        // empty args
        if (strlen($argString) == 0) {
            return [];
        }

        // no parens makes it simple args separated by whitespace
        if ($argString[0] !== '(') {
            return preg_split('/\s+/', $argString);
        }

        // TODO
        return [];
    }

}