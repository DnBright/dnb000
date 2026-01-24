@props(['activeStep' => 1])

<div class="max-w-6xl mx-auto mb-16 reveal no-print" {{ $attributes }}>
    <div class="glass-card p-8 md:p-10 border-white/10 relative overflow-hidden group">
        <!-- Subtle background glow -->
        <div class="absolute -top-24 -left-24 w-48 h-48 bg-brand-cyan/5 blur-[80px] rounded-full group-hover:bg-brand-cyan/10 transition-colors"></div>
        
        <div class="relative z-10">
            <div class="flex items-center gap-4 mb-12">
                <div class="w-1.5 h-8 bg-brand-cyan shadow-[0_0_15px_rgba(34,211,238,0.5)]"></div>
                <div>
                    <h4 class="text-xs font-black text-white uppercase tracking-[0.4em]">{{ __('Ordering Workflow') }}</h4>
                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-1">{{ __('Synchronizing your creative vision through our streamlined protocol.') }}</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-y-12 gap-x-8">
                @php
                    $steps = [
                        ['id' => 1, 'label' => __('Select Service'), 'icon' => 'M4 6h16M4 12h16M4 18h7'],
                        ['id' => 2, 'label' => __('Fill Form'), 'icon' => 'M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z'],
                        ['id' => 3, 'label' => __('Payment'), 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                        ['id' => 4, 'label' => __('Contact Admin for Invoice'), 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                        ['id' => 5, 'label' => __('Wait for Order'), 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['id' => 6, 'label' => __('Receive Order'), 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4']
                    ];
                @endphp

                @foreach($steps as $step)
                <div class="relative flex flex-col gap-4 transition-all duration-500 {{ $activeStep < $step['id'] ? 'opacity-20' : ($activeStep == $step['id'] ? 'opacity-100' : 'opacity-40 hover:opacity-70') }}">
                    <div class="flex items-center justify-between">
                        <div class="text-[9px] font-black {{ $activeStep == $step['id'] ? 'text-brand-cyan' : 'text-slate-600' }} uppercase tracking-widest">{{ str_pad($step['id'], 2, '0', STR_PAD_LEFT) }}</div>
                        <div class="w-8 h-8 rounded-xl {{ $activeStep == $step['id'] ? 'bg-brand-cyan/20 text-brand-cyan border-brand-cyan/30' : 'bg-white/5 text-slate-600 border-white/5' }} border flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="text-[10px] font-black {{ $activeStep == $step['id'] ? 'text-white' : 'text-slate-500' }} uppercase tracking-widest leading-tight min-h-[30px]">
                        {{ $step['label'] }}
                    </div>

                    @if($activeStep == $step['id'])
                        <div class="h-0.5 w-full bg-brand-cyan shadow-[0_0_10px_rgba(34,211,238,0.5)] animate-pulse rounded-full"></div>
                    @else
                        <div class="h-0.5 w-full bg-white/5 rounded-full"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
