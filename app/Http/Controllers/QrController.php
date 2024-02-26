<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\QR;
use Illuminate\Support\Facades\Response;

class QrController extends Controller
{

    public function qrCodeForm() {
        return view('qrcode');
    }
    public function generateQrCode(Request $request)
    {
        $url = $request->input('url');
    if (!$url) {
        return redirect()->back()->with('error', 'Please provide a URL.');
    }
   //$qrCode = QrCode::format('png')->size(300)->generate($url);
   //uncomment it to run without imagic and comment to above line
    $qrCode = QrCode::size(100)->generate($url);
    $filename = Str::random(20) . '_' . uniqid() . '.png';
    try {
        // Store the file in the 'public' disk
        Storage::disk('public')->put($filename, $qrCode);

        // Check if the file exists in the 'public' disk
        if (Storage::disk('public')->exists($filename)) {
         return view('qrcode', compact('filename','qrCode'));
        } else {
            return redirect()->back()->with('error', 'Failed to save the QR code image.');
        }
    } catch (\Exception $e) {
        // Handle exceptions, if any
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }

    }

        public function download($url)
        {
           $path = 'public/' . $url;
        if (Storage::exists($path)) {
            $fileContent = Storage::get($path);

            return Response::make($fileContent, 200, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'attachment; filename="' . $url . '"',
            ]);
        } else {
            abort(404, 'File not found');
        }
        }

}
