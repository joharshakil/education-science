<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Exams') }} / {{ $exam->name }} / {{ __('Questions') }}
            </h2>
            <a href="{{ route('exams.questions.create',[$exam->id]) }}">
                <button class="btn btn-primary">+ Add Question</button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg p-5">
                <table class="table table-compact w-full">
                    <thead>
                    <tr>
                        <th>Question</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($exam->questions as $question)
                        <tr>
                            <td>{{ $question->text }}</td>
                            <td>{{ $question->created_at }}</td>
                            <td class="flex">
                                <a href="{{route('exams.questions.edit', [$exam->id, $question->id])}}"
                                   class="block px-4 py-2 bg-sky-600 text-white font-bold">
                                    <span>Edit</span>
                                </a>
                                <form action="{{route('exams.questions.destroy',[$exam->id, $question->id])}}"
                                      method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="block px-4 py-2 w-full text-left bg-red-600 text-white font-bold"
                                            type="submit">Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No questions</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
