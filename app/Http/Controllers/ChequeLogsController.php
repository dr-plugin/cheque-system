<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChequeLogsController extends Controller
{

    public function getViewPath(): string
    {
        return 'ChequeLogs';
    }

    public function index()
    {
        return $this->render('Index');
    }

    public function show(){
        return $this->render('Show');
    }
}
