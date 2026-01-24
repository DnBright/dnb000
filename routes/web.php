<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\CustomerAuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// ================= CUSTOMER =================
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');

// ================= CUSTOMER LOGIN/DASHBOARD =================
// NOTE: login routes are handled by UserAuthController below to avoid duplicate /login routes
Route::get('/dashboard', function(){ return view('landing'); })->name('dashboard');

// Register (show + submit)
Route::get('/register', function(){ return view('auth.register'); })->name('register');

Route::post('/register', function(\Illuminate\Http\Request $request){
	$data = $request->validate([
		'name' => 'required|string|max:255',
		'email' => 'required|email|unique:users,email',
		'no_hp' => 'nullable|string|max:32',
		'alamat' => 'nullable|string|max:1024',
		'password' => 'required|string|min:6|confirmed'
	]);

	$user = User::create([
		'name' => $data['name'],
		'nama' => $data['name'],
		'email' => $data['email'],
		'no_hp' => $data['no_hp'] ?? '',
		'alamat' => $data['alamat'] ?? '',
		'password' => Hash::make($data['password']),
	]);

	Auth::login($user);

	return redirect()->route('dashboard');

})->name('register.submit');

// Public pages
Route::get('/', function(){ return view('landing'); })->name('home');
Route::get('/portfolio', function(){ return view('portfolio'); })->name('portfolio');
Route::get('/paket', function(){
	$page = App\Models\Page::where('key','layanan')->first();
	$c = $page->content ?? [];
	return view('paket', ['c' => $c]);
})->name('paket');
Route::get('/contact', function(){ return view('contact'); })->name('contact');
Route::get('/search', function(){
	$page = App\Models\Page::where('key','search')->first();
	$c = $page->content ?? [];
	return view('search', ['c'=>$c]);
})->name('search');

// Brief & Review
use App\Http\Controllers\BriefController;

Route::get('/brief/{paket}', function($paket){
	return view('brief', ['paket' => $paket]);
})->name('brief.show');

// Layanan detail page
use App\Http\Controllers\ServiceController;
Route::get('/layanan/{paket}', [ServiceController::class, 'show'])->name('layanan.show');

Route::post('/brief/review', [BriefController::class, 'review'])->name('brief.review');
Route::get('/review', [BriefController::class, 'show'])->name('review.show');

// Payment / Order
Route::post('/payment', [BriefController::class, 'checkout'])->name('payment.process');
Route::get('/payment/{order}', [BriefController::class, 'paymentShow'])->name('payment.show');

// Midtrans token endpoint (AJAX) - returns snap token
use App\Http\Controllers\PaymentController;
Route::post('/midtrans/token/{order}', [PaymentController::class, 'token'])->name('midtrans.token');

