<x-app-layout>
    <x-slot:title>
        Admin Dashboard
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-bold mb-4">Create New Article</h3>
                
                <form action="{{ route('articles.store') }}" method="POST" id="article-form">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Title</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Content</label>
                        <input type="hidden" name="content" id="content">
                        
                        <div id="editor" style="height: 200px;"></div>
                    </div>

                    <button type="submit" style="background-color: #16a34a !important; color: white !important; display: block !important; padding: 10px 20px; border-radius: 5px; margin-top: 10px;">
                        Publish Article
                    </button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-6">Manage Existing Articles</h3>

                    <ul class="space-y-4">
                        @foreach($articles as $article)
                            <li class="flex justify-between items-center p-4 border rounded shadow-sm">
                                <div>
                                    <h4 class="font-bold text-lg">{{ $article->title }}</h4>
                                    <p class="text-sm text-gray-500">Posted: {{ \Carbon\Carbon::parse($article->created_at)->format('M d, Y') }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('articles.edit', $article->id) }}" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Edit</a>
                                    
                                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.js"></script>
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        const form = document.querySelector('#article-form');
        form.onsubmit = function() {
            document.querySelector('#content').value = quill.root.innerHTML;
        };
    </script>
</x-app-layout>