<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BookCategoriesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('book_categories')->delete();

        \DB::table('book_categories')->insert([
            0 => [
                'name' => 'Science',
            ],
            1 => [
                'name' => 'Entrepreneurship',
            ],
            2 => [
                'name' => 'Ability',
            ],
            3 => [
                'name' => 'Advertising campaigns',
            ],
            4 => [
                'name' => 'Afghanistan',
            ],
            5 => [
                'name' => 'Alcoholics',
            ],
            6 => [
                'name' => 'Amyotrophic lateral sclerosis',
            ],
            7 => [
                'name' => 'Biography',
            ],
            8 => [
                'name' => 'Biography & Autobiography',
            ],
            9 => [
                'name' => 'Body, Mind & Spirit',
            ],
            10 => [
                'name' => 'Bullying in the workplace',
            ],
            11 => [
                'name' => 'Business',
            ],
            12 => [
                'name' => 'Business & Economics',
            ],
            13 => [
                'name' => 'Business ethics',
            ],
            14 => [
                'name' => 'Business excellence',
            ],
            15 => [
                'name' => 'Businesspeople',
            ],
            16 => [
                'name' => 'Cancer',
            ],
            17 => [
                'name' => 'Character',
            ],
            18 => [
                'name' => 'Child psychology',
            ],
            19 => [
                'name' => 'Cognition',
            ],
            20 => [
                'name' => 'Communication',
            ],
            21 => [
                'name' => 'Computer software',
            ],
            22 => [
                'name' => 'Computers',
            ],
            23 => [
                'name' => 'Conduct of life',
            ],
            24 => [
                'name' => 'Consumers',
            ],
            25 => [
                'name' => 'Cooks',
            ],
            26 => [
                'name' => 'Corporate reorganizations',
            ],
            27 => [
                'name' => 'Decision making',
            ],
            28 => [
                'name' => 'Design',
            ],
            29 => [
                'name' => 'Detective and mystery stories',
            ],
            30 => [
                'name' => 'Drama',
            ],
            31 => [
                'name' => 'Education',
            ],
            32 => [
                'name' => 'Electronic books',
            ],
            33 => [
                'name' => 'Emotions',
            ],
            34 => [
                'name' => 'English language',
            ],
            35 => [
                'name' => 'Explanation',
            ],
            36 => [
                'name' => 'Family & Relationships',
            ],
            37 => [
                'name' => 'Fiction',
            ],
            38 => [
                'name' => 'Finance, Personal',
            ],
            39 => [
                'name' => 'Geopolitics',
            ],
            40 => [
                'name' => 'Happiness',
            ],
            41 => [
                'name' => 'Health & Fitness',
            ],
            42 => [
                'name' => 'History',
            ],
            43 => [
                'name' => 'india',
            ],
            44 => [
                'name' => 'Industrial design',
            ],
            45 => [
                'name' => 'Language Arts & Disciplines',
            ],
            46 => [
                'name' => 'Leadership',
            ],
            47 => [
                'name' => 'Literary Collections',
            ],
            48 => [
            'name' => 'Love stories, Indic (English)',
            ],
            49 => [
                'name' => 'Mathematics',
            ],
            50 => [
            'name' => 'Motivation (Psychology)',
            ],
            51 => [
                'name' => 'Persistence',
            ],
            52 => [
                'name' => 'Philosophy',
            ],
            53 => [
                'name' => 'Physicians',
            ],
            54 => [
                'name' => 'Political Science',
            ],
            55 => [
                'name' => 'Psychology',
            ],
            56 => [
                'name' => 'Reference',
            ],
            57 => [
                'name' => 'Religion',
            ],
            58 => [
                'name' => 'Science',
            ],
            59 => [
            'name' => 'Self-actualization (Psychology)',
            ],
            60 => [
                'name' => 'Self-Help',
            ],
            61 => [
                'name' => 'Social Science',
            ],
            62 => [
                'name' => 'Sports & Recreation',
            ],
            63 => [
                'name' => 'Technology & Engineering',
            ],
            64 => [
                'name' => 'Violence',
            ],
            65 => [
                'name' => 'Human Resource',
            ],
            66 => [
                'name' => 'Testing',
            ],
            67 => [
                'name' => 'Software Engineering',
            ],
            68 => [
                'name' => 'Product Manager',
            ],
            69 => [
                'name' => 'Project Manager',
            ],
            70 => [
                'name' => 'Entrepreneurship',
            ],
            71 => [
                'name' => 'Marketing',
            ],
            72 => [
                'name' => 'Code',
            ],
            73 => [
                'name' => 'Fantasy',
            ],
        ]);
    }
}
