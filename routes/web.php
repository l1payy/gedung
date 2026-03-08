<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $now = now()->startOfMonth();
    $min = $now->copy();
    $max = $now->copy()->addMonths(11);

    $monthParam = request()->query('month');
    if ($monthParam && preg_match('/^\d{4}-\d{2}$/', $monthParam)) {
        $current = \Carbon\Carbon::createFromFormat('Y-m', $monthParam)->startOfMonth();
    } else {
        $current = $now->copy();
    }
    if ($current->lt($min)) $current = $min->copy();
    if ($current->gt($max)) $current = $max->copy();

    $start = $current->copy()->startOfMonth()->toDateString();
    $end = $current->copy()->endOfMonth()->toDateString();

    $bookings = \App\Models\Booking::whereBetween('tanggal', [$start, $end])
        ->get()
        ->groupBy(function ($b) {
            return ($b->tanggal instanceof \Carbon\Carbon)
                ? $b->tanggal->toDateString()
                : \Carbon\Carbon::parse($b->tanggal)->toDateString();
        });

    $prev = $current->copy()->subMonth();
    $next = $current->copy()->addMonth();
    $allowPrev = $prev->gte($min);
    $allowNext = $next->lte($max);

    return view('home', [
        'bookings' => $bookings,
        'currentMonth' => $current,
        'minMonth' => $min,
        'maxMonth' => $max,
        'prevMonth' => $prev,
        'nextMonth' => $next,
        'allowPrev' => $allowPrev,
        'allowNext' => $allowNext,
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/printable', [BookingController::class, 'printable'])->name('bookings.printable');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/bukti', [AdminBookingController::class, 'downloadBukti'])->name('bookings.bukti');
    Route::post('/bookings/{booking}/approve', [AdminBookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [AdminBookingController::class, 'reject'])->name('bookings.reject');
    Route::get('/bookings/export/csv', [AdminBookingController::class, 'exportCsv'])->name('bookings.export.csv');
    Route::get('/bookings/export/pdf', [AdminBookingController::class, 'exportPdf'])->name('bookings.export.pdf');
});

require __DIR__.'/auth.php';
