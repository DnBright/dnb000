@extends('layouts.main')

@section('content')

<main class="relative min-h-screen py-20 overflow-hidden">
    <!-- Immersive Background Elements -->
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-purple-500/5 blur-[120px] rounded-full animate-blob-float"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-brand-cyan/5 blur-[120px] rounded-full animate-blob-float" style="animation-delay: -5s;"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <!-- HEADER -->
        <div class="max-w-5xl mx-auto mb-12 reveal">
            <div class="inline-flex px-4 py-1.5 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-400 text-[10px] font-bold uppercase tracking-[0.3em] mb-6">
                {{ __('Refinement Phase') }}
            </div>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="text-4xl md:text-5xl font-black text-white leading-tight uppercase tracking-tight">
                        Protocol <span class="animate-text-shimmer">Revision.</span>
                    </h1>
                    <p class="text-slate-500 mt-4 font-bold uppercase text-xs tracking-widest">{{ __('Request adjustments for Order ID') }} <span class="text-white">#{{ $order->order_id }}</span></p>
                </div>
                <a href="{{ route('user.orders') }}" class="btn-secondary !py-3 !px-6 text-[10px] uppercase tracking-widest font-black flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    {{ __('Back to Registry') }}
                </a>
            </div>
        </div>

        <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- CHAT INTERFACE --}}
            <div class="lg:col-span-2 space-y-8 reveal" style="transition-delay: 100ms;">
                <div class="glass-card flex flex-col h-[600px] relative overflow-hidden shadow-2xl border-white/5">
                    <div class="p-6 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
                        <h3 class="text-xs font-black text-white uppercase tracking-widest">{{ __('Direct Communication Channel') }}</h3>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">{{ __('System Online') }}</span>
                        </div>
                    </div>

                    <div id="userChatContainer" class="flex-1 overflow-y-auto p-6 space-y-6 scrollbar-thin scrollbar-thumb-white/10 scrollbar-track-transparent">
                        <div id="userChatMessages" class="space-y-6">
                            {{-- Messages injected via JS --}}
                            <div class="text-center py-10">
                                <div class="inline-block px-4 py-2 rounded-full bg-white/5 text-[10px] text-slate-500 font-bold uppercase tracking-widest animate-pulse">{{ __('Establishing Secure Connection...') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-white/[0.02] border-t border-white/5">
                        <form id="userChatForm" class="flex items-end gap-3" enctype="multipart/form-data">
                            <label class="p-3 rounded-xl bg-white/5 border border-white/10 text-slate-400 hover:text-white hover:bg-white/10 cursor-pointer transition-all shrink-0" title="Attach File">
                                <input type="file" name="attachment" id="userChatAttachment" class="hidden">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                            </label>
                            <div class="flex-1 relative">
                                <input type="text" name="message" id="userChatMessage" placeholder="TRANSMIT MESSAGE..." class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3.5 text-xs font-bold text-white placeholder-slate-600 focus:outline-none focus:border-brand-cyan/50 focus:bg-black/40 transition-all uppercase tracking-wide">
                            </div>
                            <button type="submit" class="p-3.5 rounded-xl bg-brand-cyan text-black hover:bg-white transition-all transform hover:scale-105 shadow-[0_0_20px_rgba(6,246,255,0.3)] disabled:opacity-50 disabled:cursor-not-allowed shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- REVISION FORM & HISTORY --}}
            <div class="space-y-8 reveal" style="transition-delay: 200ms;">
                {{-- Submit Revision Card --}}
                <div class="glass-card p-8 border-white/5 relative overflow-hidden group hover:border-brand-violet/30 transition-all duration-500">
                    <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-24 h-24 text-brand-violet" fill="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>

                    <h3 class="text-xs font-black text-white uppercase tracking-widest mb-6 border-b border-white/5 pb-4">{{ __('Submit Formal Revision') }}</h3>
                    
                    <form action="{{ route('user.orders.revision.submit', $order->order_id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-2">{{ __('Usage Notes') }}</label>
                            <textarea name="notes" rows="4" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-xs font-bold text-white placeholder-slate-600 focus:outline-none focus:border-brand-violet/50 focus:bg-black/40 transition-all" placeholder="DESCRIBE REQUIRED CHANGES..."></textarea>
                            @error('notes') <div class="text-[9px] text-red-500 font-bold mt-1 uppercase">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-2">{{ __('Reference Data (Optional)') }}</label>
                            <input type="file" name="attachment" class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-[10px] text-slate-400 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[9px] file:font-black file:bg-white/10 file:text-white hover:file:bg-brand-violet transition-all uppercase">
                            @error('attachment') <div class="text-[9px] text-red-500 font-bold mt-1 uppercase">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="w-full btn-primary !py-4 text-xs tracking-[0.2em] font-black uppercase flex items-center justify-center gap-2 group/btn">
                            {{ __('Transmit Revision') }}
                            <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </form>
                </div>

                {{-- Previous Revisions List --}}
                @if(!empty($revisions) && count($revisions) > 0)
                <div class="glass-card p-6 border-white/5">
                    <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">{{ __('Revision Log') }}</h3>
                    <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-white/10">
                        @foreach(array_reverse($revisions) as $r)
                        <div class="p-4 rounded-xl bg-white/5 border border-white/5 hover:border-white/10 transition-colors">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[9px] font-black text-brand-violet uppercase tracking-widest">{{ $r['created_at'] ?? 'UNK' }}</span>
                                <span class="text-[9px] text-slate-600 font-bold uppercase">{{ __('REQ DATA') }}</span>
                            </div>
                            <p class="text-xs text-slate-300 font-bold leading-relaxed mb-2">{{ $r['notes'] ?? '' }}</p>
                            @if(!empty($r['attachment']))
                                <a href="{{ asset('storage/' . $r['attachment']) }}" target="_blank" class="inline-flex items-center gap-1 text-[9px] font-black text-brand-cyan hover:underline uppercase tracking-wider">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    {{ __('View Attachment') }}
                                </a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</main>

@endsection

@push('scripts')
<script>
    (function(){
        const fetchUrl = "{{ route('user.orders.chat.fetch', $order->order_id) }}";
        const sendUrl = "{{ route('user.orders.chat.send', $order->order_id) }}";
        const chatMessages = document.getElementById('userChatMessages');
        const chatContainer = document.getElementById('userChatContainer');
        const fileInput = document.getElementById('userChatAttachment');

        function esc(s){ return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

        // Update file input style on change
        fileInput.addEventListener('change', function(){
            const parent = this.parentElement;
            if(this.files.length > 0) {
                parent.classList.add('bg-brand-cyan', '!text-black', '!border-brand-cyan');
                parent.classList.remove('bg-white/5', 'text-slate-400');
            } else {
                parent.classList.remove('bg-brand-cyan', '!text-black', '!border-brand-cyan');
                parent.classList.add('bg-white/5', 'text-slate-400');
            }
        });

        function render(chats){
            if(!chatMessages) return;
            if(!chats || chats.length===0){ 
                chatMessages.innerHTML = '<div class="flex flex-col items-center justify-center h-full opacity-30"><div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center mb-4"><svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg></div><p class="text-[10px] uppercase font-black tracking-[0.2em]">Channel Quiet</p></div>'; 
                return; 
            }
            
            chatMessages.innerHTML = '';
            
            // Group messages by date could be added here, simplified for now
            chats.forEach(function(m){
                const isAdmin = m.sender === 'admin';
                const senderName = isAdmin ? 'SYSTEM' : 'CLIENT';
                const time = m.created_at ? new Date(m.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '';
                
                const alignClass = isAdmin ? 'items-start' : 'items-end';
                const bubbleClass = isAdmin 
                    ? 'bg-white/10 rounded-2xl rounded-tl-none border border-white/5 text-slate-300' 
                    : 'bg-brand-cyan/20 text-brand-cyan border border-brand-cyan/30 rounded-2xl rounded-tr-none shadow-[0_0_15px_rgba(6,246,255,0.1)]';
                
                const att = m.attachment ? (`
                    <div class="mt-3 pt-3 border-t border-white/10">
                        <a href="${'{{ asset('storage') }}'}/${m.attachment}" target="_blank" class="flex items-center gap-2 group/file">
                            <div class="p-2 rounded-lg bg-white/5 group-hover/file:bg-brand-cyan/20 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </div>
                            <span class="text-[9px] font-black uppercase tracking-wider opacity-70 group-hover/file:opacity-100 transition-opacity">Download Payload</span>
                        </a>
                    </div>
                `) : '';

                const html = `
                    <div class="flex flex-col ${alignClass} animate-fade-in-up">
                        <div class="flex items-center gap-2 mb-1 opacity-50">
                            <span class="text-[9px] font-black uppercase tracking-widest">${senderName}</span>
                            <span class="text-[9px] font-mono">${time}</span>
                        </div>
                        <div class="p-4 max-w-[85%] ${bubbleClass} text-xs font-bold leading-relaxed relative">
                            ${esc(m.message)}
                            ${att}
                        </div>
                    </div>
                `;
                chatMessages.insertAdjacentHTML('beforeend', html);
            });
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        async function loadChats(){
            try{
                const res = await fetch(fetchUrl, { credentials: 'same-origin' });
                if(!res.ok) return;
                const json = await res.json();
                render(json.chats || []);
            }catch(e){ console.error(e); }
        }

        document.getElementById('userChatForm').addEventListener('submit', async function(e){
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            const messageInput = document.getElementById('userChatMessage');
            
            const message = messageInput.value;
            const attachment = fileInput.files[0];
            
            if(!message && !attachment) return; // Prevent empty send
            
            // UI optimism
            btn.disabled = true;
            btn.classList.add('opacity-50');

            const fd = new FormData();
            if(message) fd.append('message', message);
            if(attachment) fd.append('attachment', attachment);
            
            try{
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const res = await fetch(sendUrl, { method: 'POST', body: fd, headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }, credentials: 'same-origin' });
                
                if(!res.ok){
                    let j = null;
                    try{ j = await res.json(); }catch(e){}
                    if(j && j.errors){ alert(j.errors.join('\n')); }
                    else if(j && j.message){ alert(j.message); }
                    else { alert('Failed to transmit (E'+res.status+')'); }
                    return;
                }
                
                await loadChats();
                messageInput.value = '';
                fileInput.value = '';
                fileInput.dispatchEvent(new Event('change')); // Reset styles
                
            }catch(err){ console.error(err); alert('Network connection unavailable'); }
            finally {
                btn.disabled = false;
                btn.classList.remove('opacity-50');
                messageInput.focus();
            }
        });

        // initial load + polling
        loadChats();
        setInterval(loadChats, 3000);
        
        // Reveal animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('active');
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(r => observer.observe(r));
    })();
</script>
@endpush
