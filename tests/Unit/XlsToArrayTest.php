<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Converters\XlsToArray;
use App\Exceptions\PriceListValidationException;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
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

    /** @test */
    public function getColumns_returns_correct_result_if_article_is_column_title(): void
    {
        $items = $this->getItemsForTestingGetColumnsMethod();
        $article = '~ГОЛОВЫ~';
        $column_names = ['name', 'description', 'price'];

        $expected = [
            'article' => '~ГОЛОВЫ~',
            'name' => null,
            'description' => null,
            'price' => null,
        ];

        $result = call_private_method($this->class, 'getColumns', $article, $items, $column_names, 1);

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function getColumns_returns_correct_result_if_article_is_column_second_title(): void
    {
        $items = $this->getItemsForTestingGetColumnsMethod();
        $article = '   *XILONG*';
        $column_names = ['name', 'description', 'price'];

        $expected = [
            'article' => '*XILONG*',
            'name' => null,
            'description' => null,
            'price' => null,
        ];

        $result = call_private_method($this->class, 'getColumns', $article, $items, $column_names, 2);

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function getColumns_returns_correct_result_if_article_is_not_column_title(): void
    {
        $items = $this->getItemsForTestingGetColumnsMethod();
        $article = 'XL-008';
        $column_names = ['name', 'description', 'price'];

        $expected = [
            'article' => 'XL-008',
            'name' => 'Awesome',
            'description' => 'Short',
            'price' => 234.2,
        ];

        $result = call_private_method($this->class, 'getColumns', $article, $items, $column_names, 3);

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function getColumns_returns_text_from_RichText_object_for_article_if_article_is_RichText_object(): void
    {
        $items = $this->getItemsForTestingGetColumnsMethod();
        $column_names = ['name', 'description', 'price'];

        $rich_text = $this->createStub(RichText::class);
        $rich_text->method('getPlainText')->willReturn('Plain text');

        $result = call_private_method($this->class, 'getColumns', $rich_text, $items, $column_names, 3);

        $this->assertSame('Plain text', $result['article']);
    }

    /** @test */
    public function getColumns_casts_article_to_string_if_provided_article_is_int(): void
    {
        $items = $this->getItemsForTestingGetColumnsMethod();
        $column_names = ['name', 'description', 'price'];
        $article = 24;

        $result = call_private_method($this->class, 'getColumns', $article, $items, $column_names, 3);

        $this->assertSame('24', $result['article']);
    }

    /**
     * @return array[]
     */
    protected function getItemsForTestingGetColumnsMethod(): array
    {
        $items = [
            ['Артикул', '~ГОЛОВЫ~', '   *XILONG*', 'XL-008', 'XL-010', 'XL-011', 'XL-012'],
            ['Имя', null, null, 'Awesome', 'Cool', 'Nice', 'Ugly'],
            ['Описание', null, null, 'Short', 'Long', 'Medium', 'Some'],
            ['Цена', null, null, 234.2, 33, 344, 11.1],
            ['Акция', null, null, 'нет', 'да', 'нет', 'нет'],
        ];

        return $items;
    }

    /** @test */
    public function throwIfTitleDoesntHaveSpecialCharacters_throws_exception_if_title_is_boolean(): void
    {
        $this->expectException(PriceListValidationException::class);
        $this->expectExceptionMessage(<<<'MSG'
        Проверте правильность прайса. Убедитесь что нет пустых строк, категорий и подкатегорий.
        MSG);

        $title = false;
        $next_title = 'Some title';
        call_private_method($this->class, 'throwIfTitleDoesntHaveSpecialCharacters', $title, $next_title);
    }

    /** @test */
    public function throwIfTitleDoesntHaveSpecialCharacters_throws_exception_if_title_doesnt_have_special_symbol(): void
    {
        $this->expectException(PriceListValidationException::class);
        $this->expectExceptionMessage(<<<'MSG'
        Проверте правильность ввода категории или подкатегории "Title is here".
        Каждая категория должна начинаться с символа ~, а подкатегория с символа *.
        MSG);

        $title = 'Title is here';
        $next_title = 'Some title';
        call_private_method($this->class, 'throwIfTitleDoesntHaveSpecialCharacters', $title, $next_title);
    }

    /** @test */
    public function throwIfTitleDoesntHaveSpecialCharacters_doesnt_throw_exception_if_next_title_is_empty(): void
    {
        $title = 'Title is here';
        call_private_method($this->class, 'throwIfTitleDoesntHaveSpecialCharacters', $title, '');
        $this->assertTrue(true);
    }

    /** @test */
    public function throwIfTitleDoesntHaveSpecialCharacters_doesnt_throw_exception_if_title_has_category_characters(): void
    {
        $title = '~Title is here~';
        $next_title = '';
        call_private_method($this->class, 'throwIfTitleDoesntHaveSpecialCharacters', $title, $next_title);
        $this->assertTrue(true);
    }

    /** @test */
    public function throwIfTitleDoesntHaveSpecialCharacters_doesnt_throw_exception_if_title_has_subcategory_characters(): void
    {
        $title = '*Title is here*';
        call_private_method($this->class, 'throwIfTitleDoesntHaveSpecialCharacters', $title, '');
        $this->assertTrue(true);
    }
}