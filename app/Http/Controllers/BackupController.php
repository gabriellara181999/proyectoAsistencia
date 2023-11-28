<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Backup\BackupDestination\BackupDestination;
use Spatie\Backup\Helpers\Format;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;
use Spatie\Backup\BackupService;

class BackupController extends Controller
{
    public function create()
    {

            // Obtener nombre de BD  
        $dbname = env('DB_DATABASE'); 
        
        // Archivo de respaldo
        $backup_file = $dbname . date("Y-m-d-H-i-s") . '.psql';
        $pgDumpPath = 'C:/laragon/bin/postgresql/postgresql-15.3-4/bin/pg_dump.exe';
        $database = env('DB_DATABASE');
        $backupFile = storage_path("app/public/backup/{$backup_file}");
        $username = env('DB_USERNAME');
        $host = env('DB_HOST');
        $port = env('DB_PORT');
        
        $command = "\"{$pgDumpPath}\" --dbname={$database} --column-inserts --file=\"{$backupFile}\" --clean --create --username={$username} --host={$host} --port={$port}";
            
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            // Handle error, log, or display a message
            return response()->json(['Error'=>true, 'message'=>'error',404]);
        } else {
            // Backup was successful
            return response()->json(['success' => true, 'message' => 'Operación exitosa'], 200);
        }
    }

}
