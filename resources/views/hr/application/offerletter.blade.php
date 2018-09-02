<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h2>ColoredCow</h2>
    <h3 class="text-center"> Offer Letter</h3>
    <hr>
    
    
    <p class="text-justify">
      Dear : {{$applicant->name}},<br>
            {{$applicant->email}}<br><br>
      ColoredCow is excited to bring you on board as {{$job->title}}.<br>
      We’re just a few formalities away from getting down to work. Please take the time to review our offer. It includes important details about your compensation, benefits and the terms and conditions of your anticipated employment with ColoredCow.<br>
      ColoredCow is offering a [full time, part time, etc.] position for you as {{$job->title}}, reporting to [immediate manager/supervisor] starting on [proposed start date] at Gurgaon. Expected hours of work are [days of week and hours of work].<br>
      In this position, ColoredCow is offering to start you at a pay rate of [dollar amount or annual base salary] per [year, hour, annual salary, etc.]. You will be paid on a [weekly, monthly, etc] basis, starting [date of next pay period].<br>
      As part of your compensation, we're also offering [If applicable, you’ll describe your bonus, profit sharing, commission structure, stock options, and compensation committee rules here].
      As an employee of ColoredCow you will be eligible for [briefly name benefits, such as health insurance, stock plan, dental insurance, etc.].<br>
      Please indicate your agreement with these terms and accept this offer by signing and dating this agreement on or before [offer expiration date].<br><br>

      Sincerely,

    </p>
    
  </body>
</html>