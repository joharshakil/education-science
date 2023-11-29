<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Exams') }}
            </h2>
            @if(\Illuminate\Support\Facades\Auth::user()->type !== USER_TYPE_STUDENT)
                <a href="{{ route('exams.create') }}">
                    <button class="btn btn-primary">+ Add Exam</button>
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg p-5">
                <table class="table table-compact w-full">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Questions</th>
                        <th>Published At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($exams as $exam)
                        <tr>
                            <td>{{ $exam->name }}</td>
                            <td>
                                @if($exam->type == EXAM_TYPE_QUIZ)
                                    MCQ's
                                @elseif($exam->type == EXAM_TYPE_SURVEY)
                                    Survey
                                @else
                                    Experiment
                                @endif
                            </td>
                            <td>{{ $exam->questions->count() }}</td>
                            <td>{{ $exam->published_at->toFormattedDateString() }}</td>
                            @if(\Illuminate\Support\Facades\Auth::user()->type == USER_TYPE_STUDENT)
                                <td class="flex">
                                    @if(!$exam->hasAttempted(Auth::user()))
                                        <a href="{{ route('exams.attempt', [$exam->id]) }}"
                                           class="block px-4 py-2 bg-green-600 text-white font-bold">
                                            <span>Attempt</span>
                                        </a>
                                    @else
                                        <a href="{{ route('exams.results.show', [$exam->id, \Illuminate\Support\Facades\Auth::user()]) }}"
                                           class="block px-4 py-2 bg-green-600 text-white font-bold">
                                            <span>Result</span>
                                        </a>
                                    @endif
                                </td>
                            @else
                                <td class="flex">
                                    <a href="{{ route('exams.results.index', [$exam->id]) }}"
                                       class="block px-4 py-2 bg-purple-600 text-white font-bold">
                                        <span>Results</span>
                                    </a>
                                    <a href="{{ route('exams.questions.index', [$exam->id]) }}"
                                       class="block px-4 py-2 bg-green-600 text-white font-bold">
                                        <span>Questions</span>
                                    </a>
                                    <a href="{{route('exams.edit', $exam->id)}}"
                                       class="block px-4 py-2 bg-sky-600 text-white font-bold">
                                        <span>Edit</span>
                                    </a>
                                    <form action="{{route('exams.destroy', $exam->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="block px-4 py-2 w-full text-left bg-red-600 text-white font-bold"
                                                type="submit">Delete
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No exams</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $exams->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
