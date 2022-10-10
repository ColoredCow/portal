<style>
body {
    font-family: Roboto;
}

.certificate-container {
    padding: 50px;
    width: 1024px;
}
.certificate {
    border: 20px solid #0C5280;
    padding: 25px;
    height: 600px;
    position: relative;
}

.certificate:after {
    content: '';
    top: 0px;
    left: 0px;
    bottom: 0px;
    right: 0px;
    position: absolute;
    background-size: 100%;
    z-index: -1;
}

.certificate-header > .logo {
    width: 80px;
    height: 80px;
}

.certificate-title {
    text-align: center;
    color: rgb(77, 5, 5);
    font-size: 20px;
}

.certificate-body {
    text-align: center;
}

h1 {

    font-weight: 400;
    font-size: 48px;
    color: #0C5280;
}

.student-name {
    font-size: 24x;
}

.certificate-content {
    margin: 0 auto;
    width: 750px;
}

.about-certificate {
    width: 380px;
    margin: 0 auto;
}

.topic-description {

    text-align: center;
}
.img-center{
    text-align: center;
}

.name{
    text-align: center;
    font-size: 2px;
}

.text-left{
    text-align: left;
    overflow-wrap: break-word;
}
</style>
<div class = "background"></div>
<div class="certificate-container">
    <div class="certificate">
        <div class="water-mark-overlay"></div>
        <div class="center">
            <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
        </div><br>
        <div class="name">
           <h1>{{$applicant->name}}</h1>
        </div>
        <div class="certificate-body">
            <p class="certificate-title"><strong>Internship Certificate
                of Completion 
                <div class="certificate-title"> from {{ date('d-M-y', strtotime($applicant->start_date)) }} To {{ date('d-M-y', strtotime($applicant->end_date)) }}</strong></div>
            </p><br>
            <div class="certificate-content">
                <div class="about-certificate">
                    ColoredCow is glad to certify that <strong>{{$applicant->name}}</strong> successfully
                    completed his internship .
                </p>
                </div>
                <p class="topic-title">
                    He gained exposure to working with teams in an organizational environment, worked on fundamentals of software development using the right tools and best
                    practices, and polished his skills in learning and building Open Source Applications.
                </p>
                <div class="text-center">
                    <p class="topic-description text-muted">ColoredCow recognizes her desire to learn and wishes her great success!</p><br>
                </div>
                <div  class="text-left">Satendra rawat</div>
                <div  class="text-left">Sr. Software Engineer,</div>
                <div  class="text-left"> Center Head</div>
                <div  class="text-left">ColoredCow (Tehri)</div>
            </div>
        </div>
    </div>
</div>
