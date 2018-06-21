<?php

use App\Models\HR\EvaluationParameter;
use App\Models\HR\Round;
use Illuminate\Database\Seeder;

class ResumeScreeningEvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $evaluationParametersList = [
            [
                'name' => 'Patterns in grades: Any special pattern in grades - like consistency, declining or increasing consistently. Gap, change in study stream, special courses.',
            ],
            [
                'name' => 'Patterns in grades: Evidence of consistency - Through grades or any achievement.',
            ],
            [
                'name' => 'Patterns in grades: Evidence of Bounce Back - From low grades to great ones. From anything poor to something great.',
            ],
            [
                'name' => 'Self-assessment (resume interview): Do you have your resume in front of you?',
            ],
            [
                'name' => 'Self-assessment (resume interview): Does it represent you in the true sense?',
            ],
            [
                'name' => 'Self-assessment (resume interview): Which part do you want to highlight?',
            ],
            [
                'name' => 'Internship Experience: Where? Kind of work? How they got it? How long?',
            ],
            [
                'name' => 'If grades and proves are not good: His take on his situation? (Is he a whiner?)',
            ],
            [
                'name' => 'If grades and proves are not good: Does he look fake?',
            ],
            [
                'name' => 'If grades and proves are not good: Does he realize the need to correct the situation?',
            ],
            [
                'name' => 'If grades and proves are not good: Able to thrive under the support and guidance?',
            ],
            [
                'name' => 'If grades and proves are not good: How serious is he about his career? Alternatives? Further Studies?',
            ],
            [
                'name' => 'If grades and proves are not good: Is he hopeful or just want to get by? Does he have a healthy self-image?',
            ],
            [
                'name' => 'Evidence of Self Learning: Quick Learner.',
            ],
            [
                'name' => 'Evidence of Self Learning: Has learned something more than what course asked for.',
            ],
            [
                'name' => 'Evidence of Self Learning: What is the depth of execution and knowledge? His self-rating. Your assessment rating.',
            ],
            [
                'name' => 'Evidence of Self Learning: Check too much dependency on training institutes to learn skills.',
            ],
            [
                'name' => 'Evidence of Self Learning: Learning methodology - Structural, ad-hoc.',
            ],
            [
                'name' => 'Evidence of Self Learning (In case the candidate has proof of Self and Quick Learner): Why he picked that skill?',
            ],
            [
                'name' => 'Evidence of Self Learning (In case the candidate has proof of Self and Quick Learner): What were the challenges?',
            ],
            [
                'name' => 'Evidence of Self Learning (In case the candidate has proof of Self and Quick Learner): How did he balance between regular and this extra?',
            ],
            [
                'name' => 'Evidence of Self Learning (In case the candidate has proof of Self and Quick Learner): What are the other things he wants to learn now?',
            ],
            [
                'name' => 'Evidence of Self Learning (In case the candidate has no proof of Self and Quick Learner): What is the belief system about learning',
            ],
            [
                'name' => 'Evidence of Self Learning (In case the candidate has no proof of Self and Quick Learner): The reason for his not doing it',
            ],
            [
                'name' => 'Evidence of Self Learning (In case the candidate has no proof of Self and Quick Learner): How can he correct, if he agrees, the situation now?',
            ],

            [
                'name' => 'Evidence of a Champion: like a national swimmer, a finalist in India Idol, or something similar but at a decent level. Any sign of some exceptional result?',
            ],
            [
                'name' => 'Evidence of Leadership: Like school captain, leadership position in college communities.',
            ],
            [
                'name' => 'Healthy LinkedIn network: Is it big enough? Is it just people up, or down, or a good spread?',
            ],
            [
                'name' => 'Local but long commute?',
            ],
            [
                'name' => 'The University Ranking: Like IIT, IIM where getting admission is very competitive.',
            ],
            [
                'name' => 'Seriousness in applying: Detail of the answer for Reason for eligibility',
            ],
            [
                'name' => 'Seriousness in applying: Check the written Communication as a side effect.',
            ],
            [
                'name' => 'Openness and Biases',
            ],
            [
                'name' => 'Family Background: How independent?',
            ],
            [
                'name' => 'Family Background: Influenced by?',
            ],
            [
                'name' => 'Family Background: How they enable him to become what he is today?',
            ],
            [
                'name' => 'Passion check: Passionfruit question?',
            ],
            [
                'name' => 'Passion check: Check rigidity - Vamsi pattern',
            ],
            [
                'name' => 'Interesting Check: Storyteller',
            ],
            [
                'name' => 'Interesting Check: Energetic',
            ],
            [
                'name' => 'Interesting Check: Presentable',
            ],
            [
                'name' => 'Interesting Check: Laughing and smiling',
            ],
            [
                'name' => 'Interesting Check: Crack the joke or appreciate the joke',
            ],
            [
                'name' => 'Interesting Check: Too serious or too funny',
            ],
            [
                'name' => 'Interesting Check: Take things easy',
            ],
            [
                'name' => 'Interesting Check: Reaction on feedback, criticism.',
            ],
            [
                'name' => 'The gut feeling of the fitment.',
            ],
            [
                'name' => 'Communication',
            ],
            [
                'name' => 'Communication: Verbal',
            ],
        ];

        $evaluationParametersOptions = [
            [
                'value' => 'Positive',
            ],
            [
                'value' => 'Negative',
            ],
            [
                'value' => 'N/A',
            ],
        ];

        $round = Round::where('name', 'Resume Screening')->first();

        $round->evaluationParameters()->createMany($evaluationParametersList);

        $evaluationParameters = EvaluationParameter::all();

        foreach ($evaluationParameters as $evaluationParameter) {
            $evaluationParameter->options()->createMany($evaluationParametersOptions);
        }
    }
}
