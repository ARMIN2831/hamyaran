<?php

namespace App\Jobs;

use App\Imports\InstitutesImport;
use App\Imports\StudentsImport;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportInstitutesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, \Illuminate\Bus\Queueable, SerializesModels;

    protected $filePath;
    protected $errorHandling;
    protected $user;

    public function __construct($filePath, $errorHandling, $user)
    {
        $this->filePath = $filePath;
        $this->errorHandling = $errorHandling;
        $this->user = $user;
    }

    public function handle()
    {
        Log::info('Starting the import process.');
        try {
            Excel::import(new InstitutesImport($this->errorHandling, $this->user), $this->filePath);
            Storage::append('upload_log_institute.txt', "File processed successfully at " . now() . "\n");
            Log::info('Import process completed successfully.');
        } catch (Exception $e) {
            Log::error('An error occurred during the import process: ' . $e->getMessage());
            Storage::append('upload_log_institute.txt', "File processing failed at " . now() . " with error: " . $e->getMessage() . "\n");
            throw $e;
        }
    }
}
