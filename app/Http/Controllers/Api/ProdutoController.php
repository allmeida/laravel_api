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

            $retorno = ['data' => ['msg' => 'Produto Criado com Sucesso!']];
            return response()->json($retorno, 201); //requisição bem sucedida e um novo recurso foi criado.

        } catch (\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010)); // retorna o codigo de erro.

            }
            return response()->json(ApiError::errorMessage('Houve um erro', 1010)); // retorna apenas um texto como mensagem.

        }
    }
    
    public function update(Request $request, $id)
    {  
        try {

            $produtoData = $request->all();
            $produto = $this->produto->find($id);
            $produto->update($produtoData);

            $retorno = ['data' => ['msg' => 'Produto atualizado com sucesso!']];
            return response()->json($retorno, 201);

        } catch (\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010));

            }
            return response()->json(ApiError::errorMessage('Houve um erro', 1010));

        }
    }

    public function delete(Produto $id)
    {
        try {
            $id->delete();

            return response()->json(['data' => ['msg' => 'Produto: ' . $id->name . ' removido com sucesso! ']], 200);

        } catch (\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010));

            }
            return response()->json(ApiError::errorMessage('Houve um erro ao excluir', 1010));
        }
    }
}
