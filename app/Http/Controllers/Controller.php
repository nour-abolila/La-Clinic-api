<?php

namespace App\Http\Controllers;

abstract class Controller
{
    // This property will be used to set the default pagination value for all controllers that extend this base controller
    protected $paginate;
    public function __construct()
    {
        $this->paginate = request()->paginate ?? 10;
    }
}
