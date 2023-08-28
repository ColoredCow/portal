<?php

namespace App\Console\Commands;

use Faker\Factory as Faker;
use Illuminate\Console\Command;
use Modules\Client\Entities\Client;
use Modules\Client\Entities\ClientAddress;
use Modules\Client\Entities\ClientContactPerson;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Entities\CodeTrekApplicantRoundDetail;
use Modules\CodeTrek\Entities\CodeTrekCandidateFeedback;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationRoundReview;
use Modules\HR\Entities\HRRejectionReason;
use Modules\HR\Entities\UniversityContact;
use Modules\Invoice\Entities\Invoice;
use Modules\Invoice\Entities\LedgerAccount;
use Modules\Project\Entities\Project;
use Modules\Prospect\Entities\Prospect;
use Modules\Prospect\Entities\ProspectContactPerson;
use Modules\Salary\Entities\EmployeeSalary;

class FakeProdDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:prod_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fake data in the database';

    protected $faker;

    public function __construct()
    {
        parent::__construct();

        $this->faker = Faker::create();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (! app()->environment(['local', 'staging', 'UAT'])) {
            return 0;
        }

        $this->fakeClientTablesData();
        $this->fakeCodetrekTablesData();
        $this->fakeEmployeeTablesData();
        $this->fakeHRTablesData();
        $this->fakeFinanceTablesData();
        $this->fakeProjectTablesData();
        $this->fakeProspectTablesData();

        return 0;
    }

    private function fakeClientTablesData()
    {
        foreach (Client::all() ?: [] as $client) {
            $client->name = $this->faker->company;
            $client->update();
        }

        foreach (ClientAddress::all() ?: [] as $clientAddress) {
            if ($clientAddress->country_id == 1) {
                $clientAddress->state = \Faker\Provider\en_IN\Address::state();
                $clientAddress->city = (new \Faker\Provider\en_IN\Address($this->faker))->city();
            } else {
                $clientAddress->state = \Faker\Provider\en_AU\Address::state();
                $clientAddress->city = (new \Faker\Provider\en_AU\Address($this->faker))->city();
            }

            $clientAddress->address = $this->faker->address;
            $clientAddress->update();
        }

        foreach (ClientContactPerson::all() ?: [] as $clientContactPerson) {
            $clientContactPerson->name = $this->faker->name;
            $clientContactPerson->email = $this->faker->email;
            $clientContactPerson->phone = $this->faker->phoneNumber;
            $clientContactPerson->update();
        }
    }

    private function fakeCodetrekTablesData()
    {
        foreach (CodeTrekApplicant::all() ?: [] as $codeTrekApplicant) {
            $codeTrekApplicant->first_name = $this->faker->firstName;
            $codeTrekApplicant->last_name = $this->faker->lastName;
            $codeTrekApplicant->email = $this->faker->email;
            $codeTrekApplicant->github_user_name = $this->faker->username;
            $codeTrekApplicant->update();
        }

        foreach (CodeTrekCandidateFeedback::all() ?: [] as $codeTrekCandidateFeedback) {
            $codeTrekCandidateFeedback->feedback = $this->faker->sentences(4, true);
            $codeTrekCandidateFeedback->update();
        }

        foreach (CodeTrekApplicantRoundDetail::all() ?: [] as $codeTrekApplicantRoundDetail) {
            $codeTrekApplicantRoundDetail->feedback = $this->faker->sentences(4, true);
            $codeTrekApplicantRoundDetail->update();
        }
    }

    private function fakeEmployeeTablesData()
    {
        foreach (EmployeeSalary::all() ?: [] as $employeeSalary) {
            $employeeSalary->monthly_gross_salary = $this->faker->numberBetween(300000, 2500000);
            $employeeSalary->update();
        }
    }

    private function fakeHRTablesData()
    {
        foreach (Applicant::all() ?: [] as $applicant) {
            $applicant->name = $this->faker->name;
            $applicant->email = $this->faker->email;
            $applicant->phone = $this->faker->phoneNumber;
            $applicant->linkedin = $this->faker->url;
            $applicant->update();
        }

        foreach (HRRejectionReason::whereNotNull('reason_comment')->get() ?: [] as $rejectionReason) {
            $rejectionReason->reason_comment = $this->faker->sentences(3, true);
            $rejectionReason->update();
        }

        foreach (ApplicationRoundReview::whereNotNull('review_value')->get() ?: [] as $applicationRoundReview) {
            $applicationRoundReview->review_value = $this->faker->sentences(3, true);
            $applicationRoundReview->update();
        }

        foreach (Application::whereNotNull('resume')->get() ?: [] as $application) {
            $application->resume = 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf';
            $application->update();
        }

        foreach (UniversityContact::all() ?: [] as $universityContact) {
            $universityContact->name = $this->faker->name;
            $universityContact->email = $this->faker->email;
            $universityContact->phone = $this->faker->phoneNumber;
            $universityContact->update();
        }
    }

    private function fakeFinanceTablesData()
    {
        $invoices = Invoice::whereNotNull('amount')->get();
        foreach ($invoices ?? [] as $invoice) {
            $invoice->amount = $this->faker->numberBetween(1000, 100000);
            if ($invoice->gst) {
                $invoice->gst = $invoice->amount * 0.18;
            }

            if ($invoice->comments) {
                $invoice->comments = $this->faker->sentences(2, true);
            }

            $invoice->save();
        }

        foreach ($invoices ?? [] as $invoice) {
            $invoice->amount = $this->faker->numberBetween(1000, 100000);
            if ($invoice->gst) {
                $invoice->gst = $invoice->amount * 0.18;
            }

            if ($invoice->comments) {
                $invoice->comments = $this->faker->sentences(2, true);
            }

            $invoice->update();
        }

        foreach (LedgerAccount::all() as $ledgerAccount) {
            if ($ledgerAccount->particulars) {
                $ledgerAccount->particulars = $this->faker->sentences(2, true);
            }

            if ($ledgerAccount->credit) {
                $ledgerAccount->credit = $this->faker->numberBetween(100, 100000);
            }

            if ($ledgerAccount->debit) {
                $ledgerAccount->debit = $this->faker->numberBetween(100, 100000);
            }

            if ($ledgerAccount->balance) {
                $ledgerAccount->balance = $ledgerAccount->credit - $ledgerAccount->debit;
            }

            $ledgerAccount->update();
        }
    }

    private function fakeProjectTablesData()
    {
        foreach (Project::all() ?: [] as $project) {
            $project->name = $this->faker->words(3, true);
            $project->update();
        }
    }

    private function fakeProspectTablesData()
    {
        foreach (ProspectContactPerson::all() ?: [] as $prospectContactPerson) {
            $prospectContactPerson->name = $this->faker->name;
            $prospectContactPerson->email = $this->faker->email;
            $prospectContactPerson->phone = $this->faker->phoneNumber;
            $prospectContactPerson->update();
        }

        foreach (Prospect::all() ?: [] as $prospect) {
            $prospect->name = $this->faker->words(3, true);
            $prospect->brief_info = $this->faker->sentences(4, true);
            $prospect->update();
        }
    }
}
