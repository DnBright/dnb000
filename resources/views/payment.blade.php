@extends('layouts.main')

@section('content')

<main class="relative min-h-screen py-20 overflow-hidden">
    <!-- Immersive Background Elements -->
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-brand-cyan/5 blur-[120px] rounded-full animate-blob-float"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-brand-violet/5 blur-[120px] rounded-full animate-blob-float" style="animation-delay: -5s;"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <!-- HEADER -->
        <div class="max-w-5xl mx-auto mb-12 reveal">
            <div class="inline-flex px-4 py-1.5 rounded-full bg-brand-cyan/10 border border-brand-cyan/20 text-brand-cyan text-[10px] font-bold uppercase tracking-[0.3em] mb-8">
                {{ __('Transaction Terminal [Step 04]') }}
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white leading-tight uppercase tracking-tight">
                {{ __('Commitment') }} <span class="animate-text-shimmer">{{ __('Protocol.') }}</span>
            </h1>
            <p class="text-slate-500 mt-4 font-bold uppercase text-xs tracking-widest">{{ __('Finalize the investment for your creative synchronization.') }}</p>
        </div>

        <!-- ORDERING GUIDE -->
        <x-ordering-guide activeStep="3" class="mb-16" />

        <div class="max-w-5xl mx-auto">
            <div class="glass-card shadow-2xl border-white/5 overflow-hidden reveal" style="transition-delay: 100ms;">
                <div class="p-8 md:p-12 border-b border-white/5 bg-white/[0.02]">
                    <div class="flex flex-col md:flex-row items-start justify-between gap-12">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center p-3 group-hover:border-brand-cyan transition-colors">
                                <img src="/storage/logo.png" alt="X" class="w-full h-full object-contain filter brightness-200" onerror="this.src='https://placehold.co/100x100/0b0f14/ffffff?text=X'">
                            </div>
                            <div>
                                <h2 class="text-xl font-black text-white uppercase tracking-tighter">Dark & Bright Studio</h2>
                                <div class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">{{ __('Creative Defense Network — IDN') }}</div>
                            </div>
                        </div>

                        <div class="text-left md:text-right space-y-2">
                            <h3 class="text-2xl font-black text-white tracking-widest uppercase mb-4">INVOICE</h3>
                            <div class="text-[10px] text-slate-500 font-bold uppercase tracking-widest leading-relaxed">
                                Protocol ID: <span class="text-brand-cyan">#{{ $order->order_id }}</span><br>
                                {{ __('Issued At:') }} <span class="text-white">{{ $order->created_at ? $order->created_at->format('d M Y') : now()->format('d M Y') }}</span><br>
                                {{ __('Status Registry:') }} 
                                @if($order->status === 'completed')
                                    <span class="text-green-400">{{ __('CLEARANCE GRANTED') }}</span>
                                @elseif($order->status === 'submitted')
                                    <span class="text-brand-cyan">{{ __('AWAITING COMMITMENT') }}</span>
                                @else
                                    <span class="text-red-500 uppercase">{{ $order->status }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 md:p-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
                        <div class="space-y-4">
                            <p class="text-[10px] text-brand-cyan font-black uppercase tracking-[0.4em]">{{ __('Client Entity') }}</p>
                            <div class="space-y-1">
                                <div class="text-lg font-black text-white leading-tight uppercase">{{ $data['nama'] ?? ($order->customer->name ?? 'Unknown Entity') }}</div>
                                <div class="text-xs text-slate-500 font-bold tracking-widest">{{ $data['email'] ?? ($order->customer->email ?? '-') }}</div>
                                <div class="text-[10px] text-slate-600 font-bold tracking-widest">{{ $data['whatsapp'] ?? ($order->customer->phone ?? '-') }}</div>
                            </div>
                        </div>

                        <div class="space-y-4 text-left md:text-right">
                            <p class="text-[10px] text-brand-violet font-black uppercase tracking-[0.4em]">{{ __('Order Manifest') }}</p>
                            <div class="space-y-1">
                                <div class="text-xs text-slate-400 font-bold tracking-widest uppercase">{{ __('Target Payload:') }} <span class="text-white">{{ ucwords(str_replace('-', ' ', $order->package->name ?? 'Generic')) }}</span></div>
                                <div class="text-xs text-slate-400 font-bold tracking-widest uppercase">{{ __('System Reference:') }} <span class="text-white">#DB-{{ $order->order_id }}</span></div>
                                <div class="text-xs text-slate-400 font-bold tracking-widest uppercase">{{ __('Commit Due:') }} <span class="text-white">{{ $order->due_date ? $order->due_date->format('d . M . Y') : now()->addDays(7)->format('d . M . Y') }}</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto mb-16 rounded-2xl border border-white/5 overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white/[0.03] text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">
                                    <th class="px-8 py-6">#</th>
                                    <th class="px-8 py-6">{{ __('Payload Description') }}</th>
                                    <th class="px-8 py-6">{{ __('Units') }}</th>
                                    <th class="px-8 py-6">{{ __('Unit Rate') }}</th>
                                    <th class="px-8 py-6 text-right">{{ __('Subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                <tr class="bg-transparent text-xs text-slate-300 font-bold group hover:bg-white/[0.02] transition-colors">
                                    <td class="px-8 py-8">01</td>
                                    <td class="px-8 py-8">
                                        <div class="text-white font-black mb-1 uppercase tracking-tight">{{ ucwords(str_replace('-', ' ', $order->package->name ?? 'Generic')) }}</div>
                                        <div class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">{{ __('Base Protocol Implementation') }}</div>
                                    </td>
                                    <td class="px-8 py-8">01</td>
                                    <td class="px-8 py-8">IDR {{ number_format($order->package->price ?? 0,0,',','.') }}</td>
                                    <td class="px-8 py-8 text-right text-white font-black">IDR {{ number_format($order->package->price ?? 0,0,',','.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col md:flex-row items-center justify-between gap-12 bg-white/[0.02] p-8 md:p-12 rounded-3xl border border-white/5 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-64 h-full bg-gradient-to-r from-brand-cyan/5 to-transparent pointer-events-none"></div>
                        
                        <div class="relative z-10 text-center md:text-left">
                            <p class="text-[10px] text-brand-cyan font-black uppercase tracking-[0.4em] mb-2">{{ __('Protocol Status') }}</p>
                            <p class="text-slate-500 text-xs font-bold leading-relaxed max-w-sm uppercase tracking-widest">
                                {{ __('Initiating the synchronization cycle requires a secure commitment. Choose your terminal below.') }}
                            </p>
                        </div>

                        <div class="relative z-10 w-full md:w-auto min-w-[300px] flex flex-col gap-4">
                            <div class="flex items-center justify-between text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">
                                <span>{{ __('Grand Total') }}</span>
                                <span class="text-white text-2xl font-black tracking-tighter">IDR {{ number_format($order->package->price ?? 0,0,',','.') }}</span>
                            </div>

                            @php $isPaid = $order->payments()->where('status', 'paid')->exists(); @endphp
                            @if($order->status !== 'completed' && !$isPaid)
                            <button id="payBtn" class="btn-primary w-full !py-5 text-xs tracking-[0.2em] font-black uppercase shadow-brand-cyan/20 transition-transform hover:scale-[1.02]">
                                {{ __('Initialize Secure Payment →') }}
                            </button>
                            @else
                            <div class="w-full !py-5 text-xs tracking-[0.2em] font-black uppercase text-center bg-green-500/10 border border-green-500/30 text-green-400 rounded-xl">
                                {{ __('PAYMENT CONFIRMED') }}
                            </div>
                            @endif

                            <div class="flex gap-4">
                                @php
                                    $waMessage = urlencode("Halo, saya ingin melakukan pembayaran untuk Order #" . $order->order_id . " (" . ($order->package->name ?? 'Generic') . ") - Nama: " . ($data['nama'] ?? ($order->customer->name ?? '')) . ", Email: " . ($data['email'] ?? ($order->customer->email ?? '')) );
                                    $waUrl = "https://wa.me/6285158661152?text=" . $waMessage;
                                @endphp
                                <a target="_blank" rel="noopener" href="{{ $waUrl }}" class="flex-1 btn-secondary !py-3 !px-4 text-[9px] font-black uppercase tracking-widest text-center flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.539 2.016 2.126-.54c1.029.563 2.025.882 3.162.882 3.181 0 5.767-2.586 5.768-5.766 0-3.181-2.586-5.768-5.768-5.745zm3.178 8.169c-.147.411-.711.758-.98 1.019-.245.245-.539.319-2.008-.294-1.787-.735-2.94-2.548-3.038-2.67-.098-.122-.71-.931-.71-1.787 0-.856.441-1.274.588-1.445.147-.171.319-.221.416-.221.098 0 .221.025.294.025.098 0 .196-.025.294.196.122.27.416 1.029.441 1.102.025.073.049.147 0 .221-.049.073-.098.172-.147.245-.049.073-.122.172-.172.221-.049.073-.122.147-.049.27.073.122.319.515.686.857.466.416.857.539 1.005.613.147.073.221.049.294-.025.073-.098.319-.368.416-.49.098-.122.196-.098.319-.049.122.049.784.368.906.441.122.049.196.073.221.122.049.073.049.441-.098.856zM12 1a11 11 0 1011 11A11.013 11.013 0 0012 1zm0 20a9 9 0 119-9 9.01 9.01 0 01-9 9z"/></svg>
                                    {{ __('WHATSAPP ADMIN') }}
                                </a>
                                <a href="{{ route('user.orders.invoice', $order->order_id) }}" target="_blank" class="flex-1 btn-secondary !py-3 !px-4 text-[9px] font-black uppercase tracking-widest text-center flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    {{ __('INVOICE') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@push('styles')
<style>
    @media print {
        /* Reset immersive backgrounds for paper */
        body {
            background: white !important;
            color: black !important;
            font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
            font-size: 10px !important;
            padding: 0 !important;
        }
        main {
            padding: 0 !important;
            min-height: auto !important;
        }
        .container {
            max-width: 100% !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        /* Hide non-invoice elements */
        .fixed, .reveal p:first-of-type, h1, .reveal > p, #payBtn, .btn-secondary, 
        header, footer, .glass-card::before, .glass-card::after,
        [class*="animate-"], .blur-3xl, .blur-[120px], .inline-flex, .p-8.md\:p-12.border-b,
        .p-8.md\:p-12:last-child > .flex.flex-col.md\:flex-row.items-center.justify-between.gap-12 {
            display: none !important;
        }

        /* Transform glass-card to standard paper layout */
        .glass-card {
            background: white !important;
            border: none !important;
            box-shadow: none !important;
            color: black !important;
            backdrop-filter: none !important;
            margin: 0 !important;
            padding: 0 !important;
            border-radius: 0 !important;
        }

        /* Invoice Header (Logo + Meta) */
        .glass-card::before {
            content: "";
            display: block;
            border-top: 1px solid #eee;
            margin-bottom: 30px;
        }

        /* Custom Header for Print */
        .p-8.md\:p-12:first-child {
            display: flex !important;
            justify-content: space-between !important;
            align-items: flex-start !important;
            border-bottom: 1px solid #eee !important;
            padding-bottom: 30px !important;
            margin-bottom: 60px !important;
        }

        /* Re-styling table for print */
        table {
            border-collapse: collapse !important;
            width: 100% !important;
            margin-bottom: 40px !important;
        }
        th {
            background: #fcfcfc !important;
            border-bottom: 1px solid #000 !important;
            color: #666 !important;
            font-size: 8px !important;
            text-transform: uppercase !important;
            padding: 10px !important;
        }
        td {
            border-bottom: 1px solid #eee !important;
            padding: 15px 10px !important;
            color: black !important;
        }

        /* Labels and Text */
        .text-brand-cyan, .text-brand-violet, .text-slate-500, .text-slate-600 {
            color: #666 !important;
        }
        .text-white, .font-black, .font-bold {
            color: black !important;
        }
        
        .uppercase { text-transform: uppercase !important; }
        .tracking-widest { letter-spacing: 0.1em !important; }
        .tracking-tighter { letter-spacing: -0.05em !important; }

        /* Force A4 Margins */
        @page {
            margin: 2cm;
        }

        /* Grand Total Section */
        .p-8.md\:p-12:last-child {
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Include Midtrans Snap JS (sandbox by default)
    (function(){
        const clientKey = '{{ config("midtrans.client_key") }}';
        const isProd = {{ config('midtrans.production') ? 'true' : 'false' }};
        const src = isProd ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js';
        const s = document.createElement('script');
        s.src = src;
        s.setAttribute('data-client-key', clientKey);
        document.head.appendChild(s);
    })();

    const payBtn = document.getElementById('payBtn');
    if (payBtn) {
        payBtn.addEventListener('click', function(){
            const btn = this;
            btn.disabled = true;
            fetch('{{ route('midtrans.token', ['order' => $order->order_id]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    nama: '{{ $data['nama'] ?? ($order->customer->name ?? '') }}',
                    email: '{{ $data['email'] ?? ($order->customer->email ?? '') }}',
                    whatsapp: '{{ $data['whatsapp'] ?? ($order->customer->phone ?? '') }}'
                })
            }).then(r=>r.json()).then(function(json){
                btn.disabled = false;
                if (json.error) {
                    alert('Error: ' + (json.message || json.error));
                    return;
                }
                if (json.token) {
                    const run = function(){
                        if (window.snap) {
                            window.snap.pay(json.token, {
                                onSuccess: function(result){ 
                                    window.location.href = "{{ route('user.orders') }}?payment=success";
                                },
                                onPending: function(result){ 
                                    window.location.href = "{{ route('user.orders') }}?payment=pending";
                                },
                                onError: function(result){ alert('Payment failed/cancelled'); }
                            });
                        } else {
                            setTimeout(run, 200);
                        }
                    };
                    run();
                } else if (json.redirect_url) {
                    window.location = json.redirect_url;
                } else {
                    alert('Failed to get Midtrans token');
                }
            }).catch(function(e){
                btn.disabled = false;
                alert('Request failed: '+e.message);
            });
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('active');
            });
        }, { threshold: 0.1 });
        reveals.forEach(r => observer.observe(r));
    });
</script>

<!-- SUCCESS MODAL -->
<div id="successModal" class="fixed inset-0 z-[200] hidden items-center justify-center p-6">
    <div class="absolute inset-0 bg-black/95 backdrop-blur-xl"></div>
    <div class="relative glass-card max-w-lg w-full p-10 text-center border-brand-cyan/30 shadow-[0_0_50px_rgba(6,246,255,0.2)] reveal active">
        <div class="w-20 h-20 rounded-2xl bg-brand-cyan/20 flex items-center justify-center mx-auto mb-8 shadow-[0_0_20px_rgba(6,246,255,0.3)]">
            <svg class="w-10 h-10 text-brand-cyan" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-4">{{ __('Payment Successful') }}</h3>
        
        <div class="p-6 rounded-2xl bg-white/5 border border-white/10 mb-8">
            <p class="text-sm font-bold text-slate-300 leading-relaxed uppercase tracking-widest">
                " HUBUNGI ADMIN DAN KIRIM INVOICE MELALUI WHATSAPP UNTUK MELANJUTKAN PROSES PEMESANAN "
            </p>
        </div>

        @php
            $successWAMessage = urlencode("Halo Admin, saya sudah melakukan pembayaran untuk Order #" . $order->order_id . ". Ini bukti pembayarannya. Mohon segera diproses.");
            $successWAUrl = "https://wa.me/6285158661152?text=" . $successWAMessage;
        @endphp

        <div class="flex flex-col gap-4">
            <a href="{{ $successWAUrl }}" target="_blank" class="btn-primary !py-4 flex items-center justify-center gap-3 w-full text-xs font-black tracking-widest uppercase">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.539 2.016 2.126-.54c1.029.563 2.025.882 3.162.882 3.181 0 5.767-2.586 5.768-5.766 0-3.181-2.586-5.768-5.768-5.745zm3.178 8.169c-.147.411-.711.758-.98 1.019-.245.245-.539.319-2.008-.294-1.787-.735-2.94-2.548-3.038-2.67-.098-.122-.71-.931-.71-1.787 0-.856.441-1.274.588-1.445.147-.171.319-.221.416-.221.098 0 .221.025.294.025.098 0 .221.025.294.196.122.27.416 1.029.441 1.102.025.073.049.147 0 .221-.049.073-.098.172-.147.245-.049.073-.122.172-.172.221-.049.073-.122.147-.049.27.073.122.319.515.686.857.466.416.857.539 1.005.613.147.073.221.049.294-.025.073-.098.319-.368.416-.49.098-.122.196-.098.319-.049.122.049.784.368.906.441.122.049.196.073.221.122.049.073.049.441-.098.856zM12 1a11 11 0 1011 11A11.013 11.013 0 0012 1zm0 20a9 9 0 119-9 9.01 9.01 0 01-9 9z"/></svg>
                HUBUNGI ADMIN SEKARANG
            </a>
            <button onclick="window.location.reload()" class="text-[10px] font-black text-slate-500 hover:text-white transition-colors uppercase tracking-[0.3em]">
                {{ __('Close') }} & REFRESH
            </button>
        </div>
    </div>
</div>
@endpush
