<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UsersController extends Controller
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
        $users = User::latest();
        if ($user->type === USER_TYPE_ADMIN) {
            $users->whereNot('type', USER_TYPE_ADMIN);
        }else if ($user->type === USER_TYPE_TEACHER) {
            $users->where('type', USER_TYPE_STUDENT);
        }
        $users = $users->paginate(self::PAGE_SIZE);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'alpha_num:ascii', 'max:255'],
            'last_name' => ['required', 'alpha_num:ascii', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = null;
        do{
            $username = strtolower($request->first_name.'.'.$request->last_name).'.'.mt_rand(111,999);
            $user = User::where('username', $username)->first();
        }while($user);

        $user = User::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => Auth::user()->type === USER_TYPE_TEACHER ? USER_TYPE_STUDENT : $request->type,
        ]);

        event(new Registered($user));

        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validations = [
            'first_name' => ['required', 'alpha_num:ascii', 'max:255'],
            'last_name' => ['required', 'alpha_num:ascii', 'max:255'],
        ];

        if($request->password || $request->password_confirmation) {
            $validations['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        $request->validate($validations);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.index');
    }
}
