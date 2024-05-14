<?php

namespace App\Http\Controllers\CMS;

use App\Http\Traits\LogTrait;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    use LogTrait;
    public $title;

    public function __construct()
    {
        $this->title = 'Dashboard';
    }
    public function index()
    {
        $this->generateLog($this->title, __FUNCTION__);
        return view('layouts.cms.index');
    }
}
