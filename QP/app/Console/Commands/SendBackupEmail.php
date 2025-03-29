<?php

namespace App\Console\Commands;

use App\Exports\EventExport;
use Maatwebsite\Excel\Facades\Excel as ExcelFacade;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Mail\ExportMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;

class SendBackupEmail extends Command
{
    protected $signature = 'app:send-backup-email';
    protected $description = 'Exports the events table and emails the backup file';

    public function handle()
    {
        $timestamp = Carbon::now()->format('Y_m_d_H_i');
        $fileName = "events_backup_{$timestamp}.xlsx";
        $filePath = "backup/{$fileName}";

        // Ensure backup directory exists
        if (!Storage::exists('backup')) {
            Storage::makeDirectory('backup');
        }

        // Store the Excel file
        ExcelFacade::store(new EventExport, $filePath, 'local');

        // Get the full path for attachment
        $fullFilePath = storage_path("app/{$filePath}");

        // Send the email with attachment
        Mail::to('qpdbbackup@gmail.com')->send(new ExportMail($fileName, $fullFilePath));

        // Delete the file after sending
        Storage::delete($filePath);    

        $this->info('Backup exported and email sent successfully.');
    }
}
