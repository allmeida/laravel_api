<?php

namespace App\Http\Controllers\Api;

use App\Produto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    private $produto;

    public function __construct(Produto $produto)
    {
        $this->produto = $produto;
    }

    public function index()
    {
        $data = ['data' => $this->produto->paginate(5)];

        return response()->json($data); 
    }

    public function show(Produto $id)
    {
        $data = ['data' => $id];

        return response()->json($data);
    }
}
