<x-slot name="header">
    <h2 class="font-semibold text-xl">Éditer : {{ $post->title }}</h2>
    @if($post->status === 'published')
        <a class="text-sm underline text-indigo-600"
           href="{{ route('posts.public.show', $post->slug) }}" target="_blank" rel="noopener">
           Voir en public ↗
        </a>
    @endif
</x-slot>