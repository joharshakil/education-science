<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Exam;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamQuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->type === USER_TYPE_STUDENT) {
                return redirect(RouteServiceProvider::HOME);
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
        return view('exams.questions.index', ['exam' => $exam]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function create(Exam $exam)
    {
        return view('exams.questions.create', ['exam' => $exam]);
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
        $question = new Question;
        $question->text = $request->text;
        if ($exam->type === EXAM_TYPE_QUIZ) {
            $question->answer = $request->answer;
            $question->choice_1 = $request->choice_1;
            $question->choice_2 = $request->choice_2;
            $question->choice_3 = $request->choice_3;
            $question->choice_4 = $request->choice_4;
        }
        $question->exam_id = $exam->id;
        $question->teacher_id = Auth::user()->id;
        $question->save();

        return redirect()->route('exams.questions.index', [$exam->id, $question->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Exam $exam
     * @param \App\Models\Question $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam, Question $question)
    {
        if ($this->doesQuestionBelongsToUser($question)) {
            return view('exams.questions.edit', compact('exam', 'question'));
        }

        return redirect()->route('exams.questions.index', [$exam->id, $question->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Exam $exam
     * @param \App\Models\Question $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam, Question $question)
    {
        if ($this->doesQuestionBelongsToUser($question)) {
            $question->text = $request->text;
            if ($exam->type === EXAM_TYPE_QUIZ) {
                $question->answer = $request->answer;
                $question->choice_1 = $request->choice_1;
                $question->choice_2 = $request->choice_2;
                $question->choice_3 = $request->choice_3;
                $question->choice_4 = $request->choice_4;
            }
            $question->save();
        }

        return redirect()->route('exams.questions.index', [$exam->id, $question->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Exam $exam
     * @param \App\Models\Question $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam, Question $question)
    {
        if ($this->doesQuestionBelongsToUser($question) && $question->exam_id === $exam->id) {
            $question->delete();
        }

        return redirect()->route('exams.questions.index', [$exam->id]);

    }

    protected function doesQuestionBelongsToUser(Question $question)
    {
        if ($question->teacher_id !== Auth::user()->id) {
            return false;
        }
        return true;
    }
}
