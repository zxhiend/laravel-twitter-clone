@props(['tweet', 'action' => true])

<div class="flex flex-col border-b border-gray-200 px-5 py-4 hover:bg-gray-50 transition" x-data="tweetComponent()">
    @if ($tweet->retweeted_by)
        <div class="text-gray-500 text-xs mb-1 flex items-center">
            <svg viewBox="0 -960 960 960" fill="currentColor" class="w-4 h-4 mr-1">
                <path
                    d="M280-80 120-240l160-160 56 58-62 62h406v-160h80v240H274l62 62-56 58Zm-80-440v-240h486l-62-62 56-58 160 160-160 160-56-58 62-62H280v160h-80Z" />
            </svg>
            Retweeted by <span class="font-semibold ml-1">{{ $tweet->retweeted_by }}</span>
        </div>
    @endif
    @if ($tweet->parentTweet)
        <div class="mb-4 p-3 bg-gray-50 border border-gray-200 rounded-lg">
            <div class="flex items-center mb-2">
                <a href="{{ route('profile', ['username' => $tweet->parentTweet->user->username]) }}">
                    <img src="{{ $tweet->parentTweet->user->avatar_url }}"
                        class="w-8 h-8 rounded-full object-cover mr-3" alt="{{ $tweet->parentTweet->user->username }}">
                </a>
                <div class="flex-1">
                    <span class="font-semibold text-sm mr-1">{{ $tweet->parentTweet->user->name }}</span>
                    <span class="text-gray-500 text-sm mr-1">{{ '@' . $tweet->parentTweet->user->username }}</span>
                    <span class="text-gray-500 text-xs">·
                        {{ \Carbon\Carbon::parse($tweet->parentTweet->created_at)->diffForHumans() }}</span>
                </div>
            </div>
            <div class="text-sm text-gray-700 whitespace-pre-line">{{ $tweet->parentTweet->content }}</div>

            <div class="flex items-center mt-2 text-gray-500 text-xs">
                <svg viewBox="0 -960 960 960" fill='currentColor' class="w-3 h-3 mr-1">
                    <path
                        d="M280-80 120-240l160-160 56 58-62 62h406v-160h80v240H274l62 62-56 58Zm-80-440v-240h486l-62-62 56-58 160 160-160 160-56-58 62-62H280v160h-80Z" />
                </svg>
                <span>Replying to {{ '@' . $tweet->parentTweet->user->username }}</span>
            </div>
        </div>
    @endif

    <div class="flex items-center mb-1">
        <a href="{{ route('profile', ['username' => $tweet->user->username]) }}"
            class="flex items-center flex-grow no-underline text-inherit">
            <img src="{{ $tweet->user->avatar_url }}" class="w-12 h-12 rounded-full object-cover mr-3"
                alt="{{ $tweet->user->username }}">
            <div class="flex-1">
                <span class="font-bold mr-1">{{ $tweet->user->name }}</span>
                <span class="text-gray-400 mr-1">{{ '@' . $tweet->user->username }}</span>
                <span class="text-gray-400 text-xs">·
                    {{ \Carbon\Carbon::parse($tweet->created_at)->diffForHumans() }}</span>
            </div>
        </a>

        @auth
            @if (auth()->id() !== $tweet->user->id)
                <form action="{{ route(auth()->user()->isFollowing($tweet->user) ? 'unfollow' : 'follow', $tweet->user) }}"
                    method="POST">
                    @csrf
                    @if (auth()->user()->isFollowing($tweet->user))
                        @method('DELETE')
                    @endif
                    <x-button type="submit"
                        class="px-4 py-1 rounded-full font-bold text-sm transition {{ auth()->user()->isFollowing($tweet->user) ? 'bg-white text-sky-500 border border-sky-500 hover:bg-sky-50' : 'bg-sky-500 text-white hover:bg-sky-600' }}">
                        {{ auth()->user()->isFollowing($tweet->user) ? 'Following' : 'Follow' }}
                    </x-button>
                </form>
            @elseif($action)
                <a href="{{ route('tweets.edit', $tweet) }}"
                    class="hover:bg-sky-50 text-yellow-400 hover:text-orange-500 rounded-full p-2 transition">
                    <svg viewBox="0 -960 960 960" fill='currentColor' class="w-5 h-5">
                        <path
                            d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                    </svg>
                </a>
                <button @click="showDeleteModal = true" class="hover:bg-red-50 text-red-500 rounded-full p-2 transition">
                    <svg viewBox="0 -960 960 960" fill='currentColor' class="w-5 h-5">
                        <path
                            d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                    </svg>
                </button>
            @endif
        @endauth
    </div>

    <div class="text-base text-gray-800 whitespace-pre-line my-2">{{ $tweet->content }}</div>

    @auth
        <div class="flex justify-between gap-2 mt-2 text-gray-400 text-sm">
            <!-- Comment Button -->
            <button @click="showCommentModal = true"
                class="flex hover:bg-sky-50 hover:text-sky-500 rounded-full p-2 transition">
                <svg viewBox="0 -960 960 960" fill='currentColor' class="w-5 h-5">
                    <path
                        d="M240-400h480v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM880-80 720-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v720ZM160-320h594l46 45v-525H160v480Zm0 0v-480 480Z" />
                </svg>
                <span class="ml-1 text-xs">{{ $tweet->replies->count() ? $tweet->replies->count() : '' }}</span>
            </button>

            <!-- Like Button -->
            <form action="{{ route('tweets.like', $tweet) }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                    class="flex items-center hover:bg-red-50 hover:text-red-500 rounded-full p-2 transition {{ $tweet->isLikedBy(auth()->user()) ? 'text-red-500' : '' }}">
                    <svg viewBox="0 -960 960 960" fill='currentColor' class="w-5 h-5">
                        <path
                            d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z" />
                    </svg>
                    <span class="ml-1 text-xs">{{ $tweet->likes->count() ? $tweet->likes->count() : '' }}</span>
                </button>
            </form>

            <!-- Retweet Button -->
            <form action="{{ route('tweets.retweet', $tweet) }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                    class="flex items-center hover:bg-green-50 hover:text-green-500 rounded-full p-2 transition {{ $tweet->isRetweetedBy(auth()->user()) ? 'text-green-500' : '' }}">
                    <svg viewBox="0 -960 960 960" fill='currentColor' class="w-5 h-5">
                        <path
                            d="M280-80 120-240l160-160 56 58-62 62h406v-160h80v240H274l62 62-56 58Zm-80-440v-240h486l-62-62 56-58 160 160-160 160-56-58 62-62H280v160h-80Z" />
                    </svg>
                    <span class="ml-1 text-xs">{{ $tweet->retweets->count() ? $tweet->retweets->count() : '' }}</span>
                </button>
            </form>

            <!-- Bookmark Button -->
            <form action="{{ route('tweets.bookmark', $tweet) }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                    class="flex items-center hover:bg-blue-50 hover:text-blue-500 rounded-full p-2 transition {{ $tweet->isBookmarkedBy(auth()->user()) ? 'text-blue-500' : '' }}">
                    <svg viewBox="0 -960 960 960" fill='currentColor' class="w-5 h-5">
                        <path
                            d="M200-120v-640q0-33 23.5-56.5T280-840h400q33 0 56.5 23.5T760-760v640L480-240 200-120Zm80-125 200-86 200 86v-515H280v515Zm0-515h400-400Z" />
                    </svg>
                    <span class="ml-1 text-xs">{{ $tweet->bookmarks->count() ? $tweet->bookmarks->count() : '' }}</span>
                </button>
            </form>
        </div>
    @endauth

    <!-- Comment Modal -->
    <div x-show="showCommentModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click.self="showCommentModal = false"
        @keydown.escape="showCommentModal = false"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center p-4">

        <div x-show="showCommentModal" x-transition:enter="transition ease-out duration-300 delay-150"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95" class="bg-white rounded-lg shadow-xl w-full max-w-lg">

            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Reply to Tweet</h3>
                <button @click="showCommentModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Original Tweet Preview -->
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center mb-2">
                    <img src="{{ $tweet->user->avatar_url }}" class="w-8 h-8 rounded-full object-cover mr-2"
                        alt="{{ $tweet->user->username }}">
                    <span class="font-semibold text-sm">{{ $tweet->user->name }}</span>
                    <span class="text-gray-500 text-sm ml-1">{{ '@' . $tweet->user->username }}</span>
                </div>
                <p class="text-sm text-gray-700">{{ Str::limit($tweet->content, 100) }}</p>
            </div>

            <!-- Reply Form -->
            <form action="{{ route('tweets.reply.store', $tweet) }}" method="POST" class="p-6">
                @csrf
                <div class="mb-4">
                    <label for="content" class="sr-only">Your reply</label>
                    <textarea name="content" id="content" rows="4" @input="replyCharCount = $event.target.value.length"
                        :disabled="isSubmitting"
                        class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-lg shadow-sm resize-none focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all"
                        placeholder="Tweet your reply..." required></textarea>

                    <!-- Character counter -->
                    <div class="flex justify-between items-center mt-2">
                        <div class="text-sm" :class="replyCharCount > 280 ? 'text-red-500' : 'text-gray-400'">
                            <span x-text="replyCharCount"></span>/280
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" @click="showCommentModal = false" :disabled="isSubmitting"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors disabled:opacity-50">
                        Cancel
                    </button>
                    <button type="submit" :disabled="isSubmitting || replyCharCount > 280 || replyCharCount === 0"
                        :class="isSubmitting || replyCharCount > 280 || replyCharCount === 0 ?
                            'bg-gray-400 cursor-not-allowed' : 'bg-sky-500 hover:bg-sky-600'"
                        class="px-6 py-2 text-white rounded-lg font-medium transition-all duration-200 flex items-center">
                        <span x-show="!isSubmitting">Reply</span>
                        <span x-show="isSubmitting" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Replying...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal (for tweet owner) -->
    @if (auth()->id() === $tweet->user->id)
        <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click.self="showDeleteModal = false"
            @keydown.escape="showDeleteModal = false"
            class="fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center p-4">

            <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-300 delay-150"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="bg-white rounded-lg shadow-xl w-full max-w-md">

                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Delete Tweet</h3>
                </div>

                <div class="px-6 py-4">
                    <p class="text-gray-600">Are you sure you want to delete this tweet? This action cannot be undone.
                    </p>
                </div>

                <div class="px-6 py-4 flex justify-end gap-3 border-t border-gray-200 bg-gray-50 rounded-b-lg">
                    <button type="button" @click="showDeleteModal = false" :disabled="isDeleting"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors disabled:opacity-50">
                        Cancel
                    </button>

                    <form action="{{ route('tweets.destroy', $tweet) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" @click="isDeleting = true" :disabled="isDeleting"
                            :class="isDeleting ? 'bg-gray-400 cursor-not-allowed' : 'bg-red-500 hover:bg-red-600'"
                            class="px-4 py-2 text-white rounded-lg transition-all duration-200 flex items-center">
                            <span x-show="!isDeleting">Delete</span>
                            <span x-show="isDeleting" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
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
    @endif
</div>

<script>
    function tweetComponent() {
        return {
            showCommentModal: false,
            showDeleteModal: false,
            isSubmitting: false,
            isDeleting: false,
            replyCharCount: 0,

            init() {
                // Focus textarea when modal opens
                this.$watch('showCommentModal', (value) => {
                    if (value) {
                        this.$nextTick(() => {
                            this.$refs.replyTextarea?.focus();
                        });
                    }
                });
            }
        }
    }
</script>
