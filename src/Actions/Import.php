<?php

namespace Wefabric\ExcelImport\Actions;

use DateInterval;
use DateTimeInterface;
use Wefabric\ExcelImport\Models\ExcelImport;

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
            \Wefabric\ExcelImport\Jobs\ExcelImport::dispatchSync($excelImport);
            return $excelImport;
        }

        if($schedule === true) {
            \Wefabric\ExcelImport\Jobs\ExcelImport::dispatch($excelImport);
            return $excelImport;
        }

        \Wefabric\ExcelImport\Jobs\ExcelImport::dispatch($excelImport)->delay($schedule);
        return $excelImport;
    }
}
