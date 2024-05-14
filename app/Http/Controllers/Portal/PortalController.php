<?php

namespace App\Http\Controllers\Portal;

use App\Models\CMS\Galeria;
use App\Http\Controllers\Controller;

class PortalController extends Controller
{
    public $table;

    public function __construct()
    {
        $this->table = new Galeria();
    }

    public function index()
    {
        return view('portal.index');
    }
}
