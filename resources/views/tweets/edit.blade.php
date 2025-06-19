@extends('layouts.app')
@section('title', 'Edit Tweets')
@section('content')
    <div class="w-full max-w-xl mx-auto bg-white" x-data="editTweetData()">
        <!-- Header -->
        <div class="border-b border-gray-200">
            <div class="px-4 py-2 flex items-center">
                <a href="{{ url()->previous() }}" class="mr-3 text-gray-700 hover:text-sky-500 transition-colors">
                    <i class="fas fa-arrow-left fa-lg"></i>
                </a>
                <h5 class="font-bold text-lg mb-0">Edit Tweet</h5>
            </div>
        </div>


        <!-- Form Edit Tweet -->
        <div class="px-4 py-6">
            <form method="POST" action="{{ route('tweets.update', $tweet) }}" @submit="isSubmitting = true">
                @csrf
                @method('PUT')

                <div class="relative">
                    <textarea name="content"
                        class="w-full border border-gray-300 p-3 text-xl resize-none focus:ring-2 focus:ring-sky-500 focus:border-transparent placeholder-gray-400 rounded-lg transition-all"
                        rows="5" placeholder="What's happening?" required>{{ old('content', $tweet->content) }}</textarea>

                    @error('content')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-between items-center mt-6">
                    <button type="submit"
                        class="px-6 py-2 bg-yellow-500 text-white rounded-full cursor-pointer font-bold transition-all duration-200 flex items-center">
                        <span>Update Tweet</span>
                    </button>

                    <button type="button" @click="showDeleteModal = true"
                        class="px-6 py-2 border border-red-400 text-red-500 rounded-full hover:bg-red-500 hover:text-white transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        Delete Tweet
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click.self="showDeleteModal = false"
            class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">

            <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-300 delay-150"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">

                <div class="px-6 py-4 border-b border-gray-200">
                    <h5 class="font-bold text-lg text-gray-900">Delete Tweet</h5>
                </div>

                <div class="px-6 py-4">
                    <p class="text-gray-600">Are you sure you want to delete this tweet? This action cannot be undone.</p>
                </div>

                <div class="px-6 py-4 flex justify-end gap-3 border-t border-gray-200 bg-gray-50 rounded-b-lg">
                    <button type="button" @click="showDeleteModal = false" :disabled="isDeleting"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer disabled:opacity-50">
                        Cancel
                    </button>

                    <form action="{{ route('tweets.destroy', $tweet) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" :disabled="isDeleting"
                            :class="isDeleting ? 'bg-gray-400 cursor-not-allowed' : 'bg-red-500 hover:bg-red-600'"
                            class="px-4 py-2 text-white rounded-lg transition-all duration-200 flex items-center cursor-pointer">
                            <span x-show="!isDeleting">Delete</span>
                            <span x-show="isDeleting" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Deleting...
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editTweetData() {
            return {
                tweetContent: `{{ old('content', $tweet->content) }}`,
                characterCount: 0,
                isSubmitting: false,
                isDeleting: false,
                showDeleteModal: false,

                init() {
                    this.updateCharCount();
                },

                updateCharCount() {
                    this.characterCount = this.tweetContent.length;
                }
            }
        }
    </script>
@endsection
