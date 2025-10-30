<?php

declare(strict_types=1);

namespace src\domain\abstractions;

interface IParser
{
    function parseLinkText(string $row): string;

    function parseTitle(string $row): string;

    function parseLink(string $row): string;

    function parseDescription(string $row): string;

    function parseLines(string $text): array;
}