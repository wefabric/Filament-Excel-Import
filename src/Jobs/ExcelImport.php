<?php

namespace Wefabric\FilamentExcelImport\Jobs;

use App\Models\User;
use Wefabric\FilamentExcelImport\Actions\DoImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExcelImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public \Wefabric\FilamentExcelImport\Models\ExcelImport $excelImport, public ?User $user = null)
    {
        $this->onQueue('excel_import');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new DoImport())->execute($this->excelImport, false, $this->user);
    }
}
