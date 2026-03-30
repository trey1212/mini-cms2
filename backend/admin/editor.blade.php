<x-app-layout>
    <x-slot:title>
        Edit Article
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Article') }}
        </h2>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-bold mb-4">Editing: {{ $article->title }}</h3>
                
                <form action="/admin/articles/{{ $article->id }}" method="POST" id="edit-article-form">
                    @csrf
                    @method('PUT') <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Title</label>
                        <input type="text" name="title" value="{{ $article->title }}" class="w-full border-gray-300 rounded shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Content</label>
                        <input type="hidden" name="content" id="content">
                        
                        <div id="editor" style="height: 300px;">{!! $article->content !!}</div>
                    </div>

                    <button type="submit" style="background-color: #16a34a !important; color: white !important; display: block !important; padding: 10px 20px; border-radius: 5px; margin-top: 10px;">
                        Save Changes
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.js"></script>
    <script>
        // Initialize the Quill editor
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        // Sync Quill's HTML content to the hidden input right before the form submits
        const form = document.querySelector('#edit-article-form');
        form.onsubmit = function() {
            document.querySelector('#content').value = quill.root.innerHTML;
        };
    </script>
</x-app-layout>