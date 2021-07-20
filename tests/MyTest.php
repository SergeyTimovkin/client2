<?php

use PHPUnit\Framework\TestCase;
use EnricoStahn\JsonAssert\Assert as JsonAssert;

class MyTest extends TestCase
{
    use JsonAssert;
    public function testMy(): void
    {
        $json = json_decode('{"foo":1}');

      //  $this->assertJsonMatchesSchema($json, './my-schema.json');
        $this->assertJsonValueEquals(1, '* | [0]', $json);
        $this->assertTrue(true);
    }
}