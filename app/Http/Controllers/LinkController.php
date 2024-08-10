<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkRequest;
use App\Models\Link;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class LinkController extends Controller
{
    protected $model;

    public function __construct(Link $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $shorten = $this->model->get();

        return view('links.index', compact('shorten'));
    }

    public function create()
    {
        return view('links.create');
    }

    public function store(LinkRequest $request)
    {
        // Set title
        $title = $request->title;

        // Jika input title tidak diisikan
        // Ambil title berdasarkan url (website)
        if(empty($request->title)){
            $title = $this->getNameUrl($request->destination);
        }
        
        $link = $request->custom_link;
        // Jika input custom_link kosong
        if(empty($request->custom_link) || $link == null){
            // String random
            $link = Str::random(7);
            // Check link
            $checkLink = $this->getCheckLink($link);
            if($checkLink){
                $link = $link.Str::random(2);
            }
        }

        $link = $this->model->create([
            'title' => $title,
            'slug'  => $link,
            'destination' => $request->destination,
        ]);

        return to_route('links')->with('success', 'Link telah berhasil dibuat!');
    }

    public function show($slug)
    {
        $link = $this->model->where('slug', $slug)->first();

        if($link){
            $link->increment('visitor');
            $link->save();
            return view('links.show', ['destination' => $link->destination]);
        }
        
        return abort(404);
    }

    public function edit($slug)
    {
        $link = $this->model->where('slug', $slug)->first();

        return view('links.edit', compact('link'));
    }

    public function update(LinkRequest $request, $slug)
    {
        $this->model->where('slug', $slug)->update([
            'title' => $request->title,
            'slug'  => $request->slug,
            'destination' => $request->destination,
        ]);

        return to_route('links.index')->with('success', 'Link telah berhasil diupdate!');
    }

    public function delete(Request $request, $slug)
    {
        if($request->confirm == 'delete'){
            $this->model->where('slug', $slug)->delete();
            return to_route('links.index')->with('success', 'Link telah berhasil dihapus!');
        }
        return to_route('links.index')->with('failed', 'Link gagal dihapus');
    }

    public function getNameUrl($url)
    {
        // Mengambil data dari URL lain
        $response = Http::get($url);
        // Mengecek apakah respon sukses
        if ($response->successful()) {
                $htmlContent = $response->body();
                // Memuat HTML ke dalam DOMDocument
                $dom = new DOMDocument();
                @$dom->loadHTML($htmlContent);
                // Mendapatkan title dari tag <title>
                $title = $dom->getElementsByTagName('title')->item(0)->textContent;
                return $title;
        }
        return false;
    }

    public function getCheckLink($link)
    {
        $check = Link::where('slug', $link)->first();

        return $check;
    }

}
