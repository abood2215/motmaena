<?php

namespace App\Http\Controllers;

use App\Models\CourseRegistration;
use App\Models\Testimonial;
use Illuminate\Http\Request;

/** Personal review link sent to paid trainees after their course. */
class ReviewController extends Controller
{
    public function show(string $token)
    {
        $registration = $this->registration($token);

        return view('review', [
            'registration' => $registration,
            'offer'        => $registration->offer(),
            'existing'     => Testimonial::where('registration_id', $registration->id)->first(),
        ]);
    }

    public function store(Request $request, string $token)
    {
        $registration = $this->registration($token);

        $data = $request->validate([
            'rating'     => 'required|integer|min:1|max:5',
            'quote'      => 'required|string|min:5|max:1000',
            'name'       => 'required|string|max:120',
            'show_name'  => 'nullable|boolean',
        ]);

        // Saved hidden; the center chooses what to publish from the admin
        Testimonial::updateOrCreate(['registration_id' => $registration->id], [
            'course_key' => $registration->course_key,
            'name'       => $request->boolean('show_name') ? $data['name'] : mb_substr($data['name'], 0, 1) . '.',
            'subtitle'   => $registration->offer()['title']['ar'] ?? null,
            'quote'      => $data['quote'],
            'rating'     => $data['rating'],
            'is_active'  => false,
        ]);

        return redirect()->route('review.show', $token)->with('review_ok', true);
    }

    private function registration(string $token): CourseRegistration
    {
        return CourseRegistration::where('review_token', $token)->where('status', 'paid')->firstOrFail();
    }
}
