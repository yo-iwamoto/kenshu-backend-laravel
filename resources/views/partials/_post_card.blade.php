<a href="{{ route('post.show', ['post' => $post['id']]) }}" class="block w-64">
    <div class="rounded-lg p-4 shadow-lg hover:shadow-md">
        <img
            class="h-20 w-20 mx-auto"
            src="{{ $post['thumbnail_post_image'] !== null ? $post['thumbnail_post_image']['image_url'] : '/img/no-img.jpeg' }}"
            alt="{{ htmlspecialchars($post['title']) }}"
        >
        <p class="font-bold text-lg mb-2">
            {{ htmlspecialchars($post['title']) }}
        </p>

        @if(count($post['tags']) !== 0)
            <div class="flex items-center flex-wrap gap-2 mb-2">
                @foreach($post['tags'] as $tag)
                        <span class="py-0.5 px-1.5 text-xs bg-gray-300 hover:bg-gray-200 transition-colors shadow-md rounded-lg">
                            {{ $tag['name'] }}
                        </span>
                @endforeach
            </div>
        @endif

        <div class="flex justify-between items-end">
            <p class="flex items-center">
                <img class="h-5 w-5 rounded-full mr-1" src="{{ $post['user']['profile_image_url'] }}" alt="{{ htmlspecialchars($post['user']['name']) }}">
                <span class="text-xs text-gray-600">
                    {{ htmlspecialchars($post['user']['name']) }}
                </span>
            </p>

            @auth
                @if($post['user']['id'] === Auth::user()->id)
                <form class="relative"
                    action="{{ route('post.destroy', ['post' => $post['id']]) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')

                    <button
                        aria-label="記事を削除する"
                        class="before:absolute before:-right-1/2 before:-top-12 before:text-sm before:hidden before:rounded-lg before:shadow-lg before:content-['削除'] before:text-white before:whitespace-nowrap before:p-2 before:bg-black before:opacity-60 hover:before:inline-block"
                        type="submit"
                    >
                        <img class="h-6 w-6" src="/img/trash.png">
                    </button>
                </form>
                @endif
            @endauth

        </div>
    </div>
</a>
