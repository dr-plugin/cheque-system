<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getViewPath(): string
    {
        dd('This method need overide');
    }

    public function render(string $viewName, array $props = [])
    {
        return inertia($this->getViewPath() . '/' . $viewName, $props);
    }
}
