<?php
// app/Http/Controllers/ScannerController.php - VERSI FIX
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ScannerController extends Controller
{
    // Tampilkan Halaman Menu Pilihan
    public function dashboard()
    {
        $inventoryType = Session::get('inventory_type');
        $userName = Session::get('user_name');
        
        // Buat view baru nanti: resources/views/scanner/menu.blade.php
        return view('scanner.menu', compact('inventoryType', 'userName'));
    }

    // Set Mode Scan lalu lempar ke halaman scanner
    public function setMode($mode)
    {
        // Simpan mode yang dipilih (supervisi, maintenance, atau mutasi)
        Session::put('scan_mode', $mode);
        return redirect()->route('scanner');
    }

    public function index()
    {
        $inventoryType = Session::get('inventory_type');
        $userName = Session::get('user_name');
        
        // Ambil mode dari session, default ke supervisi jika kosong
        $scanMode = Session::get('scan_mode', 'supervisi');
        
        // Cek jika user mencoba akses scanner langsung tanpa pilih mode
        if (!Session::has('scan_mode')) {
            return redirect()->route('dashboard');
        }
        
        return view('scanner.index', compact('inventoryType', 'userName', 'scanMode'));
    }
    
    public function getItemDetail(Request $request)
    {
        $scannedData = $request->input('qr_code');
        $connection = Session::get('db_connection');
        $inventoryType = Session::get('inventory_type');
        
        // Extract ID dari QR Code URL
        $itemId = $this->extractIdFromUrl($scannedData);
        $tableName = $this->getTableName($inventoryType);
        
        if (!$itemId) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code tidak valid (harus berisi ID angka)'
            ], 400);
        }
        
        // 🚀 DYNAMIC TABLE NAME BERDASARKAN .env
        $tableName = $this->getTableName($inventoryType);
        
        try {
            // Cari item berdasarkan ID dan nama tabel yang benar
            $item = DB::connection($connection)
                ->table('perangkats')
                ->leftJoin('kondisis', 'perangkats.kondisi_id', '=', 'kondisis.id')
                ->leftJoin('lokasis', 'perangkats.lokasi_id', '=', 'lokasis.id')
                ->select(
                    'perangkats.id',
                    'perangkats.nomor_inventaris',
                    'perangkats.nama_perangkat',
                    'kondisis.nama_kondisi',
                    'lokasis.nama_lokasi'
                )
                ->where('perangkats.id', $itemId)
                ->first();
                
            if (!$item) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Perangkat ID {$itemId} tidak ditemukan di {$tableName}"
                ], 404);
            }
            
            // Format data response
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $item->id,
                    'nomor_inventaris' => $item->nomor_inventaris ?? '-',
                    'nama_perangkat' => $item->nama_perangkat ?? '-',
                    'nama_kondisi' => $item->nama_kondisi ?? '-',
                    'nama_lokasi' => $item->nama_lokasi ?? '-',
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tabel tidak ditemukan: ' . $tableName . ' (' . $e->getMessage() . ')'
            ], 500);
        }
    }
    
    /**
     * Ambil nama tabel berdasarkan inventory type dari .env
     */
    private function getTableName($type)
    {
        $tableKey = strtoupper($type) . '_TABLE_PERANGKAT';
        $tableName = env($tableKey, 'perangkats'); // Default: perangkats
        
        return $tableName;
    }
    
    private function extractIdFromUrl($scannedData)
    {
        if (is_numeric($scannedData)) {
            return (int)$scannedData;
        }
        
        if (filter_var($scannedData, FILTER_VALIDATE_URL)) {
            $path = parse_url($scannedData, PHP_URL_PATH);
            $segments = array_filter(explode('/', trim($path, '/')));
            $lastSegment = end($segments);
            
            return is_numeric($lastSegment) ? (int)$lastSegment : null;
        }
        
        return null;
    }
    
    public function supervisi(Request $request)
    {
        $connection = Session::get('db_connection');
        $userId = Session::get('user_id');
        
        $request->validate(['item_id' => 'required|numeric']);
        
        DB::connection($connection)
            ->table('supervisi')
            ->insert([
                'perangkat_id' => $request->item_id,
                'user_id' => $userId,
                'tanggal' => now(),
                'keterangan' => $request->keterangan ?? '',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
        return response()->json([
            'status' => 'success',
            'message' => 'Supervisi berhasil disimpan!'
        ]);
    }
}
