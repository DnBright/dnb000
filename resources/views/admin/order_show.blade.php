@extends('admin.layout')

@section('content')
<div class="reveal active space-y-8">
    {{-- TOP NAVIGATION & STATUS --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.orders') }}" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-brand-cyan hover:border-brand-cyan transition-all group">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h2 class="text-3xl font-black text-white tracking-tight leading-none uppercase">Protocol <span class="animate-text-shimmer">ORD-{{ $order->order_id }}</span></h2>
                <div class="flex items-center gap-3 mt-3">
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em]">{{ optional($order->created_at)->format('d M•H:i') }}</span>
                    <span class="w-1 h-1 bg-slate-700 rounded-full"></span>
                    <span class="text-[10px] text-brand-cyan font-bold uppercase tracking-[0.3em]">{{ $order->package->name ?? 'Generic Protocol' }}</span>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-4">
            {{-- Order Toggle --}}
            <form method="POST" action="{{ route('admin.orders.update_status', $order->order_id) }}" class="flex items-center gap-3 glass-card p-1.5 pr-4 border-white/5">
                @csrf
                <div class="px-3 text-[9px] font-black text-slate-500 uppercase tracking-widest border-r border-white/5">Status</div>
                <select name="status" class="bg-transparent border-none text-[10px] font-black text-white uppercase tracking-widest focus:ring-0 cursor-pointer" onchange="this.form.submit()">
                    <option value="submitted" {{ $order->status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="in_progress" {{ $order->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="revision" {{ $order->status === 'revision' ? 'selected' : '' }}>Revision</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </form>

            {{-- Payment Toggle --}}
            <form method="POST" action="{{ route('admin.orders.update_payment', $order->order_id) }}" class="flex items-center gap-3 glass-card p-1.5 pr-4 border-white/5">
                @csrf
                <div class="px-3 text-[9px] font-black text-slate-500 uppercase tracking-widest border-r border-white/5">Payment</div>
                @php $isPaid = $order->payments()->where('status', 'paid')->exists(); @endphp
                <select name="payment_status" class="bg-transparent border-none text-[10px] font-black text-white uppercase tracking-widest focus:ring-0 cursor-pointer" onchange="this.form.submit()">
                    <option value="pending" {{ !$isPaid ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $isPaid ? 'selected' : '' }}>Settled</option>
                    <option value="failed">Void</option>
                </select>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-8">
        {{-- LEFT COLUMN: CHAT INTERFACE --}}
        <div class="col-span-12 lg:col-span-7 space-y-8">
            <div class="glass-card flex flex-col h-[700px] overflow-hidden">
                <div class="p-6 border-b border-white/5 bg-white/[0.01] flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-2 h-2 rounded-full bg-brand-cyan animate-pulse"></div>
                        <span class="text-[10px] font-black text-white uppercase tracking-[0.3em]">Comms Channel</span>
                    </div>
                    <span class="text-[9px] text-slate-600 font-bold uppercase tracking-widest italic">Encrypted Connection Active</span>
                </div>

                {{-- Messages Container --}}
                <div id="chatContainer" class="flex-1 overflow-y-auto p-8 space-y-6 scrollbar-thin scrollbar-thumb-white/10">
                    <div id="chatMessages" class="space-y-6">
                        {{-- Polling will inject messages here --}}
                        <div class="flex justify-center p-12">
                            <span class="text-[10px] text-slate-600 font-black uppercase tracking-[0.5em] animate-pulse">Decrypting Comms...</span>
                        </div>
                    </div>
                </div>

                {{-- Input Area --}}
                <div class="p-6 border-t border-white/5 bg-white/[0.01]">
                    <form id="chatForm" class="flex items-center gap-4">
                        <div class="relative flex-1">
                            <input type="text" id="chatMessage" placeholder="Transmit direct directive..." class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 flex-1 px-6 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all placeholder:text-slate-600">
                            <div class="absolute right-4 inset-y-0 flex items-center gap-3">
                                <label for="chatAttachment" class="cursor-pointer text-slate-500 hover:text-brand-cyan transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                </label>
                                <input type="file" id="chatAttachment" class="hidden">
                            </div>
                        </div>
                        <button type="submit" class="w-14 h-14 rounded-2xl bg-brand-cyan flex items-center justify-center text-black shadow-lg shadow-brand-cyan/20 hover:scale-105 active:scale-95 transition-all">
                            <svg class="w-6 h-6 transform rotate-90" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: BRIEF & CONTROL --}}
        <div class="col-span-12 lg:col-span-5 space-y-8">
            {{-- Client Info --}}
            <div class="glass-card p-8">
                <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6">Subject Intel</h3>
                <div class="flex items-center gap-6 mb-8">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-cyan/20 to-brand-violet/20 border border-white/10 flex items-center justify-center font-black text-xl text-white shadow-xl">
                        {{ substr($order->customer->name ?? '?', 0, 1) }}
                    </div>
                    <div>
                        <div class="text-xl font-black text-white tracking-tight leading-none">{{ $order->customer->name ?? 'Unknown Identity' }}</div>
                        <div class="text-[10px] text-brand-cyan font-bold uppercase tracking-widest mt-2">{{ $order->customer->email ?? 'Archive ID' }}</div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-white/5">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Signal Priority</span>
                        <span class="text-xs font-bold text-white uppercase tracking-tighter">High Tier</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-white/5">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Filing Status</span>
                        <span class="text-xs font-bold text-white uppercase tracking-tighter">{{ $isPaid ? 'Settled' : 'Pending' }}</span>
                    </div>
                </div>
            </div>

            {{-- Final Delivery Area --}}
            <div class="glass-card p-8 overflow-hidden relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-brand-cyan/5 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
                
                <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6">Master Asset Delivery</h3>
                
                @if($order->finalFiles->count() > 0)
                    @php $final = $order->finalFiles->last(); @endphp
                    <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                        <div class="flex items-center gap-6 mb-6">
                            @php $f = $final->file_path; $ext = pathinfo($f, PATHINFO_EXTENSION); @endphp
                            @if(in_array(strtolower($ext), ['jpg','jpeg','png','svg']))
                                <div class="w-20 h-20 rounded-xl overflow-hidden border border-white/10 shadow-2xl">
                                    <img src="{{ asset('storage/' . $f) }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-20 h-20 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <div>
                                <div class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-1">Finalized Asset</div>
                                <div class="text-xs font-bold text-white truncate max-w-[150px]">{{ basename($f) }}</div>
                                <div class="text-[9px] text-slate-600 font-bold uppercase mt-1">{{ strtoupper($ext) }} Protocol</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ asset('storage/' . $f) }}" target="_blank" class="btn-primary text-center py-2 text-[10px] uppercase tracking-widest">Download</a>
                            <a href="{{ route('admin.orders.invoice', $order->order_id) }}" class="btn-secondary text-center py-2 text-[10px] uppercase tracking-widest">Invoice</a>
                        </div>
                    </div>
                @else
                    <form action="{{ route('admin.orders.deliver', $order->order_id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="relative group">
                            <input type="file" name="final" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="border-2 border-dashed border-white/10 rounded-2xl p-8 flex flex-col items-center justify-center group-hover:border-brand-cyan/50 transition-all">
                                <svg class="w-8 h-8 text-slate-600 mb-4 group-hover:text-brand-cyan transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] group-hover:text-white transition-colors">Click to Select Master Asset</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="notify" value="1" checked class="hidden peer">
                                <div class="w-10 h-6 bg-white/5 rounded-full border border-white/10 peer-checked:bg-brand-cyan transition-all relative">
                                    <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
                                </div>
                                <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest group-hover:text-white transition-colors">Alert Client</span>
                            </label>
                            <button type="submit" class="btn-primary py-3 px-8 text-[10px] uppercase tracking-[0.2em] font-black">Commit Delivery</button>
                        </div>
                    </form>
                @endif
            </div>

            {{-- Revision DNA --}}
            <div class="glass-card p-8">
                <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6">Revision Pulse</h3>
                @php $revs = $order->meta['revisions'] ?? []; $responses = $order->meta['revision_responses'] ?? []; @endphp
                
                <div class="space-y-6 mb-8 max-h-64 overflow-y-auto pr-4 scrollbar-thin scrollbar-thumb-white/10">
                    @forelse($order->revisions->sortByDesc('created_at') as $r)
                        <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5 relative">
                            <div class="absolute -left-2 top-0 bottom-0 w-1 bg-brand-violet rounded-full opacity-40"></div>
                            <div class="text-[9px] text-slate-600 font-bold uppercase tracking-widest mb-2">{{ optional($r->created_at)->format('d M H:i') ?? 'Timestamp Unknown' }} • User Directive #{{ $r->revision_no }}</div>
                            <div class="text-xs text-slate-300 leading-relaxed">{{ $r->request_note ?? 'Status empty.' }}</div>
                            @if(!empty($r->revision_file))
                                <a href="{{ asset('storage/' . $r->revision_file) }}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-[9px] font-black text-brand-cyan hover:underline uppercase tracking-widest">
                                    <span>Download Data</span>
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-6 text-[10px] text-slate-600 uppercase tracking-widest italic font-bold">No modification directive received.</div>
                    @endforelse
                </div>

                {{-- Response Form --}}
                <form action="{{ route('admin.orders.revision.upload', $order->order_id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 pt-6 border-t border-white/5">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <select name="revision_index" class="bg-white/5 border border-white/10 rounded-xl text-[10px] font-black text-white uppercase tracking-widest px-4 py-3 focus:ring-brand-cyan/20 focus:border-brand-cyan/50 outline-none">
                            <option value="">General Protocol</option>
                            @foreach($order->revisions as $i => $r)
                                <option value="{{ $i }}">Link to Signal #{{ $i+1 }}</option>
                            @endforeach
                        </select>
                        <div class="relative">
                            <input type="file" name="file" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="w-full bg-white/5 border border-white/10 rounded-xl text-[10px] font-black text-slate-500 uppercase tracking-widest px-4 py-3 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span>Inject Log</span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-secondary w-full py-3 text-[10px] uppercase tracking-[0.2em] font-black">Transmit Response Matrix</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function(){
        const fetchUrl = "{{ route('admin.orders.chat.fetch', $order->order_id) }}";
        const sendUrl = "{{ route('admin.orders.chat.send', $order->order_id) }}";
        const chatMessages = document.getElementById('chatMessages');
        const chatContainer = document.getElementById('chatContainer');

        function esc(s){ return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

        function render(chats){
            if(!chatMessages) return;
            if(!chats || chats.length===0){ 
                chatMessages.innerHTML = '<div class="flex flex-col items-center justify-center p-20 text-center"><div class="text-[10px] text-slate-700 font-black uppercase tracking-[0.5em] mb-4 italic">Channel Silent</div><div class="w-1 h-12 bg-white/5 rounded-full"></div></div>'; 
                return; 
            }
            chatMessages.innerHTML = '';
            chats.forEach(function(m){
                const isAdmin = m.sender === 'admin';
                const senderLabel = isAdmin ? ('ADMIN (' + m.sender_name + ')') : ('CLIENT (' + m.sender_name + ')');
                const alignClass = isAdmin ? 'flex-row-reverse' : 'flex-row';
                const bubbleClass = isAdmin ? 'bg-brand-cyan text-black rounded-tr-none shadow-[0_0_20px_rgba(6,246,255,0.15)]' : 'bg-white/5 border border-white/10 text-white rounded-tl-none';
                const time = m.created_at ? m.created_at : '';
                
                const att = m.attachment ? ('<div class="mt-4 pt-4 border-t ' + (isAdmin ? 'border-black/10' : 'border-white/5') + '"><a href="' + ('{{ asset('storage') }}' + '/' + m.attachment) + '" target="_blank" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest ' + (isAdmin ? 'text-black/60 hover:text-black' : 'text-brand-cyan hover:text-white') + ' transition-colors"><span>Protocol Data</span><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg></a></div>') : '';
                
                const html = `
                    <div class="flex ${alignClass} items-start gap-4 animate-fade-in-up">
                        <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center font-black text-[10px] text-slate-500 flex-shrink-0">
                            ${m.sender.charAt(0).toUpperCase()}
                        </div>
                        <div class="max-w-[75%]">
                            <div class="flex ${isAdmin ? 'flex-row-reverse text-right' : 'flex-row'} items-center gap-3 mb-1.5 px-1">
                                <span class="text-[9px] font-black uppercase tracking-widest ${isAdmin ? 'text-brand-cyan' : 'text-slate-400'}">${senderLabel}</span>
                                <span class="text-[8px] text-slate-700 font-bold uppercase">${time}</span>
                            </div>
                            <div class="${bubbleClass} p-4 rounded-2xl text-xs font-medium leading-relaxed shadow-xl">
                                ${esc(m.message)}
                                ${att}
                            </div>
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

        document.getElementById('chatForm').addEventListener('submit', async function(e){
            e.preventDefault();
            const message = document.getElementById('chatMessage').value;
            const attachment = document.getElementById('chatAttachment').files[0];
            if(!message && !attachment) return;
            
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>';

            const fd = new FormData();
            if(message) fd.append('message', message);
            if(attachment) fd.append('attachment', attachment);
            
            try{
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const res = await fetch(sendUrl, { method: 'POST', body: fd, headers: { 'X-CSRF-TOKEN': token }, credentials: 'same-origin' });
                if(!res.ok) throw new Error('transmit failed');
                document.getElementById('chatMessage').value = '';
                document.getElementById('chatAttachment').value = '';
                loadChats();
            }catch(err){ 
                console.error(err); 
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<svg class="w-6 h-6 transform rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/></svg>';
            }
        });

        loadChats();
        setInterval(loadChats, 10000);
    })();
</script>
@endpush
@endsection
