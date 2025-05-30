<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\JawabanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\CobitItemController;
use App\Http\Controllers\QuisionerController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ResubmissionRequestController;
use App\Http\Controllers\UserProgressController;


// Main routes
Route::get('/', function () {
    return view('auth/login');
});

// Dashboard yang bisa diakses semua user yg sudah login & verified
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});

// User profile routes - semua user yg login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes - hanya untuk role admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin dashboard
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // User approval
    Route::get('/admin/approvals', [AdminController::class, 'showApprovals'])->name('admin.approvals');
    Route::patch('/admin/approve/{id}', [AdminController::class, 'approveUser'])->name('admin.approve');

    // CRUD Cobit Item
    Route::get('/cobititem/create', [CobitItemController::class, 'create'])->name('cobititem.create');
    Route::post('/cobititem', [CobitItemController::class, 'store'])->name('cobititem.store');
    Route::get('/cobititem', [CobitItemController::class, 'index'])->name('cobititem.index');
    Route::get('/cobititem/{id}/edit', [CobitItemController::class, 'edit'])->name('cobititem.edit');
    Route::put('/cobititem/{id}', [CobitItemController::class, 'update'])->name('cobititem.update');
    Route::delete('/cobititem/{id}', [CobitItemController::class, 'destroy'])->name('cobititem.destroy');

    // Resource routes kategori, level, quisioner
    Route::resource('kategori', KategoriController::class);
    Route::resource('level', LevelController::class);
    Route::resource('quisioner', QuisionerController::class);

    Route::get('/resubmission-requests', [ResubmissionRequestController::class, 'adminIndex'])->name('resubmissions.index');
    Route::post('/resubmission-requests/{resubmissionRequest}/approve', [ResubmissionRequestController::class, 'approve'])->name('resubmissions.approve');
    Route::post('/resubmission-requests/{resubmissionRequest}/reject', [ResubmissionRequestController::class, 'reject'])->name('resubmissions.reject');
});

// User routes - hanya untuk role user
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
    Route::post('/levels/{level}/request-resubmission', [ResubmissionRequestController::class, 'store'])->name('resubmission.request');

    // Audit routes user
    Route::get('/audit', [AuditController::class, 'index'])->name('audit.index');
    Route::get('/audit/{cobitItem}', [AuditController::class, 'showCategories'])->name('audit.showCategories');
    Route::get('/audit/{cobitItem}/{kategori}', [AuditController::class, 'showLevels'])->name('audit.showLevels');
    Route::get('/audit/{cobitItem}/{kategori}/{level}', [AuditController::class, 'showQuisioner'])->name('audit.showQuisioner');
    Route::post('/audit/{level}/jawaban', [JawabanController::class, 'store'])->name('jawaban.store');
    Route::get('/my-progress', [UserProgressController::class, 'index'])->name('user.progress');
});

// Halaman waiting approval
Route::get('/waiting-approval', function () {
    return view('waiting-approval');
})->name('waiting-approval');

require __DIR__ . '/auth.php';
