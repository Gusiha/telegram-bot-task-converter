<?php

namespace src\tests;

use PHPUnit\Framework\TestCase;
use src\domain\TelegramReportParser;
use src\exceptions\DomainException;

class TelegramReportParserTest extends TestCase
{
    private TelegramReportParser $parser;

    protected function setUp(): void
    {
        $this->parser = new TelegramReportParser();
    }

    public function additionWithRowsProvider(): array
    {
        return [
            'two rows' => ["hello\nhello", ['hello', 'hello']],
            'two rows with additional whitespaces' => ["  hello  \n hello ", ['hello', 'hello']],
        ];
    }
    public function additionEmptyProvider(): array
    {
        return [
            'empty' => [""],
            'only whitespaces' => ["      "],
            'only empty rows' => ["\n\n"],
            'rows with whitespaces' => ["   \n   \n   "]
        ];
    }

    /**
     * @dataProvider additionWithRowsProvider
     */
    public function testParseLinesWithValidRows(string $text, array $expected): void
    {
        $this->assertSame($expected, $this->parser->parseLines($text));
    }

    /**
     * @dataProvider additionEmptyProvider
     */
    public function testParseLinesWithEmptyText(string $text): void
    {
        $this->expectException(DomainException::class);
        $this->parser->parseLines($text);
    }
}
