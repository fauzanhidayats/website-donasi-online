<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Donatur\DonasiController;
use App\Http\Controllers\Admin\DataDonasiController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Donatur\DonasiUserController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\LaporanAdminDonasiController;
use App\Http\Controllers\Donatur\ProfileDonaturController;
use App\Http\Controllers\Admin\LaporanAdminEventController;
use App\Http\Controllers\Admin\LaporanAdminPengajuanController;
use App\Http\Controllers\Donatur\PengajuanDonasiController;
use App\Http\Controllers\Donatur\DashboardDonaturController;
use App\Http\Controllers\Pimpinan\ProfilePimpinanController;
use App\Http\Controllers\Admin\PengajuanDonasiAdminController;
use App\Http\Controllers\Home\AllEventController;
use App\Http\Controllers\Home\DetailEventController;
use App\Http\Controllers\Pimpinan\DashboardPimpinanController;
use App\Http\Controllers\Pimpinan\LaporanPimpinanDonasiController;
use App\Http\Controllers\Pimpinan\LaporanPimpinanEventController;
use App\Http\Controllers\Pimpinan\LaporanPimpinanPengajuanController;
use App\Http\Controllers\Pimpinan\PengajuanDonasiPimpinanController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', function () {
    return view('front-end.tentang-kami');
})->name('tentang-kami');

Route::get('/donasi/menunggu', [DonasiController::class, 'menunggu'])->name('donasi.menunggu');
Route::get('/donasi/sukses', [DonasiController::class, 'sukses'])->name('donasi.sukses');
// Menampilkan form donasi
Route::get('/donasi/create', [DonasiController::class, 'create'])->name('donasi.create');
// Proses pembayaran (generate Snap token)
Route::post('/donasi/pay', [DonasiController::class, 'pay'])->name('donasi.pay');
Route::get('/detail-event{id}', [DetailEventController::class, 'show'])->name('detail-event.show');
Route::get('/all-event', [AllEventController::class, 'index'])->name('all-event.index');

// Guest routes (belum login)
Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Admin
    Route::prefix('/dashboard/admin')->middleware('role:admin')->group(function () {
        Route::get('/', [DashboardAdminController::class, 'index'])->name('dashboard.admin');
        Route::resource('/users', UserController::class);

        Route::get('/data-donasi', [DataDonasiController::class, 'index'])->name('admin.data-donasi');
        Route::resource('/event', EventController::class);

        Route::get('/pengajuan-donasi', [PengajuanDonasiAdminController::class, 'index'])->name('admin.pengajuan.index');
        Route::get('/pengajuan-donasi/{id}', [PengajuanDonasiAdminController::class, 'show'])->name('admin.pengajuan.show');
        Route::patch('/pengajuan-donasi/{id}/status', [PengajuanDonasiAdminController::class, 'updateStatus'])->name('admin.pengajuan.updateStatus');
        // Profile admin
        Route::get('/profile', [ProfileAdminController::class, 'index'])->name('admin.profile');
        Route::put('/profile', [ProfileAdminController::class, 'update'])->name('admin.profile.update');

        // Laporan Event
        Route::get('/laporan-event', [LaporanAdminEventController::class, 'index'])->name('admin.laporan.event.index');
        Route::post('/laporan/event', [LaporanAdminEventController::class, 'laporanEvent'])->name('admin.laporan.event');
        Route::get('/laporan/event/pdf', [LaporanAdminEventController::class, 'cetakEventPDF'])->name('admin.laporan.event.pdf');

        // Laporan Pengajuan
        Route::get('/laporan-pengajuan', [LaporanAdminPengajuanController::class, 'index'])->name('admin.laporan.pengajuan.index');
        Route::post('/laporan/pengajuan', [LaporanAdminPengajuanController::class, 'laporanPengajuan'])->name('admin.laporan.pengajuan');
        Route::get('/laporan/pengajuan/pdf', [LaporanAdminPengajuanController::class, 'cetakPengajuanPDF'])->name('admin.laporan.pengajuan.pdf');

        // Laporan Donasi
        Route::get('/laporan-donasi', [LaporanAdminDonasiController::class, 'index'])->name('admin.laporan.donasi.index');
        Route::post('/laporan/donasi', [LaporanAdminDonasiController::class, 'laporanDonasi'])->name('admin.laporan.donasi');
        Route::get('/laporan/donasi/pdf', [LaporanAdminDonasiController::class, 'cetakDonasiPDF'])->name('admin.laporan.donasi.pdf');
    });

    // Dashboard Donatur (Peminjam)
    Route::prefix('/dashboard/donatur')->middleware('role:donatur')->group(function () {
        Route::get('/', [DashboardDonaturController::class, 'index'])->name('dashboard.donatur');

        Route::get('/data-donasi', [DonasiUserController::class, 'index'])->name('donatur.data-donasi');
        Route::resource('/pengajuan-donasi', PengajuanDonasiController::class);
        // Profile Donatur
        Route::get('/profile', [ProfileDonaturController::class, 'index'])->name('donatur.profile');
        Route::put('/profile', [ProfileDonaturController::class, 'update'])->name('donatur.profile.update');
    });

    // Dashboard Pimpinan
    Route::prefix('/dashboard/pimpinan')->middleware('role:pimpinan')->group(function () {
        Route::get('/', [DashboardPimpinanController::class, 'index'])->name('dashboard.pimpinan');

        Route::get('/pengajuan-donasi', [PengajuanDonasiPimpinanController::class, 'index'])->name('pimpinan.pengajuan.index');
        Route::get('/pengajuan-donasi/{id}', [PengajuanDonasiPimpinanController::class, 'show'])->name('pimpinan.pengajuan.show');
        Route::patch('/pengajuan-donasi/{id}/status', [PengajuanDonasiPimpinanController::class, 'updateStatus'])->name('pimpinan.pengajuan.updateStatus');
        // Profile Pimpinan
        Route::get('/profile', [ProfilePimpinanController::class, 'index'])->name('pimpinan.profile');
        Route::put('/profile', [ProfilePimpinanController::class, 'update'])->name('pimpinan.profile.update');

        // Laporan Event
        Route::get('/laporan-event', [LaporanPimpinanEventController::class, 'index'])->name('pimpinan.laporan.event.index');
        Route::post('/laporan/event', [LaporanPimpinanEventController::class, 'laporanEvent'])->name('pimpinan.laporan.event');
        Route::get('/laporan/event/pdf', [LaporanPimpinanEventController::class, 'cetakEventPDF'])->name('pimpinan.laporan.event.pdf');

        // Laporan Pengajuan
        Route::get('/laporan-pengajuan', [LaporanPimpinanPengajuanController::class, 'index'])->name('pimpinan.laporan.pengajuan.index');
        Route::post('/laporan/pengajuan', [LaporanPimpinanPengajuanController::class, 'laporanPengajuan'])->name('pimpinan.laporan.pengajuan');
        Route::get('/laporan/pengajuan/pdf', [LaporanPimpinanPengajuanController::class, 'cetakPengajuanPDF'])->name('pimpinan.laporan.pengajuan.pdf');

        // Laporan Donasi
        Route::get('/laporan-donasi', [LaporanPimpinanDonasiController::class, 'index'])->name('pimpinan.laporan.donasi.index');
        Route::post('/laporan/donasi', [LaporanPimpinanDonasiController::class, 'laporanDonasi'])->name('pimpinan.laporan.donasi');
        Route::get('/laporan/donasi/pdf', [LaporanPimpinanDonasiController::class, 'cetakDonasiPDF'])->name('pimpinan.laporan.donasi.pdf');
    });
});
