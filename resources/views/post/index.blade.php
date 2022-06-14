@extends('partials._layout')

@section('content')
    <div class="mt-10 mx-4">
        <div class="max-w-5xl mx-auto">
            <section class="mb-12">
                <div class="flex justify-between items-center">
                    <h1 class="mb-4 text-lg">記事投稿</h1>
                    <button id="js-toggle-button" class="transition-transform">
                        <img src="/img/arrow.png">
                    </button>
                </div>
                <div id="js-toggle-body" class="overflow-hidden origin-top">
                    <form id="post" class="flex flex-col h-auto gap-8" action={{ route('post.store') }} method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div>
                            <label for="title"
                                class="font-bold before:content-['*'] before:text-red-500 before:pr-1">タイトル<small
                                    class="pl-2">(最大100文字)</small></label>
                            <input id="title" aria-labelledby="post title" type="text" name="title" placeholder=""
                                class="border-gray-400 w-full shadow-lg border rounded-lg bg-light-800 p-2" required
                                aria-required="true">
                        </div>

                        <div>
                            <label for="content"
                                class="font-bold before:content-['*'] before:text-red-500 before:pr-1">本文</label>
                            <textarea id="content" aria-labelledby="post content" name="content" placeholder="" rows="6"
                                class="border-gray-400 w-full shadow-lg border rounded-lg bg-light-800 p-2" required
                                aria-required="true"></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="rounded-lg w-16 text-white bg-teal-600 hover:bg-teal-500 transition-colors py-2 text-sm font-bold">投稿</button>
                        </div>
                    </form>
                </div>
            </section>

            <hr class="mb-6">

            <section class="mb-20">
                <h1 class="mb-8 text-lg">記事一覧</h1>
                <div class="flex justify-around flex-wrap flex-grow gap-8">

                    @if(count($posts) === 0)

                    <div class="text-center">
                        <p>まだ記事がないようです…🤔</p>
                        <p>上のフォームから何か書いてみましょう</p>
                    </div>

                    @else

                    @each('partials._post_card', $posts, 'post')

                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
