<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Groups') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg p-5">
                <form action="{{ route('groups.store') }}" method="POST">
                    @csrf

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Name</span>
                        </label>
                        <input type="text" name="name" required="required"
                               placeholder="Type name here" class="input input-bordered w-full"/>
                    </div>

                    <div class="mt-5">
                        <a href="{{ route('groups.index') }}">
                            <button class="btn" type="button">Cancel</button>
                        </a>
                        <button class="btn btn-primary">Add Group</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
