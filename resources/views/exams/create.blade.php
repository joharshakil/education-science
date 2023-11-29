<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exams') }} / Add
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg p-5">
                <form action="{{ route('exams.store') }}" method="POST">
                    @csrf
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Exam Name</span>
                        </label>
                        <input type="text" name="name" required="required" minlength="3"
                               placeholder="Type Exam Name here" class="input input-bordered w-full max-w-sm"/>
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Group</span>
                        </label>
                        <select required id="group_id" name="group_id" class="form-input">
                            <option value="">Select Group</option>
                            @foreach($groups as $group_id => $group_name)
                                <option value="{{ $group_id }}"
                                        @if(old('group_id') == $group_id) selected @endif>{{$group_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Type</span>
                        </label>
                        <div class="flex">
                            <input class="mt-1 mr-1" type="radio" name="type" checked value="{{EXAM_TYPE_QUIZ}}">
                            <label for="type" class="mr-4">Quiz</label>

                            <input class="mt-1 mr-1" type="radio" name="type" value="{{EXAM_TYPE_SURVEY}}">
                            <label for="type" class="mr-4">Survey</label>

                            <input class="mt-1 mr-1" type="radio" name="type" value="{{EXAM_TYPE_EXPERIMENT}}">
                            <label for="type" class="mr-4">Experiment</label>
                        </div>
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Published At</span>
                        </label>
                        <input type="date" name="published_at" required="required"
                               class="input input-bordered w-full max-w-sm"/>
                    </div>

                    <div class="mt-5">
                        <a href="{{ route('exams.index') }}">
                            <button class="btn" type="button">Cancel</button>
                        </a>
                        <button class="btn btn-primary">Add Exam</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
