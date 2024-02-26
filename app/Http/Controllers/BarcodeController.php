<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Milon\Barcode\Facades\DNS2DFacade as DNS2D;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use App\Models\UpceCode;
use Illuminate\Support\Facades\DB;


class BarcodeController extends Controller
{
    public function showForm()
    {
        return view('barcode');
    }

    public function generateAndDownload(Request $request)
    {
        $url = $request->input('url');
        $upceCode=$this->generateUniqueNumber();

        try {
            // Generate PDF417 barcode in PNG format
            $barcodePNG = DNS2D::getBarcodeHTML($url, 'PDF417', 2, 1);

            // Save the PNG barcode to the storage directory
            $filename = Str::random(20) . '_' . uniqid() . '_pdf417.png';
            $test = Storage::disk('public')->put($filename, $barcodePNG);
            if ($test) {
                $code = new UpceCode();
                $code->url = $url;
                $code->upceCode = $upceCode;
                $code->save();
            }
            // Provide a response with the PNG barcode for download
            return view('barcode', ['filename' => $filename, 'barcode' => $barcodePNG,'upceCode'=>$upceCode]);
        } catch (\Exception $e) {
            // Handle exceptions, if any
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function downloadBarcode($filename)
    {
        $path = 'public/' . $filename;

        try {
            // Check if the file exists in the 'public' disk
            if (Storage::disk('public')->exists($filename)) {
                $fileContent = Storage::disk('public')->get($filename);

                // Provide a response with the PNG barcode for download
                return Response::make($fileContent, 200, [
                    'Content-Type' => 'image/png',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                ]);
            } else {
                return redirect()->back()->with('error', 'File not found');
            }
        } catch (\Exception $e) {
            // Handle exceptions, if any
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }



   private function generateUniqueNumber()
{
    do {
        // Generate an 8-digit numeric string
        $uniqueNumber = str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT);

        // Check if the generated number already exists in the database
        $exists = UpceCode::where('upceCode', $uniqueNumber)->exists();

    } while ($exists);

    return $uniqueNumber;
}
}
