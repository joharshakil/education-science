<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exams') }} / Edit
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg p-5">
                <form action="{{ route('exams.update', [$exam->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Exam Name</span>
                        </label>
                        <input type="text" name="name" required="required" minlength="3"
                               placeholder="Type Exam Name here" value="{{$exam->name}}"
                               class="input input-bordered w-full max-w-sm"/>
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Group</span>
                        </label>
                        <select required id="group_id" name="group_id" class="form-input">
                            <option value="">Select Group</option>
                            @foreach($groups as $group_id => $group_name)
                                <option value="{{ $group_id }}"
                                        @if($exam->group_id == $group_id) selected @endif>{{$group_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Type</span>
                        </label>
                        <div class="flex">
                            <input class="mt-1 mr-1" type="radio" name="type"
                                   @if($exam->type == EXAM_TYPE_QUIZ) checked @endif value="{{EXAM_TYPE_QUIZ}}">
                            <label for="type" class="mr-4">Quiz</label>

                            <input class="mt-1 mr-1" type="radio" name="type"
                                   @if($exam->type == EXAM_TYPE_SURVEY) checked @endif value="{{EXAM_TYPE_SURVEY}}">
                            <label for="type" class="mr-4">Survey</label>

                            <input class="mt-1 mr-1" type="radio" name="type"
                                   @if($exam->type == EXAM_TYPE_EXPERIMENT) checked
                                   @endif value="{{EXAM_TYPE_EXPERIMENT}}">
                            <label for="type" class="mr-4">Experiment</label>
                        </div>
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Published At</span>
                        </label>
                        <input type="date" name="published_at" required="required"
                               value="{{ $exam->published_at->format('Y-m-d')}}"
                               class="input input-bordered w-full max-w-sm"/>
                    </div>

                    <div class="mt-5">
                        <a href="{{ route('exams.index', [$exam->id]) }}">
                            <button class="btn" type="button">Cancel</button>
                        </a>
                        <button class="btn btn-primary">Update Exam</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
