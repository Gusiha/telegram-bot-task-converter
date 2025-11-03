<?php

declare(strict_types=1);

namespace src\domain;

use src\domain\abstractions\IFormatter;
use src\domain\abstractions\IParser;
use src\exceptions\DomainException;

//TODO Создать класс Ticket
class TelegramReportGenerator
{
    private IParser $parser;
    private IFormatter $formatter;

    function __construct(IParser $parser, IFormatter $formatter)
    {
        $this->parser = $parser;
        $this->formatter = $formatter;
    }

    function generate(string $text): string
    {
        $result = array();
        try {
            $lines = $this->parser->parseLines($text);
            foreach ($lines as $line) {
                $link = $this->parser->parseLink($line);
                $title = $this->parser->parseTitle($line);
                $description = $this->parser->parseDescription($line);
                $linkText = $this->parser->parseLinkText($line);

                $formattedLink = $this->formatter->formatLink($link, $linkText);
                $formattedTitle = $this->formatter->formatTitle($title);
                $formattedDescription = $this->formatter->formatDescription($description);
                $formattedLinkText = $this->formatter->formatDescription($description);

                //TODO Сборка строки
            }
            return "";
        } catch (DomainException $e) {
            return $e->getMessage();
        }
    }
}