// ================= ADMIN =================
Route::prefix('admin')->group(function () {
	// Login
	Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
	Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

	// Logout (POST recommended)
	Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

	// Protected admin routes (uses custom AdminAuth middleware to redirect to admin login)
	Route::middleware([\App\Http\Middleware\AdminAuth::class])->group(function () {
		Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
		Route::get('/dashboard/chart-data', [AdminDashboardController::class, 'chartData'])->name('admin.dashboard.chart_data');
		Route::get('/chats/unread-count', [AdminDashboardController::class, 'unreadChats'])->name('admin.chats.unread_count');
		Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
		Route::get('/orders/report', [AdminOrderController::class, 'report'])->name('admin.orders.report');
		Route::get('/orders/export', [AdminOrderController::class, 'export'])->name('admin.orders.export');
		Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
		Route::post('/orders/{order}/revision-upload', [AdminOrderController::class, 'receiveRevisionFile'])->name('admin.orders.revision.upload');
		Route::get('/orders/{order}/chat', [AdminOrderController::class, 'chatFetch'])->name('admin.orders.chat.fetch');
		Route::post('/orders/{order}/chat', [AdminOrderController::class, 'chatSend'])->name('admin.orders.chat.send');
		Route::post('/orders/{order}/deliver', [AdminOrderController::class, 'deliver'])->name('admin.orders.deliver');
		Route::get('/orders/{order}/invoice', [AdminOrderController::class, 'invoice'])->name('admin.orders.invoice');
		Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update_status');
		Route::post('/orders/{order}/payment', [AdminOrderController::class, 'updatePaymentStatus'])->name('admin.orders.update_payment');
		// Pages (home management)
		Route::get('/pages/home', [\App\Http\Controllers\Admin\PageController::class, 'editHome'])->name('admin.pages.home.edit');
		Route::put('/pages/home', [\App\Http\Controllers\Admin\PageController::class, 'updateHome'])->name('admin.pages.home.update');
        // Pages (services management)
        Route::get('/pages/services', [\App\Http\Controllers\Admin\PageController::class, 'editServices'])->name('admin.pages.services.edit');
        Route::put('/pages/services', [\App\Http\Controllers\Admin\PageController::class, 'updateServices'])->name('admin.pages.services.update');
		// Pages (top designers management)
		Route::get('/pages/top-designers', [\App\Http\Controllers\Admin\PageController::class, 'editTopDesigners'])->name('admin.pages.top_designers.edit');
		Route::put('/pages/top-designers', [\App\Http\Controllers\Admin\PageController::class, 'updateTopDesigners'])->name('admin.pages.top_designers.update');
		// Pages (templates management)
		Route::get('/pages/templates', [\App\Http\Controllers\Admin\PageController::class, 'editTemplates'])->name('admin.pages.templates.edit');
		Route::put('/pages/templates', [\App\Http\Controllers\Admin\PageController::class, 'updateTemplates'])->name('admin.pages.templates.update');
		// Pages (reviews management)
		Route::get('/pages/review', [\App\Http\Controllers\Admin\PageController::class, 'editReview'])->name('admin.pages.review.edit');
		Route::put('/pages/review', [\App\Http\Controllers\Admin\PageController::class, 'updateReview'])->name('admin.pages.review.update');

		// Portfolio (logo)
		Route::get('/portfolio/logo', [\App\Http\Controllers\Admin\PageController::class, 'editPortfolioLogo'])->name('admin.portfolio.logo.edit');
		Route::put('/portfolio/logo', [\App\Http\Controllers\Admin\PageController::class, 'updatePortfolioLogo'])->name('admin.portfolio.logo.update');

		// Portfolio other categories
		Route::get('/portfolio/stationery', [\App\Http\Controllers\Admin\PageController::class, 'editPortfolioStationery'])->name('admin.portfolio.stationery.edit');
		Route::put('/portfolio/stationery', [\App\Http\Controllers\Admin\PageController::class, 'updatePortfolioStationery'])->name('admin.portfolio.stationery.update');

		Route::get('/portfolio/website', [\App\Http\Controllers\Admin\PageController::class, 'editPortfolioWebsite'])->name('admin.portfolio.website.edit');
		Route::put('/portfolio/website', [\App\Http\Controllers\Admin\PageController::class, 'updatePortfolioWebsite'])->name('admin.portfolio.website.update');

		Route::get('/portfolio/packaging', [\App\Http\Controllers\Admin\PageController::class, 'editPortfolioPackaging'])->name('admin.portfolio.packaging.edit');
		Route::put('/portfolio/packaging', [\App\Http\Controllers\Admin\PageController::class, 'updatePortfolioPackaging'])->name('admin.portfolio.packaging.update');

		Route::get('/portfolio/feeds', [\App\Http\Controllers\Admin\PageController::class, 'editPortfolioFeeds'])->name('admin.portfolio.feeds.edit');
		Route::put('/portfolio/feeds', [\App\Http\Controllers\Admin\PageController::class, 'updatePortfolioFeeds'])->name('admin.portfolio.feeds.update');

		Route::get('/portfolio/other', [\App\Http\Controllers\Admin\PageController::class, 'editPortfolioOther'])->name('admin.portfolio.other.edit');
		Route::put('/portfolio/other', [\App\Http\Controllers\Admin\PageController::class, 'updatePortfolioOther'])->name('admin.portfolio.other.update');
        // Pages (search management)
        Route::get('/pages/search', [\App\Http\Controllers\Admin\PageController::class, 'editSearch'])->name('admin.pages.search.edit');
		Route::put('/pages/search', [\App\Http\Controllers\Admin\PageController::class, 'updateSearch'])->name('admin.pages.search.update');

		// Pages (layanan management)
		Route::get('/pages/layanan', [\App\Http\Controllers\Admin\PageController::class, 'editLayanan'])->name('admin.pages.layanan.edit');
		Route::put('/pages/layanan', [\App\Http\Controllers\Admin\PageController::class, 'updateLayanan'])->name('admin.pages.layanan.update');

		Route::post('/pages/sync', [\App\Http\Controllers\Admin\PageController::class, 'sync'])->name('admin.pages.sync');
		// Customers CRUD
		Route::get('/customers', [AdminUserController::class, 'index'])->name('admin.customers');
		Route::get('/customers/create', [AdminUserController::class, 'create'])->name('admin.customers.create');
		Route::post('/customers', [AdminUserController::class, 'store'])->name('admin.customers.store');
		Route::get('/customers/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.customers.edit');
		Route::put('/customers/{user}', [AdminUserController::class, 'update'])->name('admin.customers.update');
		Route::delete('/customers/{user}', [AdminUserController::class, 'destroy'])->name('admin.customers.destroy');
	});
});

use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\User\UserOrderController;

// User authentication routes (named 'login' to match framework expectations)
Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [UserAuthController::class, 'logout'])->name('user.logout');

// User orders (authenticated)
Route::middleware('auth')->group(function(){
	Route::get('/user/orders', [UserOrderController::class, 'index'])->name('user.orders');
	Route::get('/user/orders/updates', [UserOrderController::class, 'updates'])->name('user.orders.updates');

		// User cancel / delete orders
		Route::post('/user/orders/{order}/cancel', [UserOrderController::class, 'cancel'])->name('user.orders.cancel');
		Route::delete('/user/orders/{order}', [UserOrderController::class, 'destroy'])->name('user.orders.destroy');

		// User profile update
		Route::put('/user/profile', [App\Http\Controllers\User\UserAuthController::class, 'updateProfile'])->name('user.profile.update');

		// Order revision routes (user)
		Route::get('/user/orders/{order}/revision', [UserOrderController::class, 'showRevision'])->name('user.orders.revision.show');
		Route::post('/user/orders/{order}/revision', [UserOrderController::class, 'submitRevision'])->name('user.orders.revision.submit');


		// user chat for order revisions
		Route::get('/user/orders/{order}/chat', [UserOrderController::class, 'chatFetch'])->name('user.orders.chat.fetch');
		Route::post('/user/orders/{order}/chat', [UserOrderController::class, 'chatSend'])->name('user.orders.chat.send');

        // Invoice
        Route::get('/orders/{order}/invoice', [UserOrderController::class, 'printInvoice'])->name('user.orders.invoice');
});



// NOTE: admin routes are declared above using the 'admin' middleware and prefix.