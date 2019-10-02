<?php


namespace App\services\parsers;


class ParserFactory
{
    public function createJsonParser(): JsonParser
    {
        return new JsonParser();
    }

    public function createCsvParser(bool $skipHeaderLine): CsvParser
    {
        return new CsvParser($skipHeaderLine);
    }
}