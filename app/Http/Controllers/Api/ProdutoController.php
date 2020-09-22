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

    public function show($id)
    {
        $produto = $this->produto->find($id);       // faz a busca no banco.
        if(! $produto)                              // se nao encontar retorna uma mensagem e nao pagina de erro 404.
            return response()->json(ApiError::errorMessage('Produto não encontrado!', 4040), 404); // status 4040 para erros internos da aplicação.

        $data = ['data' => $produto];
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
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010 , 500)); // retorna o codigo de erro internos da aplicação.

            }
            return response()->json(ApiError::errorMessage('Houve um erro ao criar!', 1010, 500));

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
                return response()->json(ApiError::errorMessage($e->getMessage(), 1012, 500)); // retorna o codigo de erro internos da aplicação.

            }
            return response()->json(ApiError::errorMessage('Houve um erro', 1012, 500));

        }
    }

    public function delete(Produto $id)
    {
        try {
            $id->delete();

            return response()->json(['data' => ['msg' => 'Produto: ' . $id->name . ' removido com sucesso! ']], 200);

        } catch (\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010, 500)); // retorna o codigo de erro internos da aplicação.

            }
            return response()->json(ApiError::errorMessage('Houve um erro ao excluir!', 1012, 500));
        }
    }
}
