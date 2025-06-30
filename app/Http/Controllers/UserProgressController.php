<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\UserProgressService; // Import Service
use App\Models\CobitItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use PDF;

class UserProgressController extends Controller
{
    protected $progressService;

    // Suntikkan service melalui constructor (Dependency Injection)
    public function __construct(UserProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    /**
     * Menampilkan halaman progres untuk user yang sedang login.
     */
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        // --- Logika Gerbang untuk memastikan semua audit selesai ---
        $items = CobitItem::where('is_visible', true)->get();
        foreach ($items as $item) {
            if (!$item->isCompletedByUser($user)) {
                return redirect()->route('audit.index')
                    ->with('warning', 'Anda harus menyelesaikan semua level audit untuk melihat halaman progres.');
            }
        }

        // Panggil service untuk mendapatkan data progres
        $progressData = $this->progressService->getProgressData($user);

        return view('user.progress.index', compact('user', 'progressData'));
    }

    /**
     * Menangani download PDF untuk user yang sedang login.
     */
    public function downloadPDF()
    {
        $user = Auth::user();

        $progressData = $this->progressService->getProgressData($user);

        $data = [
            'user' => $user,
            'progressData' => $progressData,
            'tanggalCetak' => now()->translatedFormat('d F Y')
        ];

        $pdf = PDF::loadView('user.progress.download.downloadPDF', $data);
        $fileName = 'Laporan Progres - ' . $user->name . '.pdf';

        return $pdf->stream($fileName);
    }
}
