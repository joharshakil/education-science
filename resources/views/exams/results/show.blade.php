<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exams') }} / {{ $exam->name }} / Results / {{$student->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg p-5">
                @csrf
                <div class="flex flex-col w-full border-opacity-50">
                    @forelse($results as $result)
                        <div class="grid card p-5  rounded-box border">
                            @if($result->exam->type == EXAM_TYPE_QUIZ)
                                <span class="font-bold">{{ $result->question->text }}</span>
                                <div class="form-control w-full">
                                    <label class="label">
                                        <span class="label-text">{{ $result->question->text }}</span>
                                    </label>
                                    <div class="flex">
                                        @for ($i = 1; $i <= 4; $i++)
                                            @if($result->question->answer !== (int)$result->answer && (int)$result->answer == $i)
                                                <label for="answer_{{ $result->id }}"
                                                       class="mr-4 flex font-bold text-error">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="stroke-current shrink-0 h-6 w-6" fill="none"
                                                         viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span>{{ $result->question->{'choice_'.$i} }}</span>
                                                </label>
                                            @elseif($result->question->answer == $i)
                                                <label for="answer_{{ $result->id }}"
                                                       class="mr-4 flex font-bold text-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="stroke-current shrink-0 h-6 w-6" fill="none"
                                                         viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span>{{ $result->question->{'choice_'.$i} }}</span>
                                                </label>
                                            @else
                                                <label for="answer_{{ $result->id }}"
                                                       class="mr-4 flex">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="stroke-current shrink-0 h-6 w-6" fill="none"
                                                         viewBox="0 0 24 24">
                                                        <circle cx="12" cy="12" r="8" stroke="black" stroke-width="1"/>
                                                    </svg>
                                                    <span>{{ $result->question->{'choice_'.$i} }}</span>
                                                </label>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            @else
                                <span class="font-bold">Question: {{ $result->question->text }}</span>
                                <p>{{ $result->answer }}</p>
                            @endif
                        </div>
                        @if (!$loop->last)
                            <div class="divider"></div>
                        @endif
                    @empty
                    @endforelse
                </div>

                <div class="mt-5">
                    @if(\Illuminate\Support\Facades\Auth::user()->type == USER_TYPE_STUDENT)
                        <a href="{{ route('exams.index') }}">
                            <button class="btn" type="button">Back</button>
                        </a>
                    @else
                        <a href="{{ route('exams.results.index', [$exam]) }}">
                            <button class="btn" type="button">Back</button>
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
