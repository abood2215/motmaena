<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'title' => 'دورة الذكاء العاطفي في العلاقات',
            'description' => 'تعلم كيف تدير مشاعرك وتفهم مشاعر الآخرين لبناء علاقات ناجحة ومستقرة.',
            'price' => 250,
            'level' => 'متوسط',
            'is_new' => true,
        ]);

        Course::create([
            'title' => 'مهارات التواصل الفعال',
            'description' => 'اكتشف أسرار التواصل الناجح وكيفية التأثير في الآخرين وإقناعهم بمهارة.',
            'price' => 180,
            'level' => 'مبتديء',
            'is_new' => false,
        ]);

        Course::create([
            'title' => 'فنون تربية الأطفال المبدعين',
            'description' => 'دليل شامل للوالدين لفهم نفسية الطفل وتطوير مهاراته الإبداعية والقيادية.',
            'price' => 220,
            'level' => 'عام',
            'is_new' => false,
        ]);
    }
}

