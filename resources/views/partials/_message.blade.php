@if(session('message') !== null)
    <div class="mx-4 mt-12">
        <p class="p-2 rounded-lg bg-red-200 text-sm text-center max-w-2xl mx-auto">{{ session('message') }}</p>
    </div>
@endif
