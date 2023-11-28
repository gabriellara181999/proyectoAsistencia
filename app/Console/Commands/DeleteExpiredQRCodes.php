<?php

namespace App\Console\Commands;
use App\Models\QR;
use App\Models\asistencia;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteExpiredQRCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qrcodes:clean-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expirationTime = Carbon::now()->subMinutes(1); // Caducidad después de 3 horas
        $qrCodes = QR::where('created_at', '<', $expirationTime)->get();
        
        foreach ($qrCodes as $qrCode) {
            $asistencia=asistencia::where('Qr_id', $qrCode->id)->update(['estado_id' => 2]);
            $rutaAlmacenamiento = storage_path('app/public/qrs/' . $qrCode->ruta);

            if (file_exists($rutaAlmacenamiento)) {
                unlink($rutaAlmacenamiento); // Elimina el archivo
            }
        }
        return Command::SUCCESS;
    }
}
