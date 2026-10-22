<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = ['question_ar', 'answer_ar', 'question_en', 'answer_en', 'sort', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function question(string $lang): string
    {
        return $lang === 'en' && $this->question_en ? $this->question_en : $this->question_ar;
    }

    public function answer(string $lang): string
    {
        return $lang === 'en' && $this->answer_en ? $this->answer_en : $this->answer_ar;
    }
}
