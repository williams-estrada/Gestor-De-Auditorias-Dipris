<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Licitacion;
use App\Models\Usuarios;
use App\Models\Documentos;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;
class DescargarController extends Controller
{
    public function download_all(){
        $storagePath = storage_path('app/public/Docs');
        $zipFileName = 'documentos licitaciones.zip';
        $zip = new ZipArchive();

        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $files = File::allFiles($storagePath);
    
            foreach ($files as $file) {
                $zip->addFile($file->getRealPath(), $file->getRelativePathname());
            }
            $zip->close();

            return Response::download($zipFileName)->deleteFileAfterSend();
        } else {
            return 'No se pudo descargar el archivo';
        }
    }

    public function createZip(string $id)
    {
        $licitacion = Licitacion::find($id);
        // Consulta la base de datos para obtener las rutas de los archivos
        $filePaths = Documentos::where("licitacion_id","=",$licitacion->id)
                                ->pluck('ruta_documento')->toArray(); // Asegúrate de ajustar esto según tu modelo y columna
        //dump($filePaths);
        // Crea un archivo ZIP temporal
        $zip = new ZipArchive;
        $zipFileName = $licitacion->folio."-".$licitacion->nombre."-".$licitacion->area.".zip";
        $zipFilePath = storage_path($zipFileName);

        $existen = false;

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // Agrega los archivos al ZIP
            foreach ($filePaths as $filePath) {
                if($filePath != ""){
                    $fileContent = Storage::get($filePath);
                    $zip->addFromString(basename($filePath), $fileContent);
                    $existen = true;
                }
            }
            $zip->close();
            // Descarga el archivo ZIP
            if($existen){
                return response()->download($zipFilePath)->deleteFileAfterSend(true);
            }
            else{
                $fecha_ini = "";
                $fecha_fin = "";
                $licitaciones = Licitacion::where('id', $id)->get();
                $usuarios = Usuarios::all();
                return view("Program.Licitacion.busqueda", compact('licitaciones', 'usuarios', 'fecha_ini', 'fecha_fin'));
                
                //return back()->with('status', 'La licitación no contiene archivos');
            }
            
        } else {
            return back()->with('status', 'Error al crear archivo zip');
        }
    }

    public function downloadLargeFile($filePath)
{
    $file = Storage::disk('public')->get($filePath);

    return response()->streamDownload(function () use ($file) {
        echo $file;
    }, 'filename.ext');
}
    
}