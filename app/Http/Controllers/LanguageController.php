<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        if (in_array($locale, ['ru', 'ro'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    }
}