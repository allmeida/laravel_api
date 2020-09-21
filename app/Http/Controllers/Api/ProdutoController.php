<?php

namespace App\Http\Controllers\Api;

use App\API\ApiError;
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
        $data = ['data' => $this->produto->paginate(10)];

        return response()->json($data); 
    }

    public function show(Produto $id)
    {
        $data = ['data' => $id];

        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {

            $produtoData = $request->all();
            $this->produto->create($produtoData);

            return response()->json(['msg' => 'Produto Criado com Sucesso!'], 201);

        } catch (\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010));

            }
            return response()->json(ApiError::errorMessage('Houve um erro', 1010));

        }
    }
}
