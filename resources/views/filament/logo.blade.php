<div class="flex flex-col items-center justify-center">
    @if ($logoPath)
        <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo" class="h-28" style="height: 7rem;" />
    @endif
    @if ($appName)
        <div class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">
            {{ $appName }}
        </div>
    @endif
</div>
