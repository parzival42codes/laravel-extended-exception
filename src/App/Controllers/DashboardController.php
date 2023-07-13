<?php

namespace parzival42codes\LaravelExtendedException\App\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): Renderable
    {
        /** @var string $extendedException */
        $extendedException = request()->post('extendedException');

        $jsonPrettyPrint = '';
        if ($extendedException) {
            $json = json_decode(base64_decode($extendedException), true);
            $jsonPrettyPrint = json_encode($json, JSON_PRETTY_PRINT);
        }

        return view('extended-exception::extendedException', [
            'extendedException' => $extendedException,
            'extendedExceptionJsonPrettyPrint' => $jsonPrettyPrint,
        ]);
    }
}
