<?php

use App\Http\Controllers\ExamQuestionsController;
use App\Http\Controllers\ExamResultsController;
use App\Http\Controllers\ExamsController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\GroupStudentsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.home');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $stats = [];
        $stats['students'] = \App\Models\User::where('type', USER_TYPE_STUDENT)->count();
        $stats['exams'] = \App\Models\Exam::count();
        $stats['rooms'] = \App\Models\Group::count();

        $students = \App\Models\User::latest()->where('type', USER_TYPE_STUDENT)->paginate(10);

        $exams_count_per_type = \App\Models\Exam::select(\Illuminate\Support\Facades\DB::raw('count(id) as type_count'))
                        ->groupBy('type')
                        ->orderBy('type')
                        ->get()->toArray();

        $groups_students = \App\Models\Group::select('name')->withCount('students')->get()->toArray();

        return view('dashboard', compact('stats', 'students', 'exams_count_per_type', 'groups_students'));
    })->name('dashboard');
    Route::resource('exams', ExamsController::class);
    Route::get('exams/{exam}/attempt', [ExamsController::class, 'attempt'])
        ->name('exams.attempt');
    Route::get('/exams/{exam}/results', [ExamResultsController::class, 'index'])
        ->name('exams.results.index');
    Route::post('/exams/{exam}/results', [ExamResultsController::class, 'store'])
        ->name('exams.results.store');
    Route::get('/exams/{exam}/results/{student}', [ExamResultsController::class, 'show'])
        ->name('exams.results.show');
    Route::resource('exams.questions', ExamQuestionsController::class);
    Route::resource('groups', GroupsController::class);
    Route::resource('groups.students', GroupStudentsController::class)
    ->only('index','store','create');
    Route::get('groups/{group}/students/{user}', [GroupStudentsController::class, 'removeFromGroup'])
        ->name('groups.students.remove_from_group');
    Route::resource('users', UsersController::class);
});
//
//Route::get('run-user-seeder', function () {
//    \Illuminate\Support\Facades\Artisan::call("db:seed", array('--class' => 'UserSeeder'));
//});
