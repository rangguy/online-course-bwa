<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('New Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden p-10 shadow-sm sm:rounded-lg">

                @if ($errors->any())
                    <div class="py-3 w-full rounded-3xl bg-red-500 text-white dark:bg-red-600">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <x-input-label for="name" :value="__('Name')" class="dark:text-gray-300" />
                        <x-text-input id="name"
                            class="block mt-1 w-full py-3 rounded-lg border-slate-300 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-200"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 dark:text-red-500" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="thumbnail" :value="__('Thumbnail')" class="dark:text-gray-300" />
                        <!-- Drag and Drop File Upload -->
                        <div class="relative border-2 border-gray-300 rounded-lg p-6 h-64 w-full flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-900 dark:border-gray-600"
                            id="dropzone">
                            <input type="file" class="absolute inset-0 w-full h-full opacity-0 z-50" id="thumbnail"
                                name="thumbnail" required autofocus/>
                            <div id="upload-content" class="text-center">
                                <img class="mx-auto h-12 w-12"
                                    src="https://www.svgrepo.com/show/357902/image-upload.svg" alt="Upload Icon">
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                    <label for="thumbnail" class="relative cursor-pointer">
                                        <span>Drag and drop</span>
                                        <span class="text-indigo-600 dark:text-indigo-400"> or browse</span>
                                        <span>to upload</span>
                                    </label>
                                </h3>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, JPEG</p>
                            </div>
                            <img src="" class="mt-4 mx-auto max-h-40 hidden" id="preview">
                            <p id="file-name" class="mt-2 text-sm text-gray-700 dark:text-gray-300 hidden"></p>
                        </div>
                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2 dark:text-red-500" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="path_trailer" :value="__('Path Trailer')" class="dark:text-gray-300" />
                        <x-text-input id="path_trailer"
                            class="block mt-1 w-full py-3 rounded-lg border-slate-300 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-200"
                            type="text" name="path_trailer" :value="old('path_trailer')" required autofocus
                            autocomplete="path_trailer" />
                        <x-input-error :messages="$errors->get('path_trailer')" class="mt-2 dark:text-red-500" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="category_id" :value="__('Category')" class="dark:text-gray-300" />
                        <select name="category_id" id="category_id"
                            class="py-3 rounded-lg pl-3 w-full border border-slate-300 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-200">
                            <option value="" class="dark:bg-gray-700 dark:text-gray-400">Choose category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" class="dark:bg-gray-900 dark:text-gray-200">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2 dark:text-red-500" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="about" :value="__('About')" class="dark:text-gray-300" />
                        <textarea name="about" id="about" cols="30" rows="5"
                            class="border border-slate-300 rounded-xl w-full dark:bg-gray-900 dark:border-gray-600 dark:text-gray-200">{{ old('about') }}</textarea>
                        <x-input-error :messages="$errors->get('about')" class="mt-2 dark:text-red-500" />
                    </div>

                    <hr class="my-5 dark:border-gray-600">

                    <div class="mt-">
                        <x-input-label for="keypoints" :value="__('Keypoints')" class="mb-2 dark:text-gray-300" />
                        <div class="flex flex-col gap-y-5">
                            @for ($i = 0; $i < 4; $i++)
                                <input type="text"
                                    class="py-3 rounded-lg border-slate-300 border dark:bg-gray-900 dark:border-gray-600 dark:text-gray-200"
                                    placeholder="Write your copywriting" name="course_keypoints[]"
                                    value="{{ old('course_keypoints.' . $i) }}" />
                            @endfor
                        </div>
                        <x-input-error :messages="$errors->get('course_keypoints')" class="mt-2 dark:text-red-500" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit"
                            class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full dark:bg-indigo-600">
                            Add New Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    var dropzone = document.getElementById('dropzone');
    var uploadContent = document.getElementById('upload-content');
    var preview = document.getElementById('preview');
    var fileNameDisplay = document.getElementById('file-name');
    var fileInput = document.getElementById('thumbnail');

    dropzone.addEventListener('dragover', e => {
        e.preventDefault();
        dropzone.classList.add('border-indigo-600', 'dark:border-indigo-400');
    });

    dropzone.addEventListener('dragleave', e => {
        e.preventDefault();
        dropzone.classList.remove('border-indigo-600', 'dark:border-indigo-400');
    });

    dropzone.addEventListener('drop', e => {
        e.preventDefault();
        dropzone.classList.remove('border-indigo-600', 'dark:border-indigo-400');
        var file = e.dataTransfer.files[0];
        fileInput.files = e.dataTransfer.files;
        displayPreview(file);
    });

    fileInput.addEventListener('change', e => {
        var file = e.target.files[0];
        if (file) {
            displayPreview(file);
        }
    });

    function displayPreview(file) {
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            uploadContent.classList.add('hidden');
            preview.src = reader.result;
            preview.classList.remove('hidden');
            fileNameDisplay.textContent = file.name;
            fileNameDisplay.classList.remove('hidden');
        };
    }
</script>
