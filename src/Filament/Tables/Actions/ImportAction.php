<?php

namespace Wefabric\FilamentExcelImport\Filament\Tables\Actions;


use Wefabric\FilamentExcelImport\Actions\Import;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Collection;

class ImportAction extends Action
{

    protected string $importClass;
    protected bool $scheduledImport = true;

    public function setUp(): void
    {
        parent::setUp();

        $this->action(function (Collection $records, array $data): void {

            if(!$this->importClass) {
                throw new \Exception('Import class not set. Use importClass() method.');
            }

            (new Import())->execute($this->importClass, $data['file'], config('filesystems.default'), $this->scheduledImport);
        })
            ->label('Import')
            ->button()
            ->icon('heroicon-o-cloud-arrow-up')
            ->form([FileUpload::make('file')
                ->label('CSV file')
                ->disk(config('filesystems.default'))
                ->required()
                ->acceptedFileTypes(['text/plain', 'text/csv', 'application/csv', 'application/excel'])
                ->hint('Only csv files are allowed.')]);
    }

    public function importClass(string $importClass): self
    {
        $this->importClass = $importClass;

        return $this;
    }
    public function scheduledImport(bool $scheduledImport = true): self
    {
        $this->scheduledImport = $scheduledImport;

        return $this;
    }
}
