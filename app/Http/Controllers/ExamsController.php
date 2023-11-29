<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Group;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamsController extends Controller
{
    const PAGE_SIZE = 15;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->type === USER_TYPE_STUDENT) {
                if (!in_array(request()->route()->getName(), ['exams.index', 'exams.attempt'])) {
                    return redirect(RouteServiceProvider::HOME);
                }
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $exams = Exam::latest();
        if ($user->type === USER_TYPE_TEACHER) {
            $exams->where('teacher_id', Auth::user()->id);
        } elseif ($user->type === USER_TYPE_STUDENT) {
            $exams->whereIn('group_id', Auth::user()->groups()->pluck('group_id'))
                ->whereDate('published_at', '<=', Carbon::now()->toDateString());
        }
        $exams = $exams->paginate(SELF::PAGE_SIZE);

        return view('exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::pluck('name', 'id');

        return view('exams.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exam = new Exam;
        $exam->name = $request->name;
        $exam->group_id = $request->group_id;
        $exam->type = $request->type;
        $exam->published_at = $request->published_at;
        $exam->teacher_id = Auth::user()->id;
        $exam->save();

        return redirect()->route('exams.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        if ($this->doesExamBelongsToUser($exam)) {
            $groups = Group::pluck('name', 'id');
            return view('exams.edit', compact('exam', 'groups'));
        }

        return redirect()->route('exams.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        if ($this->doesExamBelongsToUser($exam)) {
            $exam->name = $request->name;
            $exam->group_id = $request->group_id;
            $exam->type = $request->type;
            $exam->published_at = $request->published_at;
            $exam->save();
        }

        return redirect()->route('exams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        if ($this->doesExamBelongsToUser($exam) && $this->doesExamHasNoQuestions($exam)) {
            $exam->delete();
        }

        return redirect()->route('exams.index');
    }

    protected function doesExamBelongsToUser(Exam $exam)
    {
        if (Auth::user()->type === USER_TYPE_ADMIN || $exam->teacher_id === Auth::user()->id) {
            return true;
        }
        return false;
    }

    protected function doesExamHasNoQuestions(Exam $exam)
    {
        if ($exam->questions()->count() > 0) {
            return false;
        }
        return true;
    }

    public function attempt(Exam $exam)
    {
        if (Auth::user()->groups()->pluck('group_id')->contains($exam->group_id)
        && Carbon::now()->diffInDays($exam->published_at, false) <= 0
        &&  !$exam->hasAttempted(Auth::user())) {
            return view('exams.attempt', compact('exam'));
        };
        return redirect()->route('exams.index');
    }
}
