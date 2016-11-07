<?php

namespace Annotation;

class Annotation {
    /** @var string */
    public $annotationString;

    /** @var string */
    public $name;

    /** @var array */
    public $args;

    public function __construct($annotationString, $name, $args) {
        $this->annotationString = $annotationString;
        $this->name = $name;
        $this->args = $args;
    }
}