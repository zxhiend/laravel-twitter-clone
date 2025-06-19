<!-- resources/views/components/button.blade.php -->
<button {{ $attributes->merge(['type' => 'button', 'class' => 'bg-sky-500 text-white border-none rounded-full px-5 py-1.5 font-bold text-sm cursor-pointer transition hover:bg-sky-600']) }}>
    {{ $slot }}
</button>
