<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ intval(\Illuminate\Support\Facades\Auth::user()->type) == USER_TYPE_ADMIN ? 'Users' : 'Students' }}
            </h2>
            <a href="{{ route('users.create') }}">
                <button class="btn btn-primary">+ Add {{ intval(\Illuminate\Support\Facades\Auth::user()->type) == USER_TYPE_ADMIN ? 'User' : 'Student' }}</button>
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
                        <th>Email</th>
                        <th>Username</th>
                        <th>Type</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>
                            <td>
                                @if(intval($user->type) == USER_TYPE_ADMIN)
                                    <div class="badge badge-primary font-bold">Administrator</div>
                                @elseif(intval($user->type) == USER_TYPE_TEACHER)
                                    <div class="badge badge-secondary font-bold text-white">Teacher</div>
                                @elseif(intval($user->type) == USER_TYPE_STUDENT)
                                    <div class="badge badge-accent font-bold text-gray">Student</div>
                                @endif
                            </td>
                            <td>{{ $user->created_at }}</td>
                            <td class="flex">
                                <a href="{{route('users.edit', [$user->id])}}"
                                   class="block px-4 py-2 bg-sky-600 text-white font-bold">
                                    <span>Edit</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No users</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
