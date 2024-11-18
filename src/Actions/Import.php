<?php

namespace Wefabric\FilamentExcelImport\Actions;

use DateInterval;
use DateTimeInterface;
use Wefabric\FilamentExcelImport\Models\ExcelImport;

class Import
{

    public function execute(string $importClass, string $path, string $storageDisk = '', bool|DateInterval|DateTimeInterface|int|null $schedule = null): ExcelImport
    {
        $excelImport = new ExcelImport();
        $excelImport->excel_class = $importClass;
        $excelImport->storage_disk = $storageDisk;
        $excelImport->path = $path;

        $excelImport->save();

        if($schedule === false || $schedule === null) {
            \Wefabric\FilamentExcelImport\Jobs\ExcelImport::dispatchSync($excelImport);
            return $excelImport;
        }

        if($schedule === true) {
            \Wefabric\FilamentExcelImport\Jobs\ExcelImport::dispatch($excelImport);
            return $excelImport;
        }

        \Wefabric\FilamentExcelImport\Jobs\ExcelImport::dispatch($excelImport)->delay($schedule);
        return $excelImport;
    }
}
