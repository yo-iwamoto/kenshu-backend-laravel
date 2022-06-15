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
                    <form id="post" class="flex flex-col h-auto gap-8" action={{ route('post.store') }} method="POST" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <label for="title"
                                class="font-bold before:content-['*'] before:text-red-500 before:pr-1">タイトル<small
                                    class="pl-2">(最大100文字)</small></label>
                            <input id="title" aria-labelledby="post title" type="text" name="title" placeholder=""
                                class="border-gray-400 w-full shadow-lg border rounded-lg bg-light-800 p-2" required
                                aria-required="true">
                            @error('title')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="content"
                                class="font-bold before:content-['*'] before:text-red-500 before:pr-1">本文</label>
                            <textarea id="content" aria-labelledby="post content" name="content" placeholder="" rows="6"
                                class="border-gray-400 w-full shadow-lg border rounded-lg bg-light-800 p-2" required
                                aria-required="true"></textarea>
                            @error('content')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="inline-block relative w-full">
                            <label class="block" for="tags">
                                <span class="font-bold">タグ</span>
                                <small class="pl-2 font-bold">(任意, 複数選択可)</small>
                            </label>
                            <select
                                id="tags"
                                aria-labelledby="post tags"
                                name="tags[]"
                                class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded-lg shadow-lg leading-tight focus:outline-none focus:shadow-outline"
                                multiple
                            >
                                @foreach($tags as $tag)
                                    <option value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('tags')
                        @enderror

                        {{-- 画像フォーム ~~ --}}

                        <div class="flex flex-col">
                            <label class="font-bold" for="images" class="block">
                                <span>添付画像</span>
                                <small class="pl-2">(複数選択可・png, jpg, gif 形式のファイルを指定してください)</small>
                            </label>
                            <input
                                id="images"
                                aria-describedby="post images"
                                type="file"
                                accept="image/*"
                                name="images[]"
                                multiple
                            >
                            @error('images[]')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <input id="thumbnail_image_index" type="hidden" class="-mb-8" name="thumbnail_image_index">

                        <div id="js-preview-container" class="-mb-4 flex gap-2"></div>

                        {{-- ~~ 画像フォーム --}}

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
