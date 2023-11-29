<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupStudentsController extends Controller
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
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group)
    {
        return view('groups.students.index', compact('group'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function create(Group $group)
    {
        $students = User::where('type', USER_TYPE_STUDENT)
            ->whereNotIn('id', $group->students()->pluck('user_id'))
            ->get();

        return view('groups.students.create', compact('group', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $group)
    {
        $group->students()->attach($request->student_id);

        return redirect()->route('groups.students.index', [$group]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Group $group
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function removeFromGroup(Group $group, User $user)
    {
        $group->students()->detach($user);

        return redirect()->route('groups.students.index', [$group]);
    }
}
