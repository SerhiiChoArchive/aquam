<?php declare(strict_types=1);

namespace App;

use SplFileObject;

final class CsvHandler
{
    /** @var string $file_path */
    private $file_path;

    public function __construct(string $file_path)
    {
        $this->file_path = $file_path;
    }

    public function getAll(): array
    {
        $file = new SplFileObject($this->file_path);

        $result = [];

        while (!$file->eof()) {
            $result[] = $file->fgetcsv();
        }

        return $result;
    }
}
