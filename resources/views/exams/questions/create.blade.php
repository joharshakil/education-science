<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exams') }} / {{ $exam->name }} / {{ __('Questions') }} / Add
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg p-5">
                <form action="{{ route('exams.questions.store', [$exam->id]) }}" method="POST">
                    @csrf
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Question</span>
                        </label>
                        <textarea class="textarea textarea-bordered" name="text" required="required"
                                  placeholder="Type Question here"></textarea>
                    </div>

                    @if($exam->type == EXAM_TYPE_QUIZ)
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Choice 1</span>
                            </label>
                            <input type="text" name="choice_1" required="required"
                                   placeholder="Type Choice 1 here" class="input input-bordered w-full"/>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Choice 2</span>
                            </label>
                            <input type="text" name="choice_2" required="required"
                                   placeholder="Type Choice 2 here" class="input input-bordered w-full"/>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Choice 3</span>
                            </label>
                            <input type="text" name="choice_3" placeholder="Type Choice 3 here"
                                   class="input input-bordered w-full"/>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Choice 4</span>
                            </label>
                            <input type="text" name="choice_4" placeholder="Type Choice 4 here"
                                   class="input input-bordered w-full"/>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Answer</span>
                            </label>
                            <div class="flex">
                                <input class="mt-1 mr-1" type="radio" name="answer" checked value="1">
                                <label for="answer" class="mr-4">Choice 1</label>

                                <input class="mt-1 mr-1" type="radio" name="answer" value="2">
                                <label for="answer" class="mr-4">Choice 2</label>

                                <input class="mt-1 mr-1" type="radio" name="answer" value="3">
                                <label for="answer" class="mr-4">Choice 3</label>

                                <input class="mt-1 mr-1" type="radio" name="answer" value="4">
                                <label for="answer" class="mr-4">Choice 4</label>
                            </div>
                        </div>
                    @endif

                    <div class="mt-5">
                        <a href="{{ route('exams.questions.index', [$exam->id]) }}">
                            <button class="btn" type="button">Cancel</button>
                        </a>
                        <button class="btn btn-primary">Add Question</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
