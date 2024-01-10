<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AluguelRequest;
use App\Repositories\AluguelRepository;
use Illuminate\Http\JsonResponse;
use Exception;
use DB;

class AluguelController extends Controller
{
    protected $aluguelRepository;

    public function __construct(AluguelRepository $aluguelRepository)
    {
        $this->aluguelRepository = $aluguelRepository;
    }

    public function buscaAlugueis()
    {
        try {
            DB::beginTransaction();

            $aluguel = $this->aluguelRepository->all();

            DB::commit();

            return new JsonResponse($aluguel, JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return new ErrorResponse($exception);
        }
    }

    public function buscaAluguel($id)
    {
        try {
            DB::beginTransaction();

            $aluguel = $this->aluguelRepository->find($id);

            DB::commit();

            return new JsonResponse($aluguel, JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return new ErrorResponse($exception);
        }
    }
    
    public function salvaAluguel(AluguelRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $aluguel = $this->aluguelRepository->create($data);

            DB::commit();

            return new JsonResponse($aluguel, JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return new ErrorResponse($exception);
        }
    }


    /**
     * updates a aluguel
     * @param AluguelRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function atualizaAluguel(AluguelRequest $request, $id)
    {
        $aluguel = $this->aluguelRepository->find($id);
        if (!$aluguel) {
            return new JsonResponse(['message' => 'Aluguel não encontrado.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = $request->all();

        try {
            DB::beginTransaction();

            $aluguel = $this->aluguelRepository->update($data, $id);
            $aluguel = $this->aluguelRepository->find($id);

            DB::commit();

            return new JsonResponse($aluguel, JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return new ErrorResponse($exception);
        }
    }

    public function deletaAluguel($id)
    {
        try {
            DB::beginTransaction();

            $aluguel = $this->aluguelRepository->find($id);

            if (!$aluguel) {
                return new JsonResponse(['message' => 'Aluguel não encontrado.'], JsonResponse::HTTP_NOT_FOUND);
            }

            $this->aluguelRepository->delete($id);

            DB::commit();

            return new JsonResponse($aluguel, JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return new ErrorResponse($exception);
        }
    }
}
