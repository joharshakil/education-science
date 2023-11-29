<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Groups') }} / {{ $group->name }} / {{ __('Students') }} / Add
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg p-5">
                <form action="{{ route('groups.students.store', [$group]) }}" method="POST">
                    @csrf

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Student</span>
                        </label>
                        <select name="student_id" required class="input input-bordered w-full">
                            <option value="">Select...</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-5">
                        <a href="{{ route('groups.students.index', [$group]) }}">
                            <button class="btn" type="button">Cancel</button>
                        </a>
                        <button class="btn btn-primary">Add Student</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
