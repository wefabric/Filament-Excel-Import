<?php

namespace Wefabric\FilamentExcelImport\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Wefabric\FilamentExcelImport\Models\ExcelImport;

class StartImport
{
    use Dispatchable, SerializesModels;

    public ExcelImport $excelImport;
    public ?Authenticatable $user;
    /**
     * Create a new event instance.
     */
    public function __construct(ExcelImport $excelImport)
    {
        $this->user = Auth::user();
        $this->excelImport = $excelImport;
    }
}
