<?php
namespace App\Http\Controllers\Locale;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    public function setLocale($locale)
    {
        if (in_array($locale, ['en', 'fr'])) {
            App::setLocale($locale);
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }
}
