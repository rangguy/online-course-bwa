<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden p-10 shadow-sm sm:rounded-lg">

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="py-3 w-full rounded-3xl bg-red-500 dark:bg-red-700 text-white">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif

                <form method="POST" action="{{ route('admin.categories.update', $category) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="name" :value="__('Name')" class="dark:text-gray-200" />
                        <x-text-input value="{{ $category->name }}" id="name"
                            class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-200" type="text" name="name"
                            required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 dark:text-red-400" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="icon" :value="__('Icon')" class="dark:text-gray-200" />
                        <img src="{{ Storage::url($category->icon) }}" alt=""
                            class="rounded-2xl object-cover w-[90px] h-[90px]">
                        <x-text-input id="icon" class="block mt-1 w-full dark:bg-gray-700 dark:text-gray-200"
                            type="file" name="icon" autofocus autocomplete="icon" />
                        <x-input-error :messages="$errors->get('icon')" class="mt-2 dark:text-red-400" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit"
                            class="font-bold py-4 px-6 bg-indigo-700 dark:bg-indigo-500 text-white dark:text-gray-900 rounded-full">
                            Update Category
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
