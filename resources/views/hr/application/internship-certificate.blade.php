<style>
body {
    font-family: Roboto;
}

.certificate-container {
    padding: 5px;
    width: 10px;
}
.background{
    background-image: url("/images/Border.png");
    position: relative;
    padding-bottom: 150px;
    background-repeat: no-repeat;
    background-size: 1950px; 
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
    color: rgb(148, 0, 0);
    font-size: 30px;
}

.image-leaf{
    background-image: url('/images/leaf.png');
    margin-left: 10px;
    height: 150px;
    background-size: 100%;
    background-repeat: no-repeat;
    width: 1000px;
}

.centered {
    position: absolute;
    color: rgb(194, 167, 0);
    text-align: center;
    margin-top: 40px;
    padding-left: 30px;
    font-size: 30px;
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
    width: 550px;

}

.about-certificate {
    width: 10px;
    margin:  auto;
}

.topic-title{
    margin: auto;
    width: 550px;
    margin-top: 15px;
}

.topic-description {

    text-align: center;
}
.img-center{
    text-align: center;
    margin-top: 100px;
}

.name{
    text-align: center;
    font-size: 2px;
}

.text-left{
    text-align: left;
    padding-left: 70px;
}
</style>
<div class="background">
<div class="certificate-container">
    <div class="certificate">
        <div class="water-mark-overlay"></div>
        <div class="center">
            <div class="img-center"><img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250"></div>
        </div><br>
        <div class="certificate-body">
            <p class="certificate-title"><strong>Internship Certificate</strong><br>
                <strong> Completion</strong> 
                <div class="image-leaf">
                    <div class="centered"><strong>{{$applicant->name}}</strong></div>
                </div>
            </p><br>
            <div class="certificate-content">
                <div class="about-certificate">
                    ColoredCow is glad to certify that <strong>{{$applicant->name}}</strong> successfully
                    completed his internship from {{ date('d-M-y', strtotime($applicant->start_date)) }} To {{ date('d-M-y', strtotime($applicant->end_date)) }}</strong></div>
                </p>
                </div>
                <p class="topic-title">
                    He gained exposure to working with teams in an organizational environment, worked on fundamentals of software development using the right tools and best
                    practices, and polished his skills in learning and building Open Source Applications.
                </p>
                <div class="text-center">
                    <p class="topic-description text-muted">ColoredCow recognizes her desire to learn and wishes her great success!</p><br>
                </div>
                <div class="text-left"><img src="{{ public_path() . '/images/Stamp.png' }}"alt="" align="left" height="80" width="80">
                <div>Satendra rawat</div>
                <div>Sr.Software Engineer,</div>
                <div> Center Head</div>
                <div>ColoredCow (Tehri)</div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>