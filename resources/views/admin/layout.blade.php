<!doctype html>
<html lang="en" class="dark scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $title ?? 'Control Center • Dark & Bright' }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/app.css','resources/js/app.js'])
  @stack('styles')
</head>
<body class="bg-[#0b0f14] text-slate-100 antialiased font-['Outfit'] selection:bg-brand-cyan/30">

  {{-- BACKGROUND EFFECTS --}}
  <div class="fixed inset-0 overflow-hidden pointer-events-none z-[-1]">
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-brand-cyan/10 rounded-full blur-[120px] animate-blob-float"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[35%] h-[35%] bg-brand-violet/10 rounded-full blur-[100px] animate-blob-float" style="animation-delay: -5s;"></div>
  </div>

  {{-- TOP HEADER --}}
  <header class="fixed top-0 left-0 w-full z-50 glass-navbar px-6 py-4 flex justify-between items-center transition-all duration-300">
    <div class="flex items-center gap-6">
      <button onclick="toggleSidebar()" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:bg-brand-cyan hover:text-black hover:border-brand-cyan transition-all shadow-xl group">
        <svg class="w-6 h-6 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
        </svg>
      </button>
      <div class="hidden md:flex flex-col">
        <span class="font-black text-white text-lg tracking-tight leading-none uppercase">{{ __('Admin Control') }}</span>
        <span class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em] mt-1">Dark & Bright Creative</span>
      </div>
    </div>

    <div class="flex-1 max-w-xl mx-8 hidden lg:block">
      <div class="relative group">
        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
          <svg class="w-4 h-4 text-slate-500 group-focus-within:text-brand-cyan transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <input type="text" placeholder="{{ __('Protocol search') }}..." class="w-full bg-white/5 border border-white/10 rounded-2xl py-3 pl-12 pr-4 text-sm text-white focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/10 transition-all placeholder:text-slate-600">
      </div>
    </div>

    <div class="flex items-center gap-4">
      {{-- Notification Bell --}}
      <div class="relative">
        <button onclick="toggleBell()" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white transition-all">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h11z" />
          </svg>
          <span id="notifBadge" class="absolute top-3 right-3 w-4 h-4 bg-red-500 text-[9px] font-black text-white rounded-full border-2 border-[#0b0f14] flex items-center justify-center shadow-lg" style="display:none">0</span>
        </button>
        <div id="notifDropdown" class="hidden absolute right-0 mt-4 w-72 glass-card overflow-hidden z-50">
          <div class="p-4 border-b border-white/5 font-black text-[10px] uppercase tracking-widest text-slate-500">{{ __('Notifications') }}</div>
          <div id="notifList" class="max-h-64 overflow-y-auto">
            <div class="p-4 text-xs text-slate-600">{{ __('No active signals') }}</div>
          </div>
        </div>
      </div>

      {{-- Admin User --}}
      @auth('admin')
      <div class="relative">
        <button onclick="toggleUserMenu()" class="flex items-center gap-3 p-1.5 pr-4 rounded-2xl bg-white/5 border border-white/10 hover:border-white/20 transition-all">
          <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-cyan to-brand-violet flex items-center justify-center text-black font-black text-xs shadow-lg shadow-brand-cyan/20">
            {{ strtoupper(substr(Auth::guard('admin')->user()->nama ?? Auth::guard('admin')->user()->email,0,1)) }}
          </div>
          <div class="hidden md:block">
            <div class="text-[11px] font-black text-white uppercase tracking-tight leading-none">{{ Auth::guard('admin')->user()->nama ?? 'Director' }}</div>
            <div class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-1">{{ __('Authorized') }}</div>
          </div>
        </button>
        <div id="userMenu" class="hidden absolute right-0 mt-4 w-52 glass-card overflow-hidden z-50">
          <div class="p-4 border-b border-white/5">
            <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ __('Admin ID') }}</div>
            <div class="text-xs font-bold text-white mt-1">{{ Auth::guard('admin')->user()->email }}</div>
          </div>
          <nav class="p-2">
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition-all text-sm font-medium text-slate-300">
              <span class="text-slate-500 text-xs">👤</span> {{ __('Profile Settings') }}
            </a>
            <form method="POST" action="{{ route('admin.logout') }}">
              @csrf
              <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/10 transition-all text-sm font-medium text-red-500">
                <span class="text-xs">⏻</span> {{ __('System Exit') }}
              </button>
            </form>
          </nav>
        </div>
      </div>
      @endauth
    </div>
  </header>

  <div class="min-h-screen flex pt-24 px-6 md:px-8">
    {{-- SIDEBAR --}}
    <aside id="sidebar" class="fixed left-0 top-0 h-full w-80 glass-navbar border-r border-white/5 z-[60] -translate-x-full transition-all duration-500 ease-out pt-24">
      <div class="px-8 mb-8">
        <div class="text-[10px] font-black text-slate-500 uppercase tracking-[0.4em] mb-4">{{ __('Core Protocols') }}</div>
        <nav class="space-y-2">
          <a href="/admin/dashboard" class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all duration-300 {{ request()->is('admin/dashboard') ? 'bg-brand-cyan text-black font-black shadow-lg shadow-brand-cyan/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
             <span class="w-5 h-5 flex items-center justify-center">▤</span>
             <span class="text-sm font-bold uppercase tracking-widest">{{ __('Overview') }}</span>
          </a>
          <a href="{{ route('admin.orders') }}" class="flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 {{ request()->is('admin/orders*') ? 'bg-brand-cyan text-black font-black shadow-lg shadow-brand-cyan/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
             <div class="flex items-center gap-4">
               <span class="w-5 h-5 flex items-center justify-center">⌘</span>
               <span class="text-sm font-bold uppercase tracking-widest">Orders</span>
             </div>
             <span class="bg-brand-violet px-2 py-0.5 rounded-lg text-[10px] text-white">3</span>
          </a>
          <a href="{{ route('admin.customers') }}" class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all duration-300 {{ request()->is('admin/customers*') ? 'bg-brand-cyan text-black font-black shadow-lg shadow-brand-cyan/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
             <span class="w-5 h-5 flex items-center justify-center">👥</span>
             <span class="text-sm font-bold uppercase tracking-widest">{{ __('Clients') }}</span>
          </a>
        </nav>
      </div>

      <div class="px-8 border-t border-white/5 pt-8">
        <div class="text-[10px] font-black text-slate-500 uppercase tracking-[0.4em] mb-4">{{ __('Asset Matrix') }}</div>
        <div class="space-y-2">
            <button onclick="toggleMenu('menuPages','menuPagesCaret')" class="w-full flex justify-between items-center px-6 py-3 rounded-2xl text-slate-400 hover:bg-white/5 transition-all group">
                <span class="text-sm font-bold uppercase tracking-widest group-hover:text-white flex items-center gap-4">
                    <span>◈</span> {{ __('Landing Core') }}
                </span>
                <span id="menuPagesCaret" class="text-[8px] transition-transform duration-300">▼</span>
            </button>
            <div id="menuPages" class="hidden space-y-1 pl-10 mt-2 border-l border-white/5 ml-6">
                <a href="/admin/pages/home" class="block py-2 text-xs font-bold text-slate-500 hover:text-brand-cyan transition-colors">{{ __('Hero Section') }}</a>
                <a href="{{ route('admin.pages.services.edit') }}" class="block py-2 text-xs font-bold text-slate-500 hover:text-brand-cyan transition-colors">{{ __('Popular Tools') }}</a>
                <a href="{{ route('admin.pages.top_designers.edit') }}" class="block py-2 text-xs font-bold text-slate-500 hover:text-brand-cyan transition-colors">{{ __('Elite Designers') }}</a>
                <a href="{{ route('admin.pages.templates.edit') }}" class="block py-2 text-xs font-bold text-slate-500 hover:text-brand-cyan transition-colors">{{ __('Templates DNA') }}</a>
                <a href="{{ route('admin.pages.review.edit') }}" class="block py-2 text-xs font-bold text-slate-500 hover:text-brand-cyan transition-colors">{{ __('Client Intel') }}</a>
                <a href="{{ route('admin.pages.search.edit') }}" class="block py-2 text-xs font-bold text-slate-500 hover:text-brand-cyan transition-colors">{{ __('Inquiry Engine') }}</a>
            </div>

            <button onclick="toggleMenu('menuPortfolio','menuPortfolioCaret')" class="w-full flex justify-between items-center px-6 py-3 rounded-2xl text-slate-400 hover:bg-white/5 transition-all group">
                <span class="text-sm font-bold uppercase tracking-widest group-hover:text-white flex items-center gap-4">
                    <span>▣</span> {{ __('Archive Data') }}
                </span>
                <span id="menuPortfolioCaret" class="text-[8px] transition-transform duration-300">▼</span>
            </button>
            <div id="menuPortfolio" class="hidden space-y-1 pl-10 mt-2 border-l border-white/5 ml-6">
                <a href="/admin/portfolio/logo" class="block py-2 text-xs font-bold text-slate-500 hover:text-brand-cyan transition-colors">{{ __('Logos') }}</a>
                <a href="/admin/portfolio/stationery" class="block py-2 text-xs font-bold text-slate-500 hover:text-brand-cyan transition-colors">{{ __('Stationery') }}</a>
                <a href="/admin/portfolio/website" class="block py-2 text-xs font-bold text-slate-500 hover:text-brand-cyan transition-colors">{{ __('Digital Web') }}</a>
                <a href="/admin/portfolio/packaging" class="block py-2 text-xs font-bold text-slate-500 hover:text-brand-cyan transition-colors">{{ __('Packaging') }}</a>
                <a href="/admin/portfolio/feeds" class="block py-2 text-xs font-bold text-slate-500 hover:text-brand-cyan transition-colors">{{ __('Social Feeds') }}</a>
                <a href="/admin/portfolio/other" class="block py-2 text-xs font-bold text-slate-500 hover:text-brand-cyan transition-colors">{{ __('Auxiliary') }}</a>
            </div>
            
            <a href="{{ route('admin.pages.layanan.edit') }}" class="flex items-center gap-4 px-6 py-3 rounded-2xl text-slate-400 hover:bg-white/5 hover:text-white transition-all">
                <span>❖</span> <span class="text-sm font-bold uppercase tracking-widest">{{ __('Services Matrix') }}</span>
            </a>
        </div>
      </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main id="content" class="flex-1 transition-all duration-500 pb-20 overflow-x-hidden">
        {{-- Flash Messages --}}
        @if(session('success') || session('error'))
            <div class="fixed top-24 right-8 z-[100] animate-bounce-in">
                <div class="glass-card px-6 py-4 flex items-center gap-4 border-l-4 {{ session('success') ? 'border-l-brand-cyan bg-brand-cyan/10' : 'border-l-red-500 bg-red-500/10' }}">
                    <span class="text-lg">{{ session('success') ? '✓' : '✕' }}</span>
                    <span class="text-xs font-black uppercase tracking-widest">{{ session('success') ?? session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>
  </div>

  {{-- OVERLAY --}}
  <div id="overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-[58] opacity-0 transition-opacity duration-300" onclick="toggleSidebar()"></div>

  {{-- GLOBAL SCRIPTS --}}
  <script>
    function toggleSidebar() {
      const sb = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      const closed = sb.classList.contains('-translate-x-full');

      if (closed) {
        sb.classList.remove('-translate-x-full');
        sb.classList.add('translate-x-0');
        overlay.classList.remove('hidden');
        setTimeout(() => overlay.classList.add('opacity-100'), 10);
      } else {
        sb.classList.add('-translate-x-full');
        sb.classList.remove('translate-x-0');
        overlay.classList.remove('opacity-100');
        setTimeout(() => overlay.classList.add('hidden'), 300);
      }
    }

    function toggleMenu(id, caretId) {
      const menu = document.getElementById(id);
      const caret = document.getElementById(caretId);
      menu.classList.toggle('hidden');
      if (caret) caret.classList.toggle('rotate-180');
    }

    function toggleUserMenu() {
      document.getElementById('userMenu').classList.toggle('hidden');
    }

    function toggleBell() {
      document.getElementById('notifDropdown').classList.toggle('hidden');
    }

    // Auto-hide alerts
    document.addEventListener('DOMContentLoaded', () => {
        const alerts = document.querySelectorAll('.animate-bounce-in');
        alerts.forEach(a => setTimeout(() => {
            a.style.opacity = '0';
            setTimeout(() => a.remove(), 500);
        }, 4000));

    // Poll for notifications
    function refreshSignals() {
        fetch("{{ route('admin.chats.unread_count') }}")
            .then(r => r.json())
            .then(j => {
                const badge = document.getElementById('notifBadge');
                const list = document.getElementById('notifList');
                
                if (j.total > 0) {
                    badge.style.display = 'flex';
                    badge.textContent = j.total;
                    
                    // Render list
                    let html = '';
                    j.items.forEach(item => {
                        html += `
                            <a href="${item.link}" class="block p-4 border-b border-white/5 hover:bg-white/5 transition-all group">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="text-[10px] font-black uppercase tracking-widest ${item.type === 'chat' ? 'text-brand-cyan' : 'text-brand-violet'}">${item.title}</span>
                                    <span class="text-[9px] text-slate-600">${item.time}</span>
                                </div>
                                <div class="text-xs text-slate-300 font-bold group-hover:text-white transition-colors">${item.desc}</div>
                            </a>
                        `;
                    });
                    list.innerHTML = html;
                } else {
                    badge.style.display = 'none';
                    list.innerHTML = '<div class="p-4 text-xs text-slate-600 block text-center">{{ __("No active signals") }}</div>';
                }
            })
            .catch(e => console.error(e));
    }
    // Faster polling (5s) for real-time feel
    setInterval(refreshSignals, 5000);
    refreshSignals();
    });
  </script>
  @stack('scripts')
</body>
</html>
