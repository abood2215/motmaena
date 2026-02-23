<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class CourseGrid extends Component
{
    public $search = '';
    public $level = '';

    protected $queryString = ['search', 'level'];

    public function render()
    {
        $courses = Course::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->level, function ($query) {
                $query->where('level', $this->level);
            })
            ->latest()
            ->get();

        return view('livewire.course-grid', [
            'courses' => $courses,
        ]);
    }
}
