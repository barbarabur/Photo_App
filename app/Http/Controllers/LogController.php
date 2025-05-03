<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    public function index()
    {
        // Ruta del archivo de logs
        $logFile = storage_path('logs/laravel.log');

        if (File::exists($logFile)) {
            $logs = File::get($logFile);
        } else {
            $logs = 'No hay logs disponibles.';
        }

        return view('logs.index', compact('logs'));
    }
}
