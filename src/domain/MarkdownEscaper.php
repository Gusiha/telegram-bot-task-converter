<?php

declare(strict_types=1);

namespace src\domain;

class MarkdownEscaper
{
    protected array $escapeSymbols = ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];

    public function escapeMarkdown(string $text): string
    {
        $escapedText = '';

        foreach (mb_str_split($text) as $char) {
            if (in_array($char, $this->escapeSymbols, true)) {
                $escapedText .= '\\' . $char;
            } else {
                $escapedText .= $char;
            }
        }
        return $escapedText;
    }

}