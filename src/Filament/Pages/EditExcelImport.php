<?php

namespace Wefabric\FilamentExcelImport\Filament\Pages;

use Wefabric\FilamentExcelImport\Filament\ExcelImportResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExcelImport extends EditRecord
{
    protected static string $resource = ExcelImportResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
