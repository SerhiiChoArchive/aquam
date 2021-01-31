<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Converters\XlsToArray;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

use function SandFox\Debug\call_private_method;

class XlsToArrayTest extends TestCase
{
    private MockObject $class;

    public function setUp(): void
    {
        parent::setUp();
        $this->class = $this->getMockForAbstractClass(XlsToArray::class, ['path', new Xlsx()]);
    }

    /** @test */
    public function getNotNulls_removes_nulls_from_given_array(): void
    {
        $input = [3, 'cool', null, 'nice', null];
        $expected = [3, 'cool', 'nice'];

        $result = call_private_method($this->class, 'getNotNulls', $input);

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function getNotNulls_removes_empty_strings_from_given_array(): void
    {
        $input = ['', 'cool', '', 'nice', 234];
        $expected = ['cool', 'nice', 234];

        $result = call_private_method($this->class, 'getNotNulls', $input);

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function getNotNulls_removes_strings_with_0_decimal_value_from_given_array(): void
    {
        $input = ['0.00', 'awesome', '0.00', 'cool', 23];
        $expected = ['awesome', 'cool', 23];

        $result = call_private_method($this->class, 'getNotNulls', $input);

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function getNotNulls_not_removing_integers_with_0_value_from_given_array(): void
    {
        $input = [0, 'awesome', 0, 'cool', 23];
        $expected = [0, 'awesome', 0, 'cool', 23];

        $result = call_private_method($this->class, 'getNotNulls', $input);

        $this->assertSame($expected, $result);
    }
}