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

    /**
     * @dataProvider provider_for_stringIsCategory_returns_correct_results
     * @test
     *
     * @param string|null $input
     * @param bool $expect
     */
    public function stringIsCategory_returns_correct_results(?string $input, bool $expect): void
    {
        $this->assertSame($expect, call_private_method($this->class, 'stringIsCategory', $input));
    }

    public function provider_for_stringIsCategory_returns_correct_results(): array
    {
        return [
            ['~Some title~', true],
            ['~Русский заголовок~', true],
            ['~Without last tilda', true],
            ['Without first tilda~', false],
            ['Without both tildas', false],
            ['  ', false],
            [' ', false],
            ['', false],
            [null, false],
        ];
    }

    /**
     * @dataProvider provider_for_stringIsSubCategory_returns_correct_results
     * @test
     *
     * @param string|null $input
     * @param bool $expect
     */
    public function stringIsSubCategory_returns_correct_results(?string $input, bool $expect): void
    {
        $this->assertSame($expect, call_private_method($this->class, 'stringIsSubCategory', $input));
    }

    public function provider_for_stringIsSubCategory_returns_correct_results(): array
    {
        return [
            ['*Some title*', true],
            ['*Русский заголовок*', true],
            ['*Without last tilda', true],
            ['Without first tilda*', false],
            ['Without both tildas', false],
            ['  ', false],
            [' ', false],
            ['', false],
            [null, false],
        ];
    }

    /**
     * @dataProvider provider_for_removeMultipleSpaces_removes_string_with_only_1_space_instead_of_multiple
     * @test
     * @param string|null $input
     * @param string $expect
     */
    public function removeMultipleSpaces_removes_string_with_only_1_space_instead_of_multiple(?string $input, string $expect): void
    {
        $this->assertSame($expect, call_private_method($this->class, 'removeMultipleSpaces', $input));
    }

    public function provider_for_removeMultipleSpaces_removes_string_with_only_1_space_instead_of_multiple(): array
    {
        return [
            ['Some  string   with    lots of spaces', 'Some string with lots of spaces'],
            ['   Lots of   spaces  ', ' Lots of spaces '],
            ['C  o  o  l', 'C o o l'],
            ['          ', ' '],
            ['', ''],
            [null, ''],
        ];
    }
}