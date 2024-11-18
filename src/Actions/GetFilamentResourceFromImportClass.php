<?php

namespace Wefabric\FilamentExcelImport\Actions;

use Wefabric\FilamentExcelImport\Concerns\FilamentResource;
use Wefabric\FilamentExcelImport\Models\ExcelImport;
use Filament\Resources\Resource;

class GetFilamentResourceFromImportClass
{

    public function execute(ExcelImport $excelImport): ?Resource
    {
        $excelClass = $excelImport->excel_class;
        $class = new $excelClass;
        if($class instanceof FilamentResource) {
            /**
             * @var $filamentResource Resource
             */
            $filamentResource = $class->getFilamentResource();
            return new $filamentResource;
        }
        return null;
    }

}
