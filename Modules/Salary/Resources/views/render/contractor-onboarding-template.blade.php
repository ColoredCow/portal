<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <style>
        @page {
            size: landscape;
            margin: 80px 20px 100px 20px;
        }
        body {
            font-weight: normal;
            font-family: sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            font-size: 14px;
            background: white !important;
        }

        .body-container {
            padding-left: 20px;
            padding-right: 20px;
        }

        .confidential-text {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            padding-top: 20px;
            text-align: center;
            text-decoration: underline;
        }

        .date {
            display: flex;
            font-size: 14px;
            padding-top: 25px;
            justify-content: flex-end;
        }

        .user-details {
            font-size: 14px;
            padding-top: 20px;
        }

        .name {
            font-weight: bold;
        }

        .address {
            font-weight: bold;
        }

        .address span {
            font-size: 14px !important
        }

        .pay-details {
            font-size: 14px;
            line-height: 20px;
        }

        table {
            border-collapse: collapse;
        }

        td {
            border: 2px solid black;
            padding: 15px;
        }

        .revised-details {
            padding-top: 20px;
            font-size: 14px;
        }

        .salary-details {
            font-size: 14px;
            padding-top: 18px;
            display: flex;
            justify-content: space-between;
        }

        .paddingTop {
            padding-top: 20px;
        }

        .content-font-size {
            font-size: 14px;
            line-height: 20px;
        }

        .salary-text {
            margin-left: 160px;
        }

        .salary-number {
            align-self: center;
        }

        .salary-number-1 {
            margin-left: 178px;
        }

        .salary-number-2 {
            margin-left: 154.5px;
        }

        .salary-number-3 {
            margin-left: 110px;
        }

        .salary-number-4 {
            margin-left: 153px;
        }

        .salary-number-5 {
            margin-left: 37px;
        }

        .salary-number-6 {
            margin-left: 68px;
        }

        .table-content {
            text-align: center;
        }

        .signature {
            font-weight: bold;
            font-size: 14px;
        }

        .signature-text {
            display: flex;
            justify-content: space-between;
        }

        .page {
            page-break-before: always;
        }
        .spacing-from-top{
            padding-top: 20px;
        }
    </style>
</head>


