<?php

namespace Wefabric\ExcelImport\Actions;

use Wefabric\ExcelImport\Concerns\FilamentResource;
use Wefabric\ExcelImport\Models\ExcelImport;
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
