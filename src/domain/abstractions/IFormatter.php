<?php

declare(strict_types=1);

namespace src\domain\abstractions;

interface IFormatter
{
    function formatLink(string $link, string $linkText): string;

    function formatDescription(string $description): string;

    function formatTitle(string $title): string;
}