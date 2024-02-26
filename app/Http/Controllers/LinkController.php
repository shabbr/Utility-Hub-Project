<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Models\Link;
use Vinkla\Hashids\Facades\Hashids;

class LinkController extends Controller
{
    public function shorten(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

        $originalUrl = $request->input('original_url');

        $link = Link::create([
            'original_url' => $originalUrl,
            'short_url' => $this->generateShortUrl(),
        ]);

        return view('shortUrl', ['shortUrl' => $link->short_url]);
    }

    public function redirect($shortUrl)
    {
        $link = Link::select('original_url')->where('short_url', $shortUrl)->first();
         return redirect($link->original_url);
    }

    public function redirectLink($id){
        $shortUrl="http://127.0.0.1:8000/r/$id";
         $link=Link::select('original_url')->where('short_url',$shortUrl)->first();
         return redirect($link->original_url);
    }

    protected function generateShortUrl()
    {
        $lastLinkId = Link::max('id');
        $hashids = Hashids::encode($lastLinkId + 1);
        return URL::to('/r/' . $hashids);
    }


}
