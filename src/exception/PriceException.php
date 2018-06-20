<?php

class PriceException extends \Exception
{
    public function __construct($level) {
        parent::__construct("", $level);
    }

    public function getLevel() {
        return $this->getCode();
    }
}