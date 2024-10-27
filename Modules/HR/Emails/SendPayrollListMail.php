<?php
namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Modules\HR\Exports\ContractorFeeExport;
use Modules\HR\Exports\EmployeePayrollExport;

class SendPayrollListMail extends Mailable
{
    use Queueable, SerializesModels;
    public $toEmail;
    public $employeesData;

    protected $ccEmails;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($toEmail, $ccEmails, $employeesData)
    {
        $this->ccEmails = $ccEmails;
        $this->toEmail = $toEmail;
        $this->employeesData = $employeesData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $currentMonth = date('M');
        $currentYear = date('Y');
        $subject = 'Salary Calculations - ' . $currentMonth . ' ' . $currentYear;
        $employeeExportFilename = 'Salary Computations_' . $currentMonth . ' ' . $currentYear . '.xlsx';
        $contractorExportFilename = 'ConsultantFee_Computation_' . $currentMonth . '_' . $currentYear . '.xlsx';
        $mail = $this->from(config('invoice.mail.send-invoice.email'), config('invoice.mail.send-invoice.name'))
        ->subject($subject)
        ->to($this->toEmail['email'])
        ->bcc(config('invoice.mail.send-invoice.email'));
        foreach ($this->ccEmails as $emailAddress) {
            $email = trim($emailAddress);
            if ($email) {
                $mail->cc($email);
            }
        }

        return $mail
            ->attachData(
                Excel::raw(new EmployeePayrollExport($this->employeesData['full-time']), \Maatwebsite\Excel\Excel::XLSX),
                $employeeExportFilename,
                [
                    'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ]
            )
            ->attachData(
                Excel::raw(new ContractorFeeExport($this->employeesData['contractor']), \Maatwebsite\Excel\Excel::XLSX),
                $contractorExportFilename,
                [
                    'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ]
            )
            ->view('hr::payroll.payroll-list-mail', ['name' => $this->toEmail['name']]);
    }
}
