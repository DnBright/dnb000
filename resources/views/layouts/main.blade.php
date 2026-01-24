<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dark And Bright' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-brand-charcoal text-slate-100 antialiased selection:bg-brand-cyan selection:text-black">

    <!-- OVERLAY -->
    <div id="overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-[60] transition-opacity duration-300 opacity-0" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar" class="fixed top-0 left-0 w-80 h-full bg-[#0b0f14]/95 backdrop-blur-2xl border-r border-white/5 z-[70] -translate-x-full transition-transform duration-500 ease-out">
        <div class="p-8 flex items-center justify-between border-b border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-cyan to-brand-violet flex items-center justify-center text-black font-extrabold text-sm">D</div>
                <span class="font-black text-white tracking-tight">DARK & BRIGHT</span>
            </div>
            <button onclick="toggleSidebar()" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-all">✕</button>
        </div>

        <nav class="p-6 space-y-2">
            <a href="{{ route('home') }}" class="group flex items-center gap-4 px-6 py-4 rounded-2xl transition-all duration-300 {{ request()->routeIs('home') ? 'bg-brand-cyan text-black font-bold shadow-lg shadow-brand-cyan/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('home') ? 'text-black' : 'text-slate-500 group-hover:text-brand-cyan' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>

            <a href="{{ route('portfolio') }}" class="group flex items-center gap-4 px-6 py-4 rounded-2xl transition-all duration-300 {{ request()->routeIs('portfolio') ? 'bg-brand-cyan text-black font-bold shadow-lg shadow-brand-cyan/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('portfolio') ? 'text-black' : 'text-slate-500 group-hover:text-brand-cyan' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Portofolio</span>
            </a>

            <a href="{{ route('paket') }}" class="group flex items-center gap-4 px-6 py-4 rounded-2xl transition-all duration-300 {{ request()->routeIs('paket') ? 'bg-brand-cyan text-black font-bold shadow-lg shadow-brand-cyan/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('paket') ? 'text-black' : 'text-slate-500 group-hover:text-brand-cyan' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span>Pelayanan</span>
            </a>

            <a href="{{ route('contact') }}" class="group flex items-center gap-4 px-6 py-4 rounded-2xl transition-all duration-300 {{ request()->routeIs('contact') ? 'bg-brand-cyan text-black font-bold shadow-lg shadow-brand-cyan/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('contact') ? 'text-black' : 'text-slate-500 group-hover:text-brand-cyan' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span>Contact</span>
            </a>
        </nav>
    </aside>

    <!-- MAIN WRAPPER -->
    <div id="content" class="transition-all duration-500 ease-out min-h-screen flex flex-col pt-24 px-6">
        
        <!-- HEADER -->
        <header class="fixed top-0 left-0 w-full z-50 glass-navbar px-6 py-4 flex justify-between items-center transition-all duration-300">
            <div class="flex items-center gap-6">
                <button onclick="toggleSidebar()" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:bg-brand-cyan hover:text-black hover:border-brand-cyan transition-all shadow-xl group">
                    <svg class="w-6 h-6 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </button>
                <div class="hidden md:flex flex-col">
                    <span class="font-black text-white text-lg tracking-tight leading-none uppercase">Dark & Bright</span>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em] mt-1">Creative Division</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                @guest
                    <a href="{{ route('login') }}" class="btn-secondary py-2.5 px-6">Access</a>
                    <a href="{{ route('register') }}" class="btn-primary py-2.5 px-6">Initiate</a>
                @endguest

                @auth
                    @php
                        $pendingCount = \App\Models\Order::where('customer_id', Auth::id())->whereIn('status', ['submitted', 'in_progress', 'revision'])->count();
                    @endphp
                    
                    <div class="flex items-center gap-2">
                        <a href="{{ route('user.orders') }}" class="relative w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-brand-cyan transition-all group">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            @if($pendingCount > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-brand-violet text-white text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-[#0b0f14]">{{ $pendingCount }}</span>
                            @endif
                        </a>

                        <button id="openProfileBtn" class="flex items-center gap-3 px-4 py-2 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-brand-cyan/20 to-brand-violet/20 flex items-center justify-center text-[10px] font-black text-brand-cyan border border-white/10">
                                {{ substr(Auth::user()->name ?: Auth::user()->email, 0, 1) }}
                            </div>
                            <span class="text-xs font-bold text-white hidden sm:inline">{{ Auth::user()->name ?: 'User' }}</span>
                        </button>

                        <a href="{{ route('user.logout') }}" class="p-3 text-red-500 hover:bg-red-500/10 rounded-2xl transition-all">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </a>
                    </div>
                @endauth
            </div>
        </header>

        <main class="flex-grow">
            @if(session('success') || session('error') || session('status'))
                <div class="max-w-4xl mx-auto mb-8 reveal active">
                    <div class="p-4 rounded-2xl backdrop-blur-xl border {{ session('success') ? 'bg-green-500/10 border-green-500/20 text-green-400' : (session('error') ? 'bg-red-500/10 border-red-500/20 text-red-400' : 'bg-brand-cyan/10 border-brand-cyan/20 text-brand-cyan') }} flex items-center gap-4">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center bg-white/10">
                            @if(session('success')) ✓ @elseif(session('error')) ✕ @else ! @endif
                        </div>
                        <span class="text-sm font-bold uppercase tracking-widest">{{ session('success') ?? session('error') ?? session('status') }}</span>
                    </div>
                </div>
                <script>setTimeout(()=>{document.querySelector('.reveal.active').classList.remove('active');setTimeout(()=>document.querySelector('.reveal.active')?.remove(),800)},5000);</script>
            @endif

            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="mt-32 pb-12 border-t border-white/5 opacity-50 hover:opacity-100 transition-opacity">
            <div class="max-w-7xl mx-auto pt-12 flex flex-col md:flex-row items-center justify-between gap-12">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white font-black text-xl shadow-2xl">D</div>
                    <div>
                        <div class="font-black text-white tracking-widest uppercase">Dark & Bright</div>
                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.2em] mt-1">Refining Visual Protocols • © {{ date('Y') }}</div>
                    </div>
                </div>

                <nav class="flex items-center gap-10 text-[10px] font-black uppercase tracking-[0.3em]">
                    <a href="/" class="text-slate-500 hover:text-brand-cyan transition-colors">Manifest</a>
                    <a href="/portfolio" class="text-slate-500 hover:text-brand-cyan transition-colors">Archive</a>
                    <a href="/paket" class="text-slate-500 hover:text-brand-cyan transition-colors">Protocols</a>
                    <a href="/contact" class="text-slate-500 hover:text-brand-cyan transition-colors">Secure</a>
                </nav>
            </div>
        </footer>
    </div>

    <!-- Modals & Scripts -->
    @auth
    <div id="profileModal" class="fixed inset-0 bg-[#0b0f14]/90 backdrop-blur-xl hidden z-[100] items-center justify-center p-6 transition-all duration-300 opacity-0">
        <div class="bg-white/5 border border-white/10 rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden transform scale-95 transition-all duration-500">
            <div class="p-8 border-b border-white/5 flex justify-between items-center bg-white/[0.02]">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-brand-cyan/10 flex items-center justify-center text-brand-cyan">⚙</div>
                    <h3 class="text-xl font-black text-white uppercase tracking-tight">Identity Settings</h3>
                </div>
                <button id="closeProfileBtn" class="w-10 h-10 rounded-xl hover:bg-white/10 text-slate-400">✕</button>
            </div>
            
            <form method="POST" action="{{ route('user.profile.update') }}" class="p-8 space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Manifest Name</label>
                        <input name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full px-5 py-3 rounded-2xl bg-white/5 border border-white/10 text-white focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan/20 transition-all outline-none" placeholder="Protocol Name" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Comms Email</label>
                        <input name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full px-5 py-3 rounded-2xl bg-white/5 border border-white/10 text-white focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan/20 transition-all outline-none" placeholder="secure@link.com" />
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Physical Coordinates</label>
                        <input name="alamat" value="{{ old('alamat', Auth::user()->alamat) }}" class="w-full px-5 py-3 rounded-2xl bg-white/5 border border-white/10 text-white focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan/20 transition-all outline-none" placeholder="Sector / Base Identity" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">New Access Key</label>
                        <input name="password" type="password" class="w-full px-5 py-3 rounded-2xl bg-white/5 border border-white/10 text-white focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan/20 transition-all outline-none" placeholder="••••••••" />
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-6">
                    <button type="button" id="cancelProfileBtn" class="btn-secondary py-2 px-8">Abort</button>
                    <button type="submit" class="btn-primary py-2 px-8">Commit</button>
                </div>
            </form>
        </div>
    </div>
    @endauth

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const content = document.getElementById('content');

            const closed = sidebar.classList.contains('-translate-x-full');

            if (closed) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.add('opacity-100');
                }, 10);
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.remove('opacity-100');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            }
        }

        // Profile modal handlers
        (function(){
            const openBtn = document.getElementById('openProfileBtn');
            const modal = document.getElementById('profileModal');
            const modalContent = modal?.querySelector('div');
            const closeBtn = document.getElementById('closeProfileBtn');
            const cancelBtn = document.getElementById('cancelProfileBtn');
            
            function open() { 
                modal.classList.remove('hidden'); 
                modal.classList.add('flex');
                setTimeout(() => {
                    modal.classList.add('opacity-100');
                    modalContent.classList.remove('scale-95');
                    modalContent.classList.add('scale-100');
                }, 10);
            }
            
            function close() { 
                modal.classList.remove('opacity-100');
                modalContent.classList.remove('scale-100');
                modalContent.classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden'); 
                    modal.classList.remove('flex');
                }, 300);
            }
            
            if (openBtn) openBtn.addEventListener('click', open);
            if (closeBtn) closeBtn.addEventListener('click', close);
            if (cancelBtn) cancelBtn.addEventListener('click', close);
            window.addEventListener('click', (e)=>{ if (e.target === modal) close(); });
        })();
    </script>
    @stack('scripts')
</body>
</html>
