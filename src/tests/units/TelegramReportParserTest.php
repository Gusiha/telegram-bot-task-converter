<?php

namespace src\tests\units;

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

    /**
     * @dataProvider \src\tests\providers\TelegramReportParserDataProviders::getRowsWithTextAndExcessWhitespaces
     */
    public function testParseLinesReturnsTrimmedRows(string $text, array $expected): void
    {
        $this->assertSame($expected, $this->parser->parseLines($text));
    }

    /**
     * @dataProvider \src\tests\providers\TelegramReportParserDataProviders::getEmptyRows
     */
    public function testParseLinesThrowsExceptionOnEmptyRows(string $text): void
    {
        $this->expectException(DomainException::class);
        $this->parser->parseLines($text);
    }

    /**
     * @dataProvider \src\tests\providers\TelegramReportParserDataProviders::getEmptyRows
     */
    public function testParseLinkThrowsExceptionOnEmptyRows(string $text): void
    {
        $this->expectException(DomainException::class);
        $this->parser->parseLink($text);
    }

    /**
     * @dataProvider \src\tests\providers\TelegramReportParserDataProviders::getTicketsWithInvalidUrl()
     */
    public function testParseLinkThrowsExceptionOnTicketsWithInvalidUrl(string $text): void
    {
        $this->expectException(DomainException::class);
        $this->parser->parseLink($text);
    }

    /**
     * @dataProvider \src\tests\providers\TelegramReportParserDataProviders::getValidTicket()
     */
    public function testParseLinkReturnsUrlOnValidTicket(string $text, string $expected): void
    {
        $this->assertSame($expected, $this->parser->parseLink($text));
    }
}
