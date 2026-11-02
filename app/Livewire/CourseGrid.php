<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class CourseGrid extends Component
{
    public $search = '';
    public $level = '';

    /** How many recorded courses show before "show more" (12 at a time keeps the page short on phones) */
    public int $perPage = 12;

    protected $queryString = ['search', 'level'];

    public function loadMore(): void
    {
        $this->perPage += 12;
    }

    // A new search or level starts again from the first 12
    public function updatedSearch(): void { $this->perPage = 12; }
    public function updatedLevel(): void { $this->perPage = 12; }

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
            'courses' => $courses->take($this->perPage),
            'total'   => $courses->count(),
        ]);
    }
}
