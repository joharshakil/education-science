<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Result;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamResultsController extends Controller
{
    const CORRECT_SCORE = 1;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->type === USER_TYPE_STUDENT) {
                if (!in_array(request()->route()->getName(), ['exams.results.store', 'exams.results.show'])) {
                    return redirect(RouteServiceProvider::HOME);
                }
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function index(Exam $exam)
    {
        return view('exams.results.index', compact('exam'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Exam $exam)
    {
        $i = 0;

        foreach ($exam->questions as $question) {
            if ($question->exam->type === EXAM_TYPE_QUIZ) {
                $score = $request->answers[$i] === $question->answer ? self::CORRECT_SCORE : 0; // TODO : FIx it
            } else {
                $score = 0;
            }

            $result = new Result;
            $result->answer = $request->answers[$i];
            $result->score = $score;
            $result->exam_id = $exam->id;
            $result->question_id = $question->id;
            $result->student_id = Auth::user()->id;
            $result->save();

            $i++;
        }

        return redirect()->route('exams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam, User $student)
    {
        $user = Auth::user();

        if ($user->type !== USER_TYPE_STUDENT
            || ($user->type === USER_TYPE_STUDENT && $user->id === $student->id)) {

            $results = Result::where('exam_id', $exam->id)
                ->where('student_id', $student->id)
                ->get();

            if ($results->count()) {
                return view('exams.results.show', compact('exam', 'student', 'results'));
            }
        }

        return redirect()->route('exams.index');
    }
}
