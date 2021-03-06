<?php

namespace App\Http\Controllers;

class LocalizationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($language)
    {
        request()->session()->put('locale', $language);
        return redirect()->back();
    }
}
