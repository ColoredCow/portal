<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Styles -->
    <style>
        html,
        .font-color {
            color: navy;
        }

        .line-height {
            line-height: 2rem;
        }

        < !DOCTYPE html><html><head><style>body {
            font-family: 'proxima-nova', sans-serif;
        }

        .img-center {
            text-align: center;
        }

        .text-justify {
            text-align: justify
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: 700;
        }

        .font-color {
            color: #000000;
            /* Specify the desired font color */
        }

        .paragraph-margin {
            margin-left: 40px;
            /* Adjust the margin value as per your preference */
        }

        .subpoints-margin {
            margin-left: 75px;
            /* Adjust the margin value as per your preference */
        }
    </style>
</head>

<body>
    <div>
        <div class="img-center">
            <img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="left" height="50"
                width="250">
        </div>
        @dd($name)
        <p>___________________________________________________________________________________________________</p>
        <div>
            <div>
                <p class="text-left"> Mr. <span class="font-bold">Aman Bahuguna</span></p>
                <p class="text-right">Date: 01 Aug 2022</p>
            </div>
                <p class="text-center">RE: RETAINERSHIP AGREEMENT</p>
            <p class="text-left">Dear Aman</p>
            <p class="paragraph-margin text-justify line-height">This refers to the discussions the undersigned had with you about
                utilizing your Professional/expert services. The terms which were mutually agreed upon are recorded
                below.</p>
            <p class="subpoints-margin text-justify line-height">1. That w.e.f. 01 Aug 2022 you will take up the assignment of
                Software development at ColoredCow Consulting Pvt. Ltd. and will handle the said assignment and all work
                are incidental to or preparatory to or connected with the above assignment.</p>
            <p class="subpoints-margin text-justify line-height">2. You will provide your services during the retainership
                arrangement as per our requirements or as directed by the Company from time to time.</p>
            <p class="subpoints-margin text-justify line-height">3. You will ensure that the schedule of assignments is properly
                maintained.</p>
            <p class="subpoints-margin text-justify line-height">4. You will be retained on a Retainership fee of Rs 12000
                (all-inclusive, subject to statutory deductions at source, if any, including Income Tax and Service
                Tax). Except for your Retainership fee, you will not be entitled to any other amount or benefit of any
                nature.</p>
            <p class="subpoints-margin text-justify line-height">5. In the event of non-performance or part performance of the
                assignment, the company will have right not to pay or pay proportionately your Retainership fees.</p>
            <p class="subpoints-margin text-justify line-height">6. This Retainership arrangement is for a period of One Year and on
                expiry of the period it will automatically come to an end unless renewed in writing. During the said
                period, this Arrangement can be terminated by the Company without giving any Notice or Reasons. You can
                terminate this arrangement during this period by giving one Month Notice.</p>
            <p class="subpoints-margin text-justify line-height">7. During the tenure, your services are liable to be transferred to
                any present or future establishment of our (Company) or client anywhere in the country.</p>
            <p class="subpoints-margin text-justify line-height">8. The management may also send you on deputation to any other
                organization or establishment anywhere in the country, established presently or in future.</p>
            <p class="subpoints-margin text-justify line-height">9. Restrictive Covenants: While in retainership of our company, you
                will not engage yourself for gain or otherwise in any other employment, avocation, business nor
                undertake any course or study or training without written permission of management.</p>
            <p class="subpoints-margin text-justify line-height">10. While providing services during retainership arrangement you
                will not disclose any confidential information or data in respect of company's business to any other
                person which could adversely affect the business of the company.</p>
            <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span
                    href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
            <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a
                    href="https://coloredcow.com">https://coloredcow.com</a></p>
            <div class="img-center">
                <img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50"
                    width="250">
            </div>
            <p class="subpoints-margin text-justify line-height">11. In the course of your Retainership period with us and by virtue
                of the position held by you, you may acquire information, technical or otherwise which is confidential
                to the firm, or its subsidiaries or affiliates, its customers, subcontractors or any other individuals
                or companies having any kind of association or relationship with the firm, and/or its affiliates or
                subsidiaries, you will not, except as required by your services as a professional, use or disclose or
                authorize anyone else to use or disclose any of such information either during your retainership period
                or thereafter for so long as such information is not publicly or generally known.</p>
            <p class="subpoints-margin text-justify line-height">12. You will not disclose to any public papers, journals, pamphlets
                or affiliates or cause to be disclosed, at any time, any information or documents, official or otherwise
                relating to the Company or its subsidiaries or affiliate except with prior written approval.</p>
            <p class="subpoints-margin text-justify line-height">13. Settlement of Accounts: On termination of your employment for
                whatsoever reason, you will immediately hand over all documents, specifications data or any other
                article or property of the Company or its client entrusted to you to enable the company to settle your
                accounts.</p>
            <br>
            <p>Please confirm by putting your signature below the agreed terms that the same are correctly recorded.</p>
            <br>
            <p>I CONFIRM THE AGREED TERMS ARE CORRECTLY RECORDED</p>
            <p>FOR AND ON BEHALF OF ______________</p>
            <p>( )</p>
            <p>SIGNATURE OF RETAINER</p>
        </div>
    </div>
    <p class="font-color">ColoredCow Consulting Pvt. Ltd | +91 9818571035 | <span
            href="mailto">contact@coloredcow.com</span> | F-61 Suncity,</p>
    <p class="font-color">Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | <a
            href="https://coloredcow.com">https://coloredcow.com</a></p>
</body>
