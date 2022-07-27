<?php

use Core\Domain\Validaton\DomainValidation;

require __DIR__ . '/../vendor/autoload.php';

$teste = null;
DomainValidation::notNull($teste);