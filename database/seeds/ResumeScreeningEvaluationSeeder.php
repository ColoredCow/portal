<?php

use App\Models\HR\EvaluationParameter;
use App\Models\HR\Round;
use Carbon\Carbon;
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
    	$created_at = Carbon::now()->format('Y-m-d H:i:s');

        $evaluationParametersList = [
            [
                'name' => 'Patterns in grades: Any special pattern in grades - like consistency, declining or increasing consistently. Gap, change in study stream, special courses.',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Patterns in grades: Evidence of consistency - Through grades or any achievement.',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Patterns in grades: Evidence of Bounce Back - From low grades to great ones. From anything poor to something great.',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Self-assessment (resume interview): Do you have your resume in front of you?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Self-assessment (resume interview): Does it represent you in the true sense?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Self-assessment (resume interview): Which part do you want to highlight?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Internship Experience: Where? Kind of work? How they got it? How long?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'If grades and proves are not good: His take on his situation? (Is he a whiner?)',
                'created_at' => $created_at,
            ],
            [
                'name' => 'If grades and proves are not good: Does he look fake?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'If grades and proves are not good: Does he realize the need to correct the situation?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'If grades and proves are not good: Able to thrive under the support and guidance?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'If grades and proves are not good: How serious is he about his career? Alternatives? Further Studies?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'If grades and proves are not good: Is he hopeful or just want to get by? Does he have a healthy self-image?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Evidence of Self Learning: Quick Learner.',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Evidence of Self Learning: Has learned something more than what course asked for.',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Evidence of Self Learning: What is the depth of execution and knowledge? His self-rating. Your assessment rating.',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Evidence of Self Learning: Check too much dependency on training institutes to learn skills.',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Evidence of Self Learning: Learning methodology - Structural, ad-hoc.',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Evidence of Self Learning (In case the candidate has proof of Self and Quick Learner): Why he picked that skill?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Evidence of Self Learning (In case the candidate has proof of Self and Quick Learner): What were the challenges?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Evidence of Self Learning (In case the candidate has proof of Self and Quick Learner): How did he balance between regular and this extra?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Evidence of Self Learning (In case the candidate has proof of Self and Quick Learner): What are the other things he wants to learn now?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Evidence of Self Learning (In case the candidate has no proof of Self and Quick Learner): What is the belief system about learning',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Evidence of Self Learning (In case the candidate has no proof of Self and Quick Learner): The reason for his not doing it',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Evidence of Self Learning (In case the candidate has no proof of Self and Quick Learner): How can he correct, if he agrees, the situation now?',
                'created_at' => $created_at,
            ],

            [
                'name' => 'Evidence of a Champion: like a national swimmer, a finalist in India Idol, or something similar but at a decent level. Any sign of some exceptional result?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Evidence of Leadership: Like school captain, leadership position in college communities.',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Healthy LinkedIn network: Is it big enough? Is it just people up, or down, or a good spread?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Local but long commute?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'The University Ranking: Like IIT, IIM where getting admission is very competitive.',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Seriousness in applying: Detail of the answer for Reason for eligibility',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Seriousness in applying: Check the written Communication as a side effect.',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Openness and Biases',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Family Background: How independent?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Family Background: Influenced by?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Family Background: How they enable him to become what he is today?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Passion check: Passionfruit question?',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Passion check: Check rigidity - Vamsi pattern',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Interesting Check: Storyteller',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Interesting Check: Energetic',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Interesting Check: Presentable',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Interesting Check: Laughing and smiling',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Interesting Check: Crack the joke or appreciate the joke',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Interesting Check: Too serious or too funny',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Interesting Check: Take things easy',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Interesting Check: Reaction on feedback, criticism.',
                'created_at' => $created_at,
            ],
            [
                'name' => 'The gut feeling of the fitment.',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Communication',
                'created_at' => $created_at,
            ],
            [
                'name' => 'Communication: Verbal',
                'created_at' => $created_at,
            ],
        ];

        $evaluationParametersOptions = [
        	[
                'value' => 'Positive',
                'created_at' => $created_at,
            ],
            [
                'value' => 'Negative',
                'created_at' => $created_at,
            ],
            [
                'value' => 'N/A',
                'created_at' => $created_at,
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
