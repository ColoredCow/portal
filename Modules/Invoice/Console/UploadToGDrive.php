<?php

namespace Modules\Invoice\Console;

use Carbon\Carbon;
use Google\Client as GoogleClient;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Illuminate\Console\Command;
use Modules\Invoice\Entities\Invoice;

class UploadToGDrive extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'invoice:upload-to-gdrive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will upload the invoices to GDrive.';

    /**
     * The console command signature for arguments.
     *
     * @var string
     */
    protected $signature = 'invoice:upload-to-gdrive {startDate?} {endDate?}';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $startDate = $this->argument('startDate')
            ? Carbon::parse($this->argument('startDate'))
            : Carbon::now()->subMonth()->startOfMonth();

        $endDate = $this->argument('endDate')
            ? Carbon::parse($this->argument('endDate'))
            : Carbon::now()->subMonth()->endOfMonth();

        $this->info('Uploading invoices from ' . $startDate->toDateString() . ' to ' . $endDate->toDateString());

        $invoices = Invoice::whereBetween('sent_on', [$startDate, $endDate])->get();
        foreach ($invoices as $invoice) {
            if (! $invoice->file_path) {
                continue;
            }
            $monthFolderName = $invoice->sent_on->format('M Y');
            $financialYear = $this->getFinancialYear($invoice->sent_on);
            $fileLocalPath = storage_path('app/' . $invoice->file_path);
            $isIndianInvoice = substr($invoice->invoice_number, 0, 2) == 'IN';
            $googleDriveLink = $this->uploadFileToGoogleDrive($fileLocalPath, $monthFolderName, $financialYear, $isIndianInvoice);

            // Update the google_drive_link column of the invoice
            $invoice->google_drive_link = $googleDriveLink;
            $invoice->save();

            $this->info("Updated google_drive_link for invoice ID {$invoice->id}");
            sleep(1);
        }
    }

    private function uploadFileToGoogleDrive($filePath, $monthFolderName, $financialYearFolderName, $isIndianInvoice)
    {
        $googleDriveParentFolderId = config('invoice.invoice-google-drive-folder-id');

        $client = new GoogleClient();
        $client->setAuthConfig(config('google.service.file'));  // Your credentials file
        $client->addScope(Drive::DRIVE);
        $client->setAccessType('offline');
        $service = new Drive($client);
        $countryFolderName = $isIndianInvoice ? 'Invoices - IN (Indian)' : 'Invoices - Ex (International)';

        $invoiceCountryFolderId = $this->getOrCreateFolder($service, $countryFolderName, $googleDriveParentFolderId);
        $financialYearFolderId = $this->getOrCreateFolder($service, $financialYearFolderName, $invoiceCountryFolderId);
        $monthFolderId = $this->getOrCreateFolder($service, $monthFolderName, $financialYearFolderId);
        $content = file_get_contents($filePath);
        $fileName = basename($filePath);
        $fileMetadata = new DriveFile([
            'name' => $fileName,
            'parents' => [$monthFolderId],
        ]);

        $uploadedFile = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => mime_content_type($filePath),
            'uploadType' => 'multipart',
            'fields' => 'id, webViewLink, webContentLink',
        ]);

        $this->info('Uploaded invoice: ' . $fileName . ' to folder: ' . $countryFolderName . '/' . $monthFolderName);

        return $uploadedFile->webViewLink;
    }

    private function getOrCreateFolder($service, $folderName, $parentFolderId)
    {
        // Search for the folder
        $query = "name = '$folderName' and mimeType = 'application/vnd.google-apps.folder' and '{$parentFolderId}' in parents and trashed = false";
        $results = $service->files->listFiles([
            'q' => $query,
            'fields' => 'files(id, name)',
        ]);

        if (count($results->files) > 0) {
            // Folder exists, return its ID
            return $results->files[0]->id;
        }

        // Folder doesn't exist, create it
        $fileMetadata = new DriveFile([
            'name' => $folderName,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => [$parentFolderId],  // Create inside the parent folder
        ]);

        $folder = $service->files->create($fileMetadata, [
            'fields' => 'id',
        ]);

        return $folder->id;  // Return the newly created folder ID
    }

    private function getFinancialYear(Carbon $date)
    {
        $year = $date->year;

        // If the date is between January and March, it belongs to the previous financial year.
        if ($date->month < 4) {
            $startYear = $year - 1;
            $endYear = $year;
        } else {
            // If the date is between April and December, it belongs to the current financial year.
            $startYear = $year;
            $endYear = $year + 1;
        }
        $endYear = (string) $endYear;
        $shortEndYear = substr($endYear, -2);

        return $startYear . '-' . $shortEndYear;
    }
}
