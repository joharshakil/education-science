<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Groups') }}
            </h2>
            <a href="{{ route('groups.create') }}">
                <button class="btn btn-primary">+ Add Group</button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg p-5">
                <table class="table table-compact w-full">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($groups as $group)
                        <tr>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->created_at }}</td>
                            <td class="flex">
                                <a href="{{route('groups.students.index', [$group->id])}}"
                                   class="block px-4 py-2 bg-green-600 text-white font-bold">
                                    <span>Students</span>
                                </a>
                                <a href="{{route('groups.edit', [$group->id])}}"
                                   class="block px-4 py-2 bg-sky-600 text-white font-bold">
                                    <span>Edit</span>
                                </a>
                                <form action="{{route('groups.destroy',[$group->id])}}" method="post">
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
                            <td colspan="3" class="text-center">No groups</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $groups->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
