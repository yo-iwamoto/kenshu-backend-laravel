@extends('partials._layout')

@section('content')
    <div class="mt-10 mx-8">
        <div class="max-w-5xl mx-auto">
            <div class="mb-6">
                <a href="/" class="hover:underline text-teal-800">
                    &lt; 記事一覧画面に戻る
                </a>
            </div>

            <h1 class="font-bold text-3xl mb-4">
                {{ $post['title'] }}
            </h1>

            <div class="flex justify-between items-end">
                <div>
                    <p class="flex items-center mb-1">
                        <img class="h-5 w-5 rounded-full mr-1"
                            src="{{ $post['user']['profile_image_url'] }}"
                            alt="{{ $post['user']['name'] }}">
                        <span class="text-gray-600 text-sm">
                            {{ $post['user']['name'] }}
                        </span>
                    </p>
                    <p class="text-sm">
                        <span>作成日時: </span>
                        <span>{{ $post['created_at'] }}</span>
                    </p>
                </div>

                @auth
                    @if($post['user']['id'] === Auth::user()->id)
                        <div class="flex items-start gap-4">
                            <form
                                class="relative"
                                action="{{ route('post.destroy', ['post' => $post['id']]) }}"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    aria-label="削除する"
                                    class="before:absolute before:-right-0.5 before:-top-12 before:text-sm before:hidden before:rounded-lg before:shadow-lg before:content-['削除'] before:text-white before:whitespace-nowrap before:p-2 before:bg-black before:opacity-60 hover:before:inline-block"
                                    type="submit"
                                >
                                    <img class="h-10 w-10" src="/img/trash.png">
                                </button>
                            </form>

                            <span class="relative">
                                <a
                                    aria-label="編集する"
                                    class="before:absolute before:-right-0.5 before:-top-12 before:text-sm before:hidden before:rounded-lg before:shadow-lg before:content-['編集'] before:text-white before:whitespace-nowrap before:p-2 before:bg-black before:opacity-60 hover:before:inline-block"
                                    href="#"
                                >
                                    <img class="h-10 w-10" src="/img/edit.png">
                                </a>
                            </span>
                        </div>
                    @endif
                @endauth
            </div>

            <hr class="mt-4 pb-10">

            <p>
                {{ nl2br(htmlspecialchars($post['content'])) }}
            </p>
        </div>
    </div>
@endsection
