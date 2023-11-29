<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
{
    const PAGE_SIZE = 15;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $groups = Group::latest();
        if ($user->type === USER_TYPE_TEACHER) {
            $groups->where('teacher_id', Auth::user()->id);
        }
        $groups = $groups->paginate(SELF::PAGE_SIZE);

        return view('groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group = new Group;
        $group->name = $request->name;
        $group->teacher_id = Auth::user()->id;
        $group->save();

        return redirect()->route('groups.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        if ($this->doesGroupBelongsToUser($group)) {
            return view('groups.edit', compact('group'));
        }

        return redirect()->route('groups.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        if ($this->doesGroupBelongsToUser($group)) {
            $group->name = $request->name;
            $group->save();
        }

        return redirect()->route('groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        if ($this->doesGroupBelongsToUser($group)
            && $this->doesGroupHasNoExams($group)
            && $this->doesGroupHasNoStudents($group)) {
            $group->delete();
        }

        return redirect()->route('groups.index');
    }

    protected function doesGroupBelongsToUser(Group $group)
    {
        if (Auth::user()->type === USER_TYPE_ADMIN || $group->teacher_id === Auth::user()->id) {
            return true;
        }
        return false;
    }

    protected function doesGroupHasNoExams(Group $group)
    {
        if ($group->exams()->count() > 0) {
            return false;
        }
        return true;
    }

    protected function doesGroupHasNoStudents(Group $group): bool
    {
        if ($group->students()->count() > 0) {
            return false;
        }
        return true;
    }

}
