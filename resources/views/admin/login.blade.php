<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Engine | Secure Terminal</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])
    
    <style>
        :root {
            --brand-charcoal: #0b0f14;
            --brand-nearBlack: #05070a;
            --brand-navy: #0f172a;
            --brand-cyan: #22d3ee;
            --brand-violet: #8b5cf6;
            --brand-accent: #f43f5e;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--brand-nearBlack);
            color: #f8fafc;
            overflow: hidden;
        }

        .void-bg {
            position: fixed;
            inset: 0;
            background: 
                radial-gradient(circle at 20% 30%, rgba(34, 211, 238, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(139, 92, 246, 0.05) 0%, transparent 40%);
            z-index: -1;
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .glow-input {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glow-input:focus {
            border-color: var(--brand-cyan);
            box-shadow: 0 0 20px rgba(34, 211, 238, 0.15);
            background: rgba(255, 255, 255, 0.05);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--brand-cyan), var(--brand-violet));
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 30px rgba(34, 211, 238, 0.3);
            filter: brightness(1.1);
        }

        .animate-shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6">
    <div class="void-bg"></div>

    <div class="w-full max-w-[440px] glass-card p-10 rounded-[40px] relative reveal" id="loginCard">
        {{-- DECORATIVE ELEMENTS --}}
        <div class="absolute -top-12 -left-12 w-32 h-32 bg-brand-cyan/10 rounded-full blur-[80px]"></div>
        <div class="absolute -bottom-12 -right-12 w-32 h-32 bg-brand-violet/10 rounded-full blur-[80px]"></div>

        {{-- HEADER --}}
        <div class="text-center space-y-4 mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/5 border border-white/10 mb-4 shadow-2xl">
                <svg class="w-8 h-8 text-brand-cyan" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-black text-white tracking-tight uppercase leading-none">Command <span class="bg-gradient-to-r from-brand-cyan to-brand-violet bg-clip-text text-transparent">Portal</span></h2>
            <div class="flex items-center justify-center gap-3">
                <span class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em]">Agency Control System</span>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-8 p-4 rounded-2xl bg-brand-accent/10 border border-brand-accent/20">
                <p class="text-[10px] font-black text-brand-accent uppercase tracking-widest text-center">{{ $errors->first() }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
            @csrf

            <div class="space-y-2 group">
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] ml-4">Terminal ID</label>
                <div class="relative">
                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-brand-cyan transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </span>
                    <input type="email" name="email" required placeholder="name@agency.com" class="w-full h-14 bg-white/5 glow-input rounded-2xl pl-14 pr-6 text-sm text-white focus:outline-none placeholder:text-slate-600 font-bold">
                </div>
            </div>

            <div class="space-y-2 group">
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] ml-4">Access Code</label>
                <div class="relative">
                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-brand-cyan transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </span>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full h-14 bg-white/5 glow-input rounded-2xl pl-14 pr-6 text-sm text-white focus:outline-none placeholder:text-slate-600 font-bold">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full h-14 btn-primary rounded-2xl text-[11px] font-black text-white uppercase tracking-[0.3em] shadow-xl">
                    Initiate Authorization
                </button>
            </div>
        </form>

        <div class="mt-10 pt-8 border-t border-white/5 text-center">
            <p class="text-[9px] text-slate-700 font-black uppercase tracking-[0.4em]">Restricted Access Area</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                document.getElementById('loginCard').classList.add('active');
            }, 100);
        });
    </script>
</body>
</html>
