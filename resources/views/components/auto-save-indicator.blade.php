{{-- Auto-save indicator component --}}
{{-- Shows "Progress saved" badge after form submission --}}
@props(['show' => false, 'message' => 'Progress saved'])

<div
    x-data="{ visible: {{ $show ? 'true' : 'false' }} }"
    x-show="visible"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-init="if(visible) { setTimeout(() => visible = false, 3000) }"
    class="fixed bottom-4 right-4 z-50"
>
    <div class="flex items-center px-4 py-3 bg-green-600 text-white rounded-lg shadow-lg">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="text-sm font-medium">{{ $message }}</span>
    </div>
</div>
