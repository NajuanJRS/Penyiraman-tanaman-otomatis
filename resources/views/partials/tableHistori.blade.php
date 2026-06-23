@foreach ($perkembangan as $p)
    <x-ui.table-row>
        <x-ui.table-cell class="text-center font-medium text-muted-foreground">
            {{ $perkembangan->firstItem() + $loop->index }}
        </x-ui.table-cell>
        
        <x-ui.table-cell>
            <div class="flex flex-col">
                <span class="font-semibold text-foreground">{{ \Carbon\Carbon::parse($p->waktu)->format('d/m/Y') }}</span>
                <span class="text-xs text-muted-foreground">{{ \Carbon\Carbon::parse($p->waktu)->format('H:i:s') }}</span>
            </div>
        </x-ui.table-cell>
        
        <x-ui.table-cell>
            <x-ui.badge tone="neutral" variant="soft" class="gap-1.5 font-medium whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5 text-muted-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5S5 13 5 15a7 7 0 0 0 7 7z"/>
                </svg>
                {{ $p->kelembapan_tanah }}%
            </x-ui.badge>
        </x-ui.table-cell>
        
        <x-ui.table-cell>
            <x-ui.badge tone="info" variant="soft" class="gap-1.5 font-medium whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5 text-info/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242M12 12v9M8 17l4-4 4 4"/>
                </svg>
                {{ $p->kelembapan_udara }}%
            </x-ui.badge>
        </x-ui.table-cell>
        
        <x-ui.table-cell>
            <x-ui.badge tone="warning" variant="soft" class="gap-1.5 font-medium whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5 text-warning/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"/>
                </svg>
                {{ $p->suhu }}°C
            </x-ui.badge>
        </x-ui.table-cell>
        
        <x-ui.table-cell class="text-center">
            @if ($p->gambar)
                <div class="inline-flex justify-center w-full">
                    <button type="button" 
                            class="relative size-10 rounded-md border border-input overflow-hidden bg-muted/20 hover:ring-2 hover:ring-primary/50 transition-all focus:outline-none focus:ring-2 focus:ring-primary"
                            onclick="showImage('/storage/{{ $p->gambar }}')"
                            title="Lihat Gambar">
                        <img src="/storage/{{ $p->gambar }}" alt="Thumbnail" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/0 hover:bg-black/10 transition-colors"></div>
                    </button>
                </div>
            @else
                <div class="inline-flex justify-center w-full">
                    <div class="inline-flex items-center justify-center size-10 rounded-md border border-dashed border-muted-foreground/30 bg-muted/10 text-muted-foreground/40" title="Tidak ada gambar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" x2="2" y1="2" y2="22"/><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                        </svg>
                    </div>
                </div>
            @endif
        </x-ui.table-cell>
        
        <x-ui.table-cell>
            @if ($p->prediksi && $p->prediksi->decision == 'Siram')
                <x-ui.badge tone="success" class="gap-1.5 whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2C6.48 2 2 9 2 13a10 10 0 0020 0C22 9 17.52 2 12 2z"/>
                    </svg>
                    Siram
                </x-ui.badge>
            @else
                <x-ui.badge tone="neutral" variant="outline" class="gap-1.5 text-muted-foreground whitespace-nowrap bg-background">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    Tidak Siram
                </x-ui.badge>
            @endif
        </x-ui.table-cell>
        
        <x-ui.table-cell class="text-right">
            <x-ui.button variant="ghost" size="sm" href="{{ route('histori.edit', $p->id_perkembangan) }}" class="size-8 p-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/>
                </svg>
                <span class="sr-only">Edit</span>
            </x-ui.button>
        </x-ui.table-cell>
    </x-ui.table-row>
@endforeach
