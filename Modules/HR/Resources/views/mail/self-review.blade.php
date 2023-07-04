<div>
    <style>
        .line {
            line-height: 1px;
        }
    </style>
    <p>Dear, {{ $employee->first()->name }}</p>
    <p>I hope this email finds you well and in good spirits!</p>
    <p>At ColoredCow our belief is we build great people who do extraordinary things. To facilitate the growth of
        talent, we are on our way to creating a career progression model, which requires a quarterly review of an
        employee based on some holistic growth parameters.</p>
    <br>
    <p>It’s time for you to do your self-assessment for the first quarter!
        <a href="{{ $selfReviewLink }}">Your assessment sheet</a>
    </p>
    <h5>Your assessment sheet<br>
        Target date: {{ $targetedDate }}</h5>
    <p>Parallely your mentor, manager, and an HR team member are also working on reviewing your performance.
    </p>
    <br>
    <p>We are new to this model and we all need to train ourselves to do a great assessment. That’s why we created a few
        training modules, which you may find helpful and handy.</p>
    <p>&#x2022; <a
            href="https://docs.google.com/presentation/d/1yhYQJaEAxSX7vVOrJEyn7WR3vNqybD_m8nSzoeTf0oE/edit#slide=id.p">Evaluation
            guideline</a>- To run this model for self assessment.</p>
    <p>&#x2022; <a
            href="https://docs.google.com/presentation/d/169wTST4wjzGKvLRhAPq4z8HiB4wkonvelyUqHHQitMk/edit">Training
            model</a>on the holistic growth parameters for all the roles in the organization.</p>
    <h5><i>**The end goal is to educate ColoredCow Remarkables through a method of case studies. Keep visiting this
            training
            model for new learnings and betterment</i></h5>
    <p>If you have any inputs to make this whole process better or contribute to it, feel free to reach out.</p>
    <p class="line">Let’s get better together!</p>
    <p class="line">Regards</p>
</div>
