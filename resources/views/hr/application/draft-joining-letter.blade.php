<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Styles -->
        <style>
            html,
            .font-color{
                color: navy;
            }
            .img-center{
                text-align: center;
            }
            body {
                font-weight: normal;
                font-family: sans-serif;
            }
            .d-block {
                display: block;
            }
            .text-center {
                text-align: center;
            }
            .text-right{
                text-align: right;
            }
            .text-left {
                text-align: left;
            }
            .font-weight-bold {
                font-weight: bold;
            }
            .w-100p {
                width: 100%;
            }
            .w-68p {
                width: 68%;
            }
            .w-70p {
                width: 70%;
            }
            .w-75p {
                width: 75%;
            }
            .w-76p {
                width: 76%;
            }
            .w-80p {
                width: 80%;
            }
            .p-5 {
                padding: 5px;
            }
            .mt-10 {
                margin-top: 10px;
            }
            .ml-25 {
                margin-left: 25px;
            }
            .underline {
                text-decoration: underline;
            }
            .page {
                page-break-after: always;
                page-break-inside: avoid;
            }
            .table-border, .table-border th, .table-border td {
                border: 2px solid black;
                border-collapse: collapse;
            }
            .table-padding {
                padding-left: 15%; 
                padding-right: 7%;
            }
            .p-10{
                padding-left: 10%;
                padding-right:20%;
            }
            .fz-14 {
                font-size: 14px !important;
            }
            .box1{
                background-color: white;
                width: 335px;
                height: 300px;
                border: 2px solid black;
                float:left;
                margin-bottom: 50px;
                margin-left: 1px;

            }
            .box2{
                background-color: white;
                width: 335px;
                height: 300px;
                border: 2px solid black;
                float:right;
                margin-bottom:5px;
                margin-right: 1px;
            }
        </style>
    </head>
    <body>
        <div>
            <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
            <p>___________________________________________________________________________________________________</p>
            <div>
                <pre>To							Date:{{\Carbon\Carbon::now()->format('d-m-y')}}</pre>
                <p>{{$applicant->name}},</p>
                <p>(Employee Address)</p>
                <p>Dear {{$applicant->name}},</p>
                <p class="body">The management of Coloredcow Consulting Private Limited (here in after referred to as the “Company”) takes pleasure in appointing you as “{{$job->title}}” based at the Gurugram Office of the Company on the salary package for X.X Lakhs per annum.
                    Your monthly compensation will be Rs ___________/- ( INR XXXX Only)- per month as per the following breakup.</p>
                <pre class="table-padding font-weight-bold">Basic Salary			XXXX/-</pre>
                <pre class="table-padding font-weight-bold">House Rent Allowance            XXXX/-</pre>
                <pre class="table-padding font-weight-bold">Conveyance Allowance		XXXX/-</pre>
                <pre class="table-padding font-weight-bold">Other Allowance                 XXXX/-</pre>
                <pre class="table-padding font-weight-bold">P.F. and charges                XXXX/-</pre>
                <p>As a part of CTC, you are covered under Medical insurance of 5 lakhs.</p>
                <p>The joining of the regular office is subjected to the Covid-19 situation. As per the norms of Govt. of India, we will be working remotely until the situation gets better.</p>
                <p>In this regard, you are requested to send a signed copy of the attached Appointment Letter as an acceptance.</p>
                <p>Yours Sincerely,</p> 
                <p>For Coloredcow Consulting Pvt. Ltd.</p><br><br>
                <p>Mohit Sharma</p>
                <p>HR, Admin</p><br><br>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>
            <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
            <p>___________________________________________________________________________________________________</p>
            <div>
                <p class="text-center font-weight-bold">EMPLOYMENT AGREEMENT</p>
                <p class="p-5">This Employment Agreement is executed at Gurugram on this<span class="font-weight-bold"> Month YYYY </span>between:</p>
                <p class="p-10">1. Coloredcow Consulting Private Limited, a company incorporated under the laws of India and having its registered office at F-61, Suncity, Sector 54, Gurugram, Haryana-122003, India (“Company”); and </p>
                <p class="p-10">2. Employee Name an Indian national, aged XX years, holding Permanent Account Number(PAN)  XXXXXXX and presently residing at Employee Address</p>
                <p>Each of the Company and the Employee is individually referred to as the “Party” and collectively as the “Parties”. </p>
                <p class="font-weight-bold">WHEREAS</p>
                <p class="p-10">1. The Employee is appointed by the Company through a letter of appointment dated DDth Month YYYY.</p>
                <p class="p-10">2. The Company wishes to define and set forth the terms and conditions of employment of the Employee with the Company.</p>
                <p>In consideration of the mutual covenants and agreements set forth in this Agreement, and for other good and valuable consideration, the sufficiency of which is acknowledged by the Parties, the Parties hereby agree as follows:</p>
                <br>
                <p class="font-weight-bold">1. DEFINITIONS AND INTERPRETATION</p>
                <h5>1.1 Definitions</h5>
                <p>In this Agreement (including the Schedules hereto), except where the context otherwise requires, the following words and expressions shall mean the following:</p>
                <p>“Agreement” shall mean this Employment Agreement together with all its schedules as may be attached hereto, and all agreements between the Parties supplemental to or in amendment or confirmation of this Employment Agreement, made in accordance with this Employment Agreement;</p>
                <br><br>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <br>
                <p>“Company Business” shall mean the business being carried on by the Company, or that may be carried on, by the Company, including but not limited to the business of ……………………………………………………………………………………………………………………………………………………………….. and such other activities carried out by the Company from time to time;</p>
                <p>“Company Policies” shall mean the rules, regulations policies, compliance manuals and procedures adopted by the Company in relation to its employees and/or the conduct of Company Business, which may be modified or substituted from time to time, and communicated to the employees of the Company;</p>
                <p>“Confidential Information” shall include all trade or business secrets, technical knowledge or know-how, financial information, plans, customer lists, pricing policies and procedures, marketing data, product data, any formula pattern or compilation of information used in Company Business or any company of its group or any customers thereof or their affairs or any other information concerning the business, affairs or property of the Company or any company of its group, or any clients or customers thereof or their affairs or any other information in respect of which the Company owes an obligation of maintaining confidentiality to any third party</p>
                <br>
                <p>“Effective Date” shall have the meaning assigned to the term in Clause2.1;</p>
                <br>
                <p>“Intellectual Property Rights” means all forms of intellectual property or legal rights (whether registered/filed/perfected or not and including all applications/renewals for the same) and shall include any legally protectable product or process of the human intellect whether or not registrable or  registrable as trademarks, trade names, copyrights, patents, trade secrets, designs, service marks, internet addresses, domain names, know-how, moral rights, rights in data and databases, systems, trade secrets, and all rights or forms of protection of a similar nature including all computer software (including source and object code), firmware, development tools, algorithms, files, records, technical drawings and related documents, data and manuals, databases and data collections  or rights, having equivalent or similar effect to any of these which may subsist anywhere in the world, in whatever form or medium (copies and tangible embodiments); and </p>
                <p>“Person” shall mean an individual, corporation, partnership, limited liability company, association, trust or other entity or organization, including a government or political subdivision or an agency or instrumentality thereof.</p>
                <br><br>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <p class="font-weight-bold">1.2 Interpretation</p>
                <p>In this Agreement, unless the context otherwise requires:</p>
                <p class="p-10">a. The use of the singular shall include the plural and vice versa;</p>
                <p class="p-10">b. References to an individual shall include his/her legal representatives, successors, legal heirs, executors, and administrators;</p>
                <p class="p-10">c. Any reference to any law shall be deemed to include a reference to such law as is re-enacted, modified or amended from time to time;</p>
                <p class="p-10">d. Any reference to any Clause or Schedule shall be deemed to be a clause, or schedule of or to, this Agreement; </p>
                <p class="p-10">e. The use of the word ‘including’ followed by a specific example in this Agreement shall not be construed as limiting the meaning of the general wording preceding it; and</p>
                <p class="p-10">f. The descriptive headings of clauses are inserted solely for convenience of reference only and shall not be used to interpret the provisions of this Agreement</p>
                <p>1.3     In the event of any conflict between the terms of this Agreement and any other document recording or purporting to record the terms of the Employee’s employment or engagement by the Company, the terms of this Agreement shall prevail.</p>
                <p class="font-weight-bold">2. APPOINTMENT</p>
                <p>2.1 Relying upon the representations made by the employee with regard to her/his educational background and work experience, the company is pleased to appoint the employee, and the employee agrees to serve the Company, in the capacity of Designation with effect from DDth Month YYYY (“Effective Date”).</p>
                <p>2.2 The terms and conditions governing the employment of the Employee with the Company, which may be modified by the Company by issuing a separate written communication which shall deem to form part of this Agreement, to the Employee is set-out in Schedule I of this Agreement.</p>
                <p>2.3 The Employee warrants that, by entering this Agreement and performing her/his obligations hereunder, she/he will not be in breach of any terms or obligations under any subsisting agreement, written or oral, with any third party.</p>
                <br><br>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>  
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <br>
                <p>2.4   It is clearly understood and agreed that you are appointed on probation for a period of 6 months and the probationary period may be extended at the discretion of the management.  It is further understood and agreed that, unless your appointment is confirmed in writing, you will have deemed to be on probation and that only upon satisfactory completion of the probation/extended probation period, as the case may be, will your appointment be confirmed.</p>
                <br>
                <p class="font-weight-bold">3. DUTIES, POWERS, AND SCOPE OF WORK</p>
                <br>
                <p>3.1 The scope of the work to be performed by the Employee during her/his  term of employment with the Company is set – out in Schedule I hereof which shall be carried out by the Employee with utmost care and diligence and shall at all times be subject to the superintendence, direction, and control of the management of the Company. The Parties agree that the powers under this Clause shall be without prejudice to the powers of the Company to modify the same. The Company may also make such changes to the Employee’s job title or position that it considers reasonable.</p>
                <p>3.2 The Employee shall, at all times, promptly give to the Company and/or to any Person to whom she/he operationally reports (in writing, if so requested) all such information, explanations and assistance as may be required in connection with the Company Business and due performance of her/his  duties under this Agreement.</p>
                <p>3.3 The Employee is expected to work with high standards of initiative, efficiency, and economy in a professional manner. The Employee shall perform, observe and confirm, faithfully and loyally and to the best of the Employee’s abilities, the duties assigned to the Employee hereunder and all directions and instructions given to her/his  and the Company Policies, and shall devote all the Employee’s attention, knowledge and experience and give her/his  best efforts, skills and abilities to diligently and efficiently serve and promote the business and interests of the Company in a professional manner on a full-time basis and shall act honestly, reasonably and in the best interests of the Company. In discharging her/his duties and responsibilities, the Employee shall implement all management models, and operating philosophies adopted by the Company. The Employee shall make best efforts to accomplish all business objectives and goals set for the Company.</p>
                <br><br><br><br>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>           
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <p>The Employee agrees to devote all of her/his  time, attention and abilities, exclusively to the Company Business and affairs of the Company and agrees that she/he will not during the term of her/his employment with the Company be engaged, concerned or interested, either directly or indirectly, in any trade or business or occupation (either for remuneration or otherwise) in any manner whatsoever. Nor shall the Employee undertake any activities which are contrary to or inconsistent with her/his duties and obligations to the Company or with the Company’s interests. Further, the Employee undertakes not to (a) improperly bring to the Company or use any trade secrets, confidential information or proprietary information of any third party; or (b) knowingly infringe the Intellectual Property of any third party.</p>
                <p>3.4 The Employee confirms that she/he has disclosed fully to the Company all of her/his  business interests, whether or not they are similar to or in conflict with the Company Business or activities of the Company, and all circumstances in respect of which there is, or there might be, a conflict of interest between the Company and the Employee or any immediate relatives of the Employee. The Employee further agrees to disclose fully to the Company any such interests or circumstances which may arise during her/his employment, immediately upon such interest or circumstances arising.</p>
                <p>3.5 The Employee hereby agrees to report his own wrongdoing and any wrongdoing or proposed wrongdoing of any other employee or director of the Company or any affiliate immediately on becoming aware of it.</p>  
                <br>
                <p class="font-weight-bold">4 PLACE OF WORK</p>
                <br>
                <p>4.1 The Employee’s principal place of work, as at the Effective Date, shall be at the Company’s office at Gurugram, India. However, the Employee may be transferred to any other place in connection with the Company Business. The Company may also depute the Employee to any work or assign the Employee’s services to any affiliate, associate company, branch, office, other companies, concerns, organizations, or firms with whom the Company may make any such arrangement or agreement, without any additional remuneration.</p>
                <p>4.2 The Employee may be required to travel both inside and outside India in the performance of her/his duties from time to time and the expenses incurred for such travel and accommodation while on work will be paid by the Company if such expenses have been pre-authorised by the managing director of the Company. </p>
                <br><br><br>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <br>
                <p class="font-weight-bold">5 REMUNERATION</p>
                <p>5.1 In consideration of the services to the Company by the Employee as set forth herein, the Company shall pay the Employee the remuneration set forth in Schedule II (“Salary”) which shall be subject to review in accordance with the Company’s practice from time to time but there shall be no obligation on the Company to increase such Salary. In addition to the Salary, the Employee will be eligible to all the benefits such as leaves, bonus, provident fund, etc. as may be available under applicable law and provided for under the Company Policy. </p>
                <p>5.2 The fixed portion of the Salary payable to the Employee shall be paid in arrears in 12 (twelve) equal monthly instalments on the [last working day of each month] and into the Employee’s bank account as specified to the Company, subject to all necessary statutory deductions under law (as set out in Clause 14.7 below), and shall be deemed to accrue from day to day.</p>
                <p>5.3 The Company may deduct from (a) the Salary, and/or (b) any other sums owed to the Employee, any money owed to the Company by the Employee. The Company shall reimburse (or procure the reimbursement of) all reasonable expenses wholly, properly and necessarily incurred by the Employee in the course of his employment, subject to production of receipts or other appropriate evidence of payment and such reimbursement will be subject to the Company Policies including in respect of the amounts up to which such reimbursement will be allowed and the manner of obtaining pre-authorizations for incurring such expenses.</p>
                <br>
                <p class="font-weight-bold">6 INTELLECTUAL PROPERTY</p>
                <br>
                <p>6.1 The Employee recognizes and unconditionally and irrevocably acknowledges and agrees that all rights, title, ownership, and interest in the Intellectual Property Rights created, developed, invented or generated by her/his  during the employment, either alone or with others, during the performance of her/his  services shall automatically vest in the Company and, in case, to the extent ownership of any such rights does not vest automatically in the Company under applicable law, the Employee shall provide a written disclosure of the same to the Company and perform all acts, deeds and things, including execution of any documents that may be required by the Company to assign, transfer and convey such </p>
                <br><br><br>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <br>
                <p>Intellectual Property Rights in the Company's name and provide assistance in legal proceedings that are necessary to establish or defend the ownership and/or rights of the Company in the Intellectual Property Rights in any country. The Employee hereby agrees that the assignment shall survive the termination or cancellation of this Agreement regardless of the method or manner in which it was terminated or canceled and shall be binding upon her/his /his heirs and legal representatives. In the event any document is not executed to effect such an assignment, it is expressly agreed by the Employee that this Agreement shall be construed as an assignment in writing in respect to any Intellectual Property Rights generated by the Employee during your employment</p>
                <p>6.2 All rights, title, and interest in Intellectual Property Rights, including the right to amend, alter, copy or commercially exploit the same, shall belong solely to, and be for the benefit of, the Company</p>
                <br>
                <p class="font-weight-bold">7. INFORMATION AND COMMUNICATION TECHNOLOGY</p>
                <br>
                <p>7.1 The Employee hereby undertakes to comply with the Company Policies on the use of telecommunication and information technology equipment, including without prejudice, telephones mail, internet access facilities, and computers.</p>
                <p>7.2 Unauthorized access, use of, or tampering with computers or other information technology equipment, using unauthorized third party hardware or software to interact with the Company’s information technology infrastructure, or assisting or permitting any such unauthorized action will be regarded as serious misconduct and may lead to summary dismissal.</p>
                <p>7.3 The Company provides information technology infrastructure, including telephones (including mobile and voicemail), email and internet access for business purposes (collectively, the “Infrastructure”). The entire Infrastructure continues to belong to the Company. All communications which use the Infrastructure are subject to the Company Policies. The Employee hereby acknowledges that all communications of whatsoever nature made or received using the Infrastructure are not confidential and hereby consents to the Company’s interception of such communications.</p>
                <br><br><br><br><br>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <p>7.4 The Employee also acknowledges that for the purposes of business (including and not limited to quality control, monitoring of policy compliance and unauthorized use and checking messages during periods of absence), communications made by or to employees may be monitored or recorded with or without prior notice to the Employee. This applies, in particular, to telephone (including mobile and voicemail), email and internet use.</p>
                <br>
                <p class="font-weight-bold">8. CONFIDENTIALITY</p>
                <br>
                <p>8.1 As Confidential Information, will, from time to time, become known to the Employee, the Company considers and the Employee agrees that the restraints set forth in this Agreement (on which the Employee have had the opportunity to take independent legal advice) are necessary for the reasonable protection by the Company of Company any Business</p>
                <p>8.2 The Employee shall not at any time, either during the continuance of or after the termination of  employment with the Company, use, disclose or communicate to any person whatsoever any Confidential Information which the Employee have or which the Employee may have possessed during employment with the Company nor shall the Employee supply the names or addresses of any customers, vendors or agents of the Company or any company of its group, to any person except as authorised by the Company or as ordered by a Court of competent jurisdiction, provided however, that the restrictions herein shall not apply to any portion of Confidential Information that (i) is already in the public domain through no fault of your and without breach of this Agreement by the Employee; or (ii) was lawfully in the</p>
                <p>possession of the Employee prior to the execution of this Agreement and without receipt from the Company or its agents; or (iii) is required to be disclosed under applicable laws; or (iv) in the proper course of your employment with the Company.</p>
                <p>8.3 The Employee agrees that she/he will not at any time during the continuance of your employment with the Company or on expiry or on termination/cessation of employment with the Company or thereafter, issue any statements to the press (whether oral or written) which have not directly been authorized by the Company. Such restriction shall apply to any statement to any representative of television, radio, film or other similar media and to the writing of any article for the press or otherwise for publication on any matter connected with or relating to the business of the Company or its group.</p>
                <br><br><br>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>


            </div>
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <p>8.4 All Confidential Information shall, at all times, be solely and absolutely vested in and owned by the Company, and the Employee shall not have or claim any right, title or interest therein</p>
                <p>8.5 The obligations under this Clause 8 and Clause 9 below shall survive the termination or expiration of this Agreement</p>
                <br>
                <p class="font-weight-bold">9 NON COMPETE AND NON-SOLICITATION</p>
                <br>
                <p>9.1 During the term of this Agreement and for a period of 1 (one) year thereafter, the Employee covenants that she/he shall not, directly or indirectly, in any capacity, own, manage, operate, control, enable (whether by license, sublicense, assignment or otherwise) or otherwise be interested, engage, assist or participate (whether solely or with others) in the business or business similar to that of the Company in the geographical areas that the Company is operating or considering operation as on at the date of cessation of employment of the Employee with the Company.</p>
                <p>9.2 The Employee undertakes and warrants that she/he shall not, during the period of her/his  employment with the Company and for the a period of 1 (One year after ceasing to be employed with the Company under this Agreement, without the prior written consent of the Company, acting in any capacity, directly or indirectly, entice or solicit, or endeavour to entice or solicit away from the Company or assist any other person, whether by means of supply of names or expressing views on suitability, or by any other means whatsoever, to solicit or entice away from the Company, any person who (i) has at any time during the 12 month period immediately before the date on which the Employee ceased to be employed, (ii) Solicit or knowingly entice, encourage or induce any person who is a client, Supplier or a customer of the company to deal with the employee or his affiliates with respect to company business or to deal with any competitor of the company, or (iii) interfere with, disrupt or attempt to disrupt, any relationship between company and any of the client, customers or suppliers of the company, including soliciting or encouraging any such client customer or supplier to discontinue or reduce its business with the company.</p>
                <p>9.3 The restriction contained above, on which the Employee has had the opportunity to take independent legal advice, is considered reasonable by the Parties, and necessary for the protection of the legitimate interests and Confidential Information of the Company</p>
                <p>9.4 The Parties recognize that the Salary paid to the Employee shall form adequate consideration for the Employee’s compliance with the obligations contained in Clauses 9 and 10 herein.</p>
                <br><br>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <br>
                <p class="font-weight-bold" >10. COMPANY POLICIES; DISCIPLINARY AND GRIEVANCE PROCEDURES</p>
                <p>10.1 The Employee must, in addition to the terms and conditions specifically stated herein, comply at all times with the Company Policies which may be changed, replaced or withdrawn at any time at the discretion of the Company. Breach of the Company Policies may result in disciplinary action, including the right to terminate this Agreement.</p>
                <p class="font-weight-bold">11 TERM AND TERMINATION</p>
                <p>11.1 The term of this Agreement shall be for a period commencing from the Effective Date until terminated in accordance with the provisions of this Clause</p>
                <p>11.2This Agreement and the Employee’s employment with the Company hereunder may be terminated immediately by the Company giving written notice if:</p>
                <p class="p-10">a) the Employee has committed a material breach or non-observance of terms of her/his  employment with the Company under this Agreement, or refuses or neglects to comply with any reasonable and lawful directions of the Company, or,is, in the reasonable opinion of the Company, negligent and incompetent in the performance of her/his  duties; or</p>
                <p class="p-10">b)is guilty of any fraud or dishonesty or acts in any manner which in the opinion of the Company brings or is likely to bring the Employee or the Company into disrepute or is adverse to the interests of the Company; or</p>
                <p class="p-10">c)the employee has submitted false and/or forged documents of qualifications, experience certificates, etc., made false representation and/or suppressed any material or relevant information required to be disclosed by her/his.</p>
                <p>11.3 In the event of termination pursuant to Clause 11.2 above, the Employee shall not be entitled to pay in lieu of notice or any other payment except for such sums as shall have actually accrued up to and including the date of such termination. The Company shall be entitled to deduct from such remuneration any sums owing to it from the Employee to which deduction the Employee expressly hereby consents and authorizes.</p>
                <p>11.4 Notwithstanding the aforesaid, the Company may terminate this Agreement by serving a notice giving 15 days notice or Salary in lieu of such notice, and the Employee may terminate this Agreement by giving 15 days notice or Salary in lieu of such notice.</p>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div> 
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <p class="font-weight-bold">12 RETURN OF PROPERTY ON TERMINATION</p>
                <p>Upon the termination or expiry or cessation of the Employee’s employment with the Company for whatsoever cause, the Employee shall immediately deliver up / surrender to the Company or its authorized representative any and all property or documents (including but not limited to Confidential Information) of the Company or any affiliate(s) which may have been acquired by her/his , or be in her/his  possession, custody or under her/his  control, in connection with the Company Business , and all other Confidential Information  (pertaining to the Company, any affiliate(s) or the Company Business) whether or not the property was originally supplied to her/his  by the Company and which may be in possession or control and relates in any way to the business and affairs of the Company</p>
                <p>12.1 Without prejudice to any other right available under applicable law, the Company reserves the right to make reasonable deductions from the Employee’s final Salary payment or any other amount due to her/his or claim losses suffered by it, should she/he fail to return all the Company property in her/his  possession, or return it in a damaged state, other than due to normal wear and tear. </p>
                <p class="font-weight-bold">13.1 REPRESENTATION AND COVENANTS</p>
                <p>13.1 The Employee represents, warrants and covenants to the Company, which shall true on each date until termination of this Agreement that:</p>
                <p class="p-10">a)the execution, delivery, and performance of this Agreement by her/his  does not and will not conflict with, breach, violate or cause a default under any contract, agreement, instrument, order, judgment or decree to which the Employee is a party or by which the Employee is bound; </p>
                <p class="p-10">b)She/He is not a party to or bound by any employment agreement, non-competition agreement or confidentiality agreement with any person other than the Company; and</p>  
                <p class="p-10">c)after the execution and delivery of this Agreement by the Company and the Employee, this Agreement shall be the valid and binding obligation of the Employee, enforceable in accordance with its terms.</p>
                <p class="p-10">d)She/He holds the desired educational background and work experience to fulfill the scope of work </p>
                <br><br><br>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>  
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <p>e) the Employee has not and shall not borrow or accept or give any money, gift, reward or compensation for her/his personal gains from or otherwise place her/his self under any pecuniary obligation to any Person or client with whom the Employee may be having official dealings. The Employee shall also not under any circumstances engage in any act that involves or even gives the impression of involving bribery or any illegal activity whatsoever.</p>
                <p>f) She/He is medically fit and shall provide the Company with a medical fitness certificate, certifying that the Employee is physically fit.</p>
                <br>
                <p class="font-weight-bold">14 MISCELLANEOUS</p>
                <br>
                <h4>14.1 Governing law and Jurisdiction</h4>
                <p>This Agreement shall be governed by and construed in accordance with the laws of India, without giving effect to its internal principles of conflict of law. The Parties irrevocably submit to the non-exclusive jurisdiction of the Courts at Haryana, India.</p>
                <p class="font-weight-bold">14.2 Notices</p>
                <p class="p-10">a)Any notice and other communication provided for in this Agreement to be given to a Party (“Receiving Party”) shall be in writing in the English language and shall be delivered by hand or by recognized courier service or registered mail to the address of the Receiving Party at the beginning of this Agreement or as otherwise notified in writing to the other Party.</p>
                <p class="p-10">b)All such notices, requests and other communications will (i) if delivered personally, be deemed given upon delivery; (ii) if delivered by courier or registered mail, at 9.00 am on the second day after posting or at the time recorded by the delivery service.</p>
                <p class="font-weight-bold">14.3 Amendments</p>
                <p>No change, modification, or termination of any of the terms, provisions, or conditions of this Agreement shall be effective unless made in writing and signed or initialled by all Parties to this Agreement.</p>
                <br><br>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <br>
                <p class="font-weight-bold">14.4 Independent obligations and Severability</p>
                <p>a)Each undertaking/covenant contained in the Agreement shall be read and construed independently so that if one or more should be held to be invalid for any reason whatsoever, then the remaining undertakings/covenants shall be valid and continue to be in force. The Parties also agree that the aforesaid conditions are reasonable.</p>
                <p>b)If any term or provision of this Agreement shall be held to be invalid, illegal, or unenforceable in whole or in part, the validity, legality, and enforceability of the remaining provisions of this Agreement shall not in any way be affected or impaired thereby. In the event the deletion or modification of such terms affects the essence of the subject matter of this Agreement, the Parties shall enter into good faith negotiations to provide an acceptable replacement provision for the deleted provision.</p>
                <br>
                <p class="font-weight-bold">14.5 Waiver</p>
                <br>
                <p> No waiver by a Party of any default, misrepresentation or breach of a warranty or covenant hereunder, whether intentional or not, shall be deemed to extend to any prior or subsequent default, misrepresentation or breach of a warranty or covenant hereunder or affect in any way any rights arising by virtue of any prior or subsequent occurrence. No failure or delay by a Party hereto in exercising any right, power or privilege hereunder shall operate as a waiver thereof, nor shall any single or partial exercise thereof preclude any other or further exercise thereof or the exercise of any other right, power or privilege. The rights and remedies her/his ein provided shall be cumulative and not exclusive of any rights or remedies provided under the law.</p>
                <p class="font-weight-bold">14.6 Borrowing / Accepting / Giving Gifts</p>
                <p> The Employee shall not borrow or accept or give any money, gift, reward or compensation for her/his personal gains from or otherwise place her/his self under any pecuniary obligation to any Person or client with whom the Employee may be having official dealings. The Employee shall also not under any circumstances engage in any act that involves or even gives the impression of involving bribery or any illegal activity whatsoever.</p>
                <br><br>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <br>
                <p class="font-weight-bold">14.7 Taxes and Statutory deductions</p>
                <br>
                <p> All amounts payable by the Company to the Employee under this Agreement, including the Salary, allowances, and benefits, shall be subject to such withholding tax or tax deduction at source, any other taxes, other statutory deductions if any, and social security contributions as may be required under the law. In case the Company is required to deduct tax at source, such tax shall be recovered from the Employee. Any tax liability, other than withholding taxes, arising in respect of payments made pursuant to this Agreement or income earned by the Employee while this Agreement is in effect shall be borne solely by the Employee.</p>
                <p class="font-weight-bold">14.8 Misrepresentation</p>
                <br>
                <p> After the termination of the Employment, for any reason whatsoever, the Employee shall not for any reason represent her/his self as still connected with the Company or as still authorized to conduct business on behalf of the.</p>
                <br>
                <p class="font-weight-bold">14.9 Indemnity</p>
                <p>The Employee hereby agrees to indemnify and continue to indemnify the Company, its offices and its directors, (each an “Indemnified Party”) against all claims, penalties, losses, damages, liabilities, costs or expenses (including, without limitation, reasonable attorneys’ fees and other dispute resolution costs) (“Losses”) arising directly or indirectly:</p>
                <p>a) as a result of any misrepresentation made by her/his  under the terms herein; or</p>
                <p>b) as a result of a breach of obligations under this Agreement by her/his; or </p>
                <p>c) as a result of any unauthorized act outside the normal course of duties, by her/his; or</p>
                <p>d) as a result of fraud, gross negligence, wilful misconduct or a wilful breach by her/his  of applicable law; or</p>
                <p>e) as a result of a breach of obligations with any third party by entering into this Agreement</p>
                <br><br><br><br><br>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <p class="font-weight-bold">14.10 Entire Agreement</p>
                <p>This Agreement shall constitute the entire agreement and understanding between the Parties and shall substitute all the previous agreements and arrangements (whether written or verbal, express or implied) in connection with the employment of the Employee with the Company. Any previous agreements or arrangements shall be deemed to have been terminated by mutual consent as from the Effective Date without notice and without any payment in lieu of notice. There are no collective agreements affecting the terms and conditions of employment of the Employee</p>
                <p class="font-weight-bold">14.11 Assignment </p>
                <p>This Agreement shall be binding upon and inure to the benefit of the Company and its successors and assigns. Company may assign its rights under this Agreement to any person or entity that acquires any or all of the assets of the Company. Subject to provisions of this Agreement, due to the personal nature of this Agreement, the Employee shall not have the right to assign her/his rights or obligations under this Agreement</p>
                <p class="font-weight-bold">14.12 Survival</p>
                <p> Notwithstanding anything to the contrary set out her/his ein, the following Clauses of this Agreement shall survive its expiry or earlier termination: Clause 6 (Intellectual Property); Clause 8 (Confidentiality); Clause 9 (Non Compete and Non Solicitation); Clause 12 (Return of Property on Termination); Clause 14.1 (Governing Law and Jurisdiction); Clause 14.2 (Notices); Clause 14.9 (Indemnification) and any other provisions which are intended, by their nature to survive the termination of this Agreement.</p>
                <p class="font-weight-bold">14.13 Counterparts</p>
                <p>This Agreement may be executed by the Parties in separate counterparts each of which when so executed and delivered shall be an original, but all such counterparts shall together constitute one and the same instrument.</p>
                <p class="font-weight-bold">14.14 Expenses</p>
                <p> Except as expressly set out in this Agreement, each of the Parties shall pay its own legal and other costs and expenses incurred in connection with the preparation, negotiation, and implementation of this Agreement.</p>
                <br><br><br>
                <p>[signature page to follow]</p>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <p>IN WITNESS WHEREOF, this Agreement has been entered into the day and year first above written.</p>
                <p>___________________________________________________________________________________________________</p>
                <br><br><br><br>
                <div>
                <div class="box1">
                    <div>  For Coloredcow Consulting Private Limited</div>
                    <br><br><br><br><br><br><br><br>
                    <div> ____________________________</div>
                    <div> Name: Mr. Mohit Sharma</div>
                    <div> (HR, Admin)</div>
                </div>
                <div class="box2">
                    <div>  (Employee Name) </div>
                    <br><br><br><br><br><br><br><br>
                    </b>
                    <div>______________________</div>    
                </div>
                </div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <p class="font-color mt-6">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>
            <div>
                <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
                <p>___________________________________________________________________________________________________</p>
                <p class="font-weight-bold">Schedule I</p>
                <p>All terms and conditions mentioned in this agreement</p>
                <p class="font-weight-bold">Schedule II</p>
                <p class="font-weight-bold">Remuneration</p>
                <p>Your monthly compensation will be INR XXXX/-  per month as per the following breakup.</p>
                <pre class="table-padding font-weight-bold">Basic Salary			XXXX/-</pre>
                <pre class="table-padding font-weight-bold">House Rent Allowance            XXXX/-</pre>
                <pre class="table-padding font-weight-bold">Conveyance Allowance		XXXX/-</pre>
                <pre class="table-padding font-weight-bold">Other Allowance                 XXXX/-</pre>
                <pre class="table-padding font-weight-bold">P.F. and charges                XXXX/-</pre>
                <p>*Conveyance Allowance is 1600/- which is fixed but you need to submit Conveyance Logs to claim more than this….</p>
                <p>* As a part of CTC, you are covered under Medical insurance of 5 lakhs.</p>
                <p>* As a part of CTC, you are covered under Medical insurance of 5 lakhs.</p>
                <br><br><br><br>
                <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
                <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a href="https://coloredcow.com">https://coloredcow.com</a></p>
            </div>
        </div>
    </body>
</html>     