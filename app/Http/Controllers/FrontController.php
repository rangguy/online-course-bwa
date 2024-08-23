<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function index()
    {

        $courses = Course::with(['category', 'teacher', 'students'])->orderByDesc('id')->get();

        return view('front.index', compact('courses'));
    }

    public function details(Course $course)
    {
        return view('front.details', compact('course'));
    }

    public function learning(Course $course, $courseVideoId)
    {

        $user = Auth::user();
        if (!$user->hasActiveSubscription()) {
            return redirect()->route('front.pricing');
        }

        $video = $course->course_videos->firstWhere('id', $courseVideoId);

        $user->courses()->syncWithoutDetaching($course->id);

        return view('front.learning', compact('course', 'video'));
    }
}