<body>
    <div class="body-container">
        <div class="page">
            <div class="page-body">
                <div class="confidential-text">Confidential</div>
                <br>
                <div class="signature-text">
                    <span><b>To,</b></span>
                    <span style="display: block; float: right;"> Date: <b>{{$data['commencementDate']}}</b> </span>
                </div>
                <div class="user-details">
                    <div style="margin-bottom: 5px"><b>User's Name,</b></div>
                    <div style="margin-bottom: 5px"><b>User's Address,</b></div>
                </div>
                <div>Dear <b>FirstName,</b></div>
                <br>
                <div>
                    The management of Coloredcow Consulting Private Limited (hereinafter referred to as the "Company") takes pleasure in appointing you as a <b>"Software Developer"</b> based at the Gurugram Office of the Company on a salary package of <b>4.24 L</b> Lakhs per annum.
                </div>
                <div class="revised-details">
                    Your revised remuneration will be <b>INR 35,138/-</b> per month as per the following breakup.
                    <br>
                    <div class="salary-details">
                        <span class="salary-text">Basic Salary</span><span class="salary-number-1">Rs 16,500/-</span>
                    </div>
                    <div class="salary-details">
                        <span class="salary-text">HRA. Allowance</span><span class="salary-number-2">Rs 8350/-</span>
                    </div>
                    <div class="salary-details">
                        <span class="salary-text">Conveyance Allowance</span><span class="salary-number-3">Rs 1600/-</span>
                    </div>
                    <div class="salary-details">
                        <span class="salary-text">Other Allowance</span><span class="salary-number-4">Rs 6350/-</span>
                    </div>
                    <div class="salary-details">
                        <span class="salary-text">P.F. and Charges (Employer share)</span><span class="salary-number-5">Rs 2138/-</span>
                    </div>
                    <div class="salary-details">
                        <span class="salary-text">Medical Insurance (per month)</span><span class="salary-number-6">Rs 250/-</span>
                    </div>
                </div>
                <br>
                <div>
                    <b>
                        ***Medical insurance of 5 Lakhs, rupees are added to your CTC.
                    </b>
                    <br>
                    <b>
                        ***TDS on the above will be deducted as per the income tax rules.
                    </b>
                </div>
                <br>
                <div>
                    In this regard, you are requested to send a signed copy of the attached Appointment Letter as an acceptance.
                </div>
                <br>
                <div class="signature" style="position: relative;">
                    Yours Sincerely,
                    <br>
                    <div class="signature-text">
                        <span style="display: inline-block; margin-right: 400px;">For Coloredcow Consulting Pvt. Ltd.<br><br><br></span>
                        <div>
                            <div style="position: absolute; top: 10px; left: 120px;">
                                <img src="data:image/png;base64" height="110" width="180">
                            </div>
                            Mohit Sharma,<br>
                            HR, Admin
                        </div>
                    </div>
                    <div class="body-container" style="text-align: center">
                        <br><br><br>
                        <b>
                            ***This is an electronically generated document, hence does not require a signature and stamp
                        </b>
                    </div>
                </div>
            </div>
        </div>
        <div class="page">
            <div class="page-body">
                <div class="confidential-text">Employment Agreement</div> <br>
                <div>This Employment Agreement is executed at Gurugram on <b>hardcoded value</b> between </div>
                <div>
                    <p>1. <b>Coloredcow Consulting Private Limited</b>, a company incorporated under the laws of India and having its registered office at F-61, Suncity, Sector 54, Gurugram, Haryana-122003, India <b>("Company")</b>; and </p>
                    <p>2. <b>Hardcoded</b> is an Indian national, aged <b>Hardcoded</b> years, holding Permanent Account Number(PAN) <b>Hardcoded</b>, and presently residing at <b>Hardcoded</b>
                    <p>Each of the Company and the Employee is individually referred to as the <b>Party</b> and collectively as the <b>Parties</b>. </p>
                    <p><b>WHEREAS</b></p>
                    <p>1. The Employee is appointed by the Company through a letter of appointment dated <b>hardcoded</b></p>
                    <p>2. The Company wishes to define and set forth the terms and conditions of employment of the Employee with the Company.</p>
                    <p>In consideration of the mutual covenants and agreements set forth in this Agreement, and for other good and valuable consideration, the sufficiency of which is acknowledged by the Parties, the Parties hereby agree as follows:</p>
                    <p><b>1. DEFINITIONS AND INTERPRETATION</b></p>
                    <p>1.1. <b>Definitions</b></p>
                    <p>In this Agreement (including the Schedules hereto), except where the context otherwise requires, the following words and expressions shall mean the following:
                        <b>"Agreement"</b> shall mean this Employment Agreement together with all its schedules as may be attached hereto, and all agreements between the Parties supplemental to or an amendment or confirmation of this Employment Agreement, made in accordance with this Employment Agreement;</p>
                    <p>
                        <b>"Company Business"</b> shall mean the business being carried on by the Company, or that may be carried on, by the Company, including but not limited to the business of and such other activities carried out by the Company from time to time;
                    </p>
                    <p><b>"Company Policies"</b> shall mean the rules, regulations policies, compliance manuals, and procedures adopted by the Company in relation to its employees and/or the conduct of Company Business, which may be modified or substituted from time to time, and communicated to the employees of the Company;</p>
                    <p><b>"Confidential Information"</b> shall include all trade or business secrets, technical knowledge or know-how, financial information, plans, customer lists, pricing policies and procedures, marketing data, product data, any formula pattern or compilation of information used in Company Business, or any company of its group or any customers thereof or their affairs or any other information concerning the business, affairs or property of the Company or any company of its group, or any clients or customers thereof or their affairs or any other information in respect of which the Company owes an obligation of maintaining confidentiality to any third party</p>
                    <p><b>"Effective Date"</b> shall have the meaning assigned to the term in Clause2.1; </p>
                    <p><b>"Intellectual Property Rights"</b> means all forms of intellectual property or legal rights (whether registered/filed/perfected or not and including all applications/renewals for the same) and shall include any legally protectable product or process of the human intellect whether or not registrable or  registrable as trademarks, trade names, copyrights, patents, trade secrets, designs, service marks, internet addresses, domain names, know-how, moral rights, rights in data and databases, systems, trade secrets, and all rights or forms of protection of a similar nature including all computer software (including source and object code), firmware, development tools, algorithms, files, records, technical drawings and related documents, data, and manuals, databases and data collections  or rights, having an equivalent or similar effect to any of these which may subsist anywhere in the world, in whatever form or medium (copies and tangible embodiments); and </p>
                    <p><b>"Person"</b> shall mean an individual, corporation, partnership, limited liability company, association, trust, or other entity or organization, including a government or political subdivision or an agency or instrumentality thereof. </p>
                </div>
            </div>
        </div>
        <div class="page">
            <div class="page-body">
                <div class="spacing-from-top">
                    <p>1.2. <b>Interpretation</b></p>
                    <p>In this Agreement, unless the context otherwise requires:</p>
                    <p>a. The use of the singular shall include the plural and vice versa;</p>
                    <p>b. References to an individual shall include his/her legal representatives, successors, legal heirs, executors, and administrators;</p>
                    <p>c. Any reference to any law shall be deemed to include a reference to such law as is re-enacted, modified, or amended from time to time;</p>
                    <p>d. Any reference to any Clause or Schedule shall be deemed to be a clause, or schedule of or to, this Agreement; </p>
                    <p>e. The use of the word 'including' followed by a specific example in this Agreement shall not be construed as limiting the meaning of the general wording preceding it; and</p>
                    <p>f. The descriptive headings of clauses are inserted solely for convenience of reference only and shall not be used to interpret the provisions of this Agreement.</p>
                    <p>1.3. In the event of any conflict between the terms of this Agreement and any other document recording or purporting to record the terms of the Employee's employment or engagement by the Company, the terms of this Agreement shall prevail.</p>
                    <p><b>2. APPOINTMENT</b></p>
                    <p>2.1. Relying upon the representations made by the employee with regard to her/his educational background and work experience, the company is pleased to appoint the employee, and the employee agrees to serve the Company, in the capacity of <b>Hardcoded</b> with effect from <b>Hardcoded ("Effective Date").</b></p>
                    <p>2.2. The terms and conditions governing the employment of the Employee with the Company, which may be modified by the Company by issuing a separate written communication which shall be deemed to form part of this Agreement, to the Employee are set out in <b>Schedule I</b> of this Agreement.</p>
                    <p>2.3. The Employee warrants that, by entering this Agreement and performing her/his obligations hereunder, she/he will not be in breach of any terms or obligations under any subsisting agreement, written or oral, with any third party.</p>
                    <p><b>3. DUTIES, POWERS, AND SCOPE OF WORK</b></p>
                    <p>3.1. The scope of the work to be performed by the Employee during her/his term of employment with the Company is set - out in Schedule I hereof which shall be carried out by the Employee with utmost care and diligence and shall at all times be subject to the superintendence, direction, and control of the management of the Company. The Parties agree that the powers under this Clause shall be without prejudice to the powers of the Company to modify the same. The Company may also make such changes to the Employee's job title or position that it considers reasonable.</p>
                    <p>3.2. The Employee shall, at all times, promptly give to the Company and/or to any person to whom she/he operationally reports (in writing, if so requested) all such information, explanations, and assistance as may be required in connection with the Company Business and the due performance of her/his duties under this Agreement.</p>
                    <p>3.3. The Employee is expected to work with high standards of initiative, efficiency, and economy in a professional manner. The Employee shall perform, observe and confirm, faithfully and loyally and to the best of the Employee’s abilities, the duties assigned to the Employee hereunder and all directions and instructions given to her/his and the Company Policies, and shall devote all the Employee’s attention, knowledge, and experience and give her/his best efforts, skills and abilities to diligently and efficiently serve and promote the business and interests of the Company in a professional manner on a full-time basis and shall act honestly, reasonably and in the best interests of the Company. In discharging her/his duties and responsibilities, the Employee shall implement all management models and operating philosophies adopted by the Company. The Employee shall make best efforts to accomplish all business objectives and goals set for the Company.</p>
                </div>
            </div>
        </div>
        <div class="page">
            <div class="page-body">
                <div class="spacing-from-top">
                    <p>The Employee agrees to devote all of her/his time, attention, and abilities, exclusively to the Company Business and affairs of the Company and agrees that she/he will not during the term of her/his employment with the Company be engaged, concerned or interested, either directly or indirectly, in any trade or business or occupation (either for remuneration or otherwise) in any manner whatsoever. Nor shall the Employee undertake any activities which are contrary to or inconsistent with her/his duties and obligations to the Company or with the Company's interests. Further, the Employee undertakes not to (a) improperly bring to the Company or use any trade secrets, confidential information, or proprietary information of any third party; or (b) knowingly infringe the Intellectual Property of any third party.</p>
                    <p>3.4. The Employee confirms that she/he has disclosed fully to the Company all of her/his business interests, whether or not they are similar to or in conflict with the Company Business or activities of the Company, and all circumstances in respect of which there is, or there might be, a conflict of interest between the Company and the Employee or any immediate relatives of the Employee. The Employee further agrees to disclose fully to the Company any such interests or circumstances which may arise during her/his employment, immediately upon such interest or circumstances arising.</p>
                    <p>3.5. The Employee hereby agrees to report his own wrongdoing and any wrongdoing or proposed wrongdoing of any other employee or director of the Company or any affiliate immediately on becoming aware of it.</p>
                    <p><b>4. PLACE OF WORK</b></p>
                    <p>4.1. The Employee's principal place of work, as of the Effective Date, shall be at the Company's office in Gurugram, India. However, the Employee may be transferred to any other place in connection with the Company Business. The Company may also depute the Employee to any work or assign the Employee's services to any affiliate, associate company, branch, office, other companies, concerns, organizations, or firms with whom the Company may make any such arrangement or agreement, without any additional remuneration.</p>
                    <p>4.2. The Employee may be required to travel both inside and outside India in the performance of her/his duties from time to time and the expenses incurred for such travel and accommodation while on work will be paid by the Company if such expenses have been pre-authorized by the managing director of the Company.</p>
                    <p><b>5. REMUNERATION</b></p>
                    <p>5.1. In consideration of the services to the Company by the Employee as set forth herein, the Company shall pay the Employee the remuneration set forth in <b>Schedule II ("Salary")</b> which shall be subject to review in accordance with the Company's practice from time to time but there shall be no obligation on the Company to increase such Salary. In addition to the Salary, the Employee will be eligible to all the benefits such as leaves, bonus, provident fund, etc. as may be available under applicable law and provided for under the Company Policy. </p>
                    <p>5.2. The fixed portion of the Salary payable to the Employee shall be paid in arrears in 12 (twelve) equal monthly installments on the [last working day of each month] and into the Employee's bank account as specified to the Company, subject to all necessary statutory deductions under the law (as set out in Clause 14.7 below), and shall be deemed to accrue from day today.</p>
                    <p>5.3. The Company may deduct from (a) the Salary, and/or (b) any other sums owed to the Employee, any money owed to the Company by the Employee. The Company shall reimburse (or procure the reimbursement of) all reasonable expenses wholly, properly, and necessarily incurred by the Employee in the course of his employment, subject to the production of receipts or other appropriate evidence of payment, and such reimbursement will be subject to the Company Policies including in respect of the amounts up to which such reimbursement will be allowed and the manner of obtaining pre-authorizations for incurring such expenses.</p>
                </div>
            </div>
        </div>
        <div class="page">
            <div class="page-body">
                <div class="spacing-from-top">
                    <p><b>6. INTELLECTUAL PROPERTY</b></p>
                    <p>6.1. The Employee recognizes and unconditionally and irrevocably acknowledges and agrees that all rights, title, ownership, and interest in the Intellectual Property Rights created, developed, invented or generated by her/his  during the employment, either alone or with others, during the performance of her/his  services shall automatically vest in the Company and, in case, to the extent ownership of any such rights does not vest automatically in the Company under applicable law, the Employee shall provide written disclosure of the same to the Company and perform all acts, deeds, and things, including the execution of any documents that may be required by the Company to assign, transfer and convey such Intellectual Property Rights in the Company's name and provide assistance in legal proceedings that are necessary to establish or defend the ownership and/or rights of the Company in the Intellectual Property Rights in any country. The Employee hereby agrees that the assignment shall survive the termination or cancellation of this Agreement regardless of the method or manner in which it was terminated or canceled and shall be binding upon her/his /his heirs and legal representatives. In the event any document is not executed to effect such an assignment, it is expressly agreed by the Employee that this Agreement shall be construed as an assignment in writing in respect to any Intellectual Property Rights generated by the Employee during your employment. </p>
                    <p>6.2. All rights, title, and interest in Intellectual Property Rights, including the right to amend, alter, copy or commercially exploit the same, shall belong solely to, and be for the benefit of, the Company.</p>
                    <p><b>7. INFORMATION AND COMMUNICATION TECHNOLOGY</b></p>
                    <p>7.1. The Employee hereby undertakes to comply with the Company Policies on the use of telecommunication and information technology equipment, including without prejudice, telephones mail, internet access facilities, and computers.</p>
                    <p>7.2. Unauthorized access, use of, or tampering with computers or other information technology equipment, using unauthorized third party hardware or software to interact with the Company's information technology infrastructure, or assisting or permitting any such unauthorized action will be regarded as serious misconduct and may lead to summary dismissal.</p>
                    <p>7.3. The Company provides information technology infrastructure, including telephones (including mobile and voicemail), email and internet access for business purposes (collectively, the <b>"Infrastructure"</b>). The entire Infrastructure continues to belong to the Company. All communications which use the Infrastructure are subject to the Company Policies. The Employee hereby acknowledges that all communications of whatsoever nature made or received using the Infrastructure are not confidential and hereby consents to the Company's interception of such communications.</p>
                    <p>7.4. The Employee also acknowledges that for the purposes of a business (including and not limited to quality control, monitoring of policy compliance and unauthorized use, and checking messages during periods of absence), communications made by or to employees may be monitored or recorded with or without prior notice to the Employee. This applies, in particular, to telephone (including mobile and voicemail), email, and internet use.</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
