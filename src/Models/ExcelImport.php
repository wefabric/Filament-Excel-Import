<?php

namespace Wefabric\FilamentExcelImport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Validators\Failure;

class ExcelImport extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'storage_disk',
        'excel_class',
        'imported_at',
        'failed_at',
        'errors',
        'messages',
    ];


    protected $casts = [
        'errors' => 'array',
        'messages' => 'array',
    ];

    public function isCompleted(): bool
    {
        return $this->isImported() || $this->isFailed();
    }

    public function isFailed(): bool
    {
        return (bool)$this->failed_at;
    }

    public function isImported(): bool
    {
        return (bool)$this->imported_at;
    }

    public function getErrors(): array
    {
        $errors = [];
        foreach ($this->errors as $error) {
            $errors[] = new Failure($error['row'], $error['attribute'], $error['errors'], $error['values']);
        }
        return $errors;
    }

    public function getFilePath(): string
    {
        return Storage::disk($this->storage_disk)->path($this->path);
    }
}
