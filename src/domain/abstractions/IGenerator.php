<?php

declare(strict_types=1);

namespace src\domain\abstractions;

interface IGenerator
{
    function generate(string $text): string;
}