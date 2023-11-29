<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit {{ intval(\Illuminate\Support\Facades\Auth::user()->type) == USER_TYPE_ADMIN ? 'User' : 'Student' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg p-5">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">First Name</span>
                        </label>
                        <input type="text" name="first_name" required="required" value="{{ old('first_name') ?? $user->first_name }}"
                               placeholder="Type first name here" class="input input-bordered w-full"/>
                        @error('first_name')
                        <div class="alert alert-error justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Last Name</span>
                        </label>
                        <input type="text" name="last_name" required="required" value="{{ old('last_name') ?? $user->last_name }}"
                               placeholder="Type last name here" class="input input-bordered w-full"/>

                        @error('last_name')
                        <div class="alert alert-error justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email" name="email" disabled value="{{ $user->email }}"
                               placeholder="Type email here" class="input input-bordered w-full"/>
                    </div>

                    @if(intval(\Illuminate\Support\Facades\Auth::user()->type) == USER_TYPE_ADMIN)
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Type</span>
                            </label>
                            <div class="flex">
                                <input class="mt-1 mr-1" type="radio" name="type"
                                       @if(intval($user->type) == USER_TYPE_TEACHER) checked @endif
                                       value="{{USER_TYPE_TEACHER}}">
                                <label for="type" class="mr-4">Teacher</label>

                                <input class="mt-1 mr-1" type="radio" name="type"
                                       @if(intval($user->type) == USER_TYPE_STUDENT) checked @endif
                                       value="{{USER_TYPE_STUDENT}}">
                                <label for="type" class="mr-4">Student</label>
                            </div>
                        </div>
                    @endif

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Password</span>
                        </label>
                        <input type="password" name="password"
                               placeholder="Type password here" class="input input-bordered w-full"/>

                        @error('password')
                        <div class="alert alert-error justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>


                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Confirm Password</span>
                        </label>
                        <input type="password" name="password_confirmation"
                               placeholder="Type confirm password here" class="input input-bordered w-full"/>

                        @error('password_confirmation')
                        <div class="alert alert-error justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <div class="mt-5">
                        <a href="{{ route('users.index') }}">
                            <button class="btn" type="button">Cancel</button>
                        </a>
                        <button class="btn btn-primary">Update {{ intval(\Illuminate\Support\Facades\Auth::user()->type) == USER_TYPE_ADMIN ? 'User' : 'Student' }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
