<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LivroRequest;
use App\Repositories\LivroRepository;
use Illuminate\Http\JsonResponse;
use Exception;
use DB;

class LivroController extends Controller
{
    protected $livroRepository;

    public function __construct(LivroRepository $livroRepository)
    {
        $this->livroRepository = $livroRepository;
    }

    public function buscaLivros()
    {
        try {
            DB::beginTransaction();

            $livro = $this->livroRepository->all();

            DB::commit();

            return new JsonResponse($livro, JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return new ErrorResponse($exception);
        }
    }

    public function buscaLivro($id)
    {
        try {
            DB::beginTransaction();

            $livro = $this->livroRepository->find($id);

            DB::commit();

            return new JsonResponse($livro, JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return new ErrorResponse($exception);
        }
    }
    
    public function salvaLivro(LivroRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $livro = $this->livroRepository->create($data);

            DB::commit();

            return new JsonResponse($livro, JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return new ErrorResponse($exception);
        }
    }

    /**
     * updates a livro
     * @param LivroRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function atualizaLivro($id, LivroRequest $request)
    {
        $livro = $this->livroRepository->find($id);
        if (!$livro) {
            return new JsonResponse(['message' => 'Livro não encontrado.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = $request->all();

        try {
            DB::beginTransaction();

            $livro = $this->livroRepository->update($data, $id);
            $livro = $this->livroRepository->find($id);

            DB::commit();

            return new JsonResponse($livro, JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return new ErrorResponse($exception);
        }
    }

    public function deletaLivro($id)
    {
        try {
            DB::beginTransaction();

            $livro = $this->livroRepository->find($id);

            if (!$livro) {
                return new JsonResponse(['message' => 'Livro não encontrado.'], JsonResponse::HTTP_NOT_FOUND);
            }

            $this->livroRepository->delete($id);

            DB::commit();

            return new JsonResponse($livro, JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return new ErrorResponse($exception);
        }
    }
}
