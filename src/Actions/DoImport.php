<?php

namespace Wefabric\FilamentExcelImport\Actions;

use Carbon\Carbon;
use Wefabric\FilamentExcelImport\Concerns\CountImports;
use Wefabric\FilamentExcelImport\Events\EndImport;
use Wefabric\FilamentExcelImport\Events\StartImport;
use Wefabric\FilamentExcelImport\Models\ExcelImport;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\Failure;

class DoImport
{
    public function execute(ExcelImport $excelImport, bool $force = false): ExcelImport
    {
        if (!$force && $excelImport->isImported()) {
            return $excelImport;
        }
        event(new StartImport($excelImport));
        $messages = [];


        try {
            $class = new ($excelImport->excel_class);
            $result = Excel::import($class, $excelImport->path, empty($excelImport->storage_disk) ? null : $excelImport->storage_disk);

            if ($result) {

                if ($result instanceof SkipsOnFailure) {
                    if (isset($result->failures)) {
                        $this->processFailures($excelImport, $result->failures);
                    }
                }

                if ($class instanceof CountImports && $class->count() > 0) {
                    $messages[] = sprintf('Imported %d items', $class->count());
                }

                if (!$messages) {
                    $messages[] = 'Imported items';
                }

                $excelImport->imported_at = new Carbon();
                $excelImport->messages = $messages;
                $excelImport->save();
            }
        } catch (\Exception $e) {
            if ($e instanceof \Maatwebsite\Excel\Validators\ValidationException) {
                return $this->processFailures($excelImport, $e->failures());
            }

            if ($e instanceof ValidationException) {
                return $this->processValidationException($excelImport, $e);
            }

            throw $e;

        }
        event(new EndImport($excelImport));

        return $excelImport;
    }

    private function processValidationException(ExcelImport $excelImport, ValidationException $exception): ExcelImport
    {
        $errors = [];

        if ($data = $exception->validator->getData()) {
            if (isset($data['row'])) {
                $errors[] = 'Row ' . $data['row'] . ': ' . $exception->getMessage();
            }
        } else {
            $errors[] = $exception->getMessage();
        }

        $excelImport->errors = $errors;
        $excelImport->failed_at = new Carbon();
        $excelImport->save();

        return $excelImport;
    }

    private function processFailures(ExcelImport $excelImport, Collection $failures): ExcelImport
    {

        /**
         * @var Failure $failure
         */
        $errors = [];
        foreach ($failures as $failure) {
            $errors[] = $failure->jsonSerialize();
        }

        $excelImport->errors = $errors;
        $excelImport->failed_at = new Carbon();
        $excelImport->save();

        return $excelImport;
    }
}
