<div class="px-6 py-4 border-t border-gray-100 bg-white/50 backdrop-blur-sm">
    <div class="flex items-center gap-3 mb-3">
        {{-- Avatar User --}}
        <div class="w-8 h-8 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 font-bold text-xs">
            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-900 truncate">
                {{ auth()->user()->name ?? 'Admin' }}
            </p>
            <p class="text-xs text-gray-500 truncate">
                {{ auth()->user()->email ?? '' }}
            </p>
        </div>
    </div>

    {{-- Tombol Logout --}}
    <form action="{{ filament()->getLogoutUrl() }}" method="post" class="w-full">
        @csrf
        <button type="submit" 
            class="group flex w-full items-center justify-center gap-2 rounded-lg bg-red-50 px-3 py-2 text-sm font-medium text-red-600 transition-all hover:bg-red-500 hover:text-white hover:shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            Keluar
        </button>
    </form>
</div>