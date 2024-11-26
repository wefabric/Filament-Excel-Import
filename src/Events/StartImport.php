<?php

namespace Wefabric\FilamentExcelImport\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Wefabric\FilamentExcelImport\Models\ExcelImport;

class StartImport
{
    use Dispatchable, SerializesModels;

    public ExcelImport $excelImport;
    /**
     * Create a new event instance.
     */
    public function __construct(ExcelImport $excelImport)
    {
        $this->excelImport = $excelImport;
    }
}
