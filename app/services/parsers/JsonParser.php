<?php


namespace App\services\parsers;


use App\contracts\Parser;

class JsonParser implements Parser
{
    public function parse(string $input): array
    {
        return json_decode($input, true);
    }
}