<?php

namespace Modules\Invoice\Console;

use Carbon\Carbon;
use Google\Client as GoogleClient;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Invoice\Emails\SendUploadedInvoicesMail;

class SendEmailForUploadedInvoices extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'invoice:email-for-uploaded-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send email to CA for the last month uploaded invoices';

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
        $previousMonthDate = Carbon::now()->subMonth()->startOfMonth();
        $invoiceFolderNames = [
            'indian' => [
                'folderName' => 'Invoices - IN (Indian)',
                'folderLink' => null,
            ],
            'international' => [
                'folderName' => 'Invoices - Ex (International)',
                'folderLink' => null,
            ],
        ];
        foreach ($invoiceFolderNames as $key => $folderDetail) {
            $countryFolderName = $folderDetail['folderName'];
            $monthFolderName = $previousMonthDate->format('M Y');
            $financialYear = $this->getFinancialYear($previousMonthDate);
            $googleDriveLink = $this->getFolderLink($monthFolderName, $financialYear, $countryFolderName);
            $invoiceFolderNames[$key]['folderLink'] = $googleDriveLink;
        }

        Mail::send(new SendUploadedInvoicesMail($invoiceFolderNames));
    }

    private function getFolderLink($monthFolderName, $financialYearFolderName, $countryFolderName)
    {
        $googleDriveParentFolderId = config('invoice.invoice-google-drive-folder-id');

        $client = new GoogleClient();
        $client->setAuthConfig(config('google.service.file'));  // Your credentials file
        $client->addScope(Drive::DRIVE);
        $client->setAccessType('offline');
        $service = new Drive($client);

        $invoiceCountryFolderId = $this->getOrCreateFolder($service, $countryFolderName, $googleDriveParentFolderId);
        $financialYearFolderId = $this->getOrCreateFolder($service, $financialYearFolderName, $invoiceCountryFolderId);
        $monthFolderId = $this->getOrCreateFolder($service, $monthFolderName, $financialYearFolderId);

        return "https://drive.google.com/drive/folders/{$monthFolderId}";
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
