<x-admin-layout>
    <x-slot name="title">
        Create New Artist
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Create New Artist</h1>
            <p class="mt-1 text-sm text-gray-600">
                Fill in the information below to create a new artist.
            </p>
        </div>

        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <form action="{{ route('admin.artists.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @include('admin.artists.form')

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route('admin.artists.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create Artist</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout> 