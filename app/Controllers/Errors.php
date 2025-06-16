<?php

namespace App\Controllers;

class Errors extends BaseController
{
    public function show404()
    {
        $titulo = 'Error';
        $css = '404.css';
        $cargarJS = false;
        $view = view('layouts/header', [
            'titulo' => $titulo,
            'css' => $css,
            'cargarJS' => $cargarJS
        ]);
        $view .= view('custom_404');
        $view .= view('layouts/footer');
        return $view;
    }
}
