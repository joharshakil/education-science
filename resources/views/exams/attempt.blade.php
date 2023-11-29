<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exams') }} / {{ $exam->name }} / Attempt
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg p-5">
                <form action="{{ route('exams.results.store', [$exam->id]) }}" method="POST">
                    @csrf
                    <div class="flex flex-col w-full border-opacity-50">
                        @php($i = 0)
                        @forelse($exam->questions as $question)
                            <div class="grid card p-5 rounded-box border">
                                @if($question->exam->type == EXAM_TYPE_QUIZ)
                                    <span class="font-bold">{{ $question->text }}</span>
                                    <div class="form-control w-full">
                                        <label class="label">
                                            <span class="label-text">{{ $question->text }}</span>
                                        </label>
                                        <div class="flex">
                                            <input class="mt-1 mr-1" type="radio" name="answers[{{$i}}]" value="1" required>
                                            <label for="answer" class="mr-4">{{ $question->choice_1 }}</label>
                                            <input class="mt-1 mr-1" type="radio" name="answers[{{$i}}]" value="2" required>
                                            <label for="answer" class="mr-4">{{ $question->choice_2 }}</label>
                                            @if($question->choice_3)
                                            <input class="mt-1 mr-1" type="radio" name="answers[{{$i}}]" value="3" required>
                                            <label for="answer" class="mr-4">{{ $question->choice_3 }}</label>
                                            @endif
                                            @if($question->choice_4)
                                            <input class="mt-1 mr-1" type="radio" name="answers[{{$i}}]" value="4" required>
                                            <label for="answer" class="mr-4">{{ $question->choice_4 }}</label>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <span class="font-bold">Question: {{ $question->text }}</span>
                                    <textarea placeholder="Type your Answer" name="answers[]" required
                                              class="textarea textarea-bordered textarea-lg w-full" ></textarea>
                                @endif
                            </div>
                            @if (!$loop->last)
                                <div class="divider"></div>
                            @endif
                            @php($i++)
                        @empty
                        @endforelse
                    </div>

                    <div class="mt-5">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
