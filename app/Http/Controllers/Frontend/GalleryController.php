<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index()
    {
        return view('frontend.gallery.index');
    }
}