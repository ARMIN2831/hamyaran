<?php

namespace App\Jobs;

use App\Models\Student;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;

class ImportStudentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
            Excel::import(new StudentsImport($this->errorHandling, $this->user), $this->filePath);
            Storage::append('upload_log.txt', "File processed successfully at " . now() . "\n");
            Log::info('Import process completed successfully.');
        } catch (Exception $e) {
            Log::error('An error occurred during the import process: ' . $e->getMessage());
            Storage::append('upload_log.txt', "File processing failed at " . now() . " with error: " . $e->getMessage() . "\n");
            throw $e;
        }
    }
}
