<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminGameController extends Controller
{
    public function index()
    {
        return view('admin.games');
    }
}