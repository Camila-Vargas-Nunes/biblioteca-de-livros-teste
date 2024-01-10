<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsuarioRequest;
use App\Repositories\UsuarioRepository;
use Illuminate\Http\JsonResponse;
use Exception;
use DB;

class UsuarioController extends Controller
{
    protected $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function buscaUsuarios()
    {
        try {
            DB::beginTransaction();

            $usuario = $this->usuarioRepository->all();

            DB::commit();

            return new JsonResponse($usuario, JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return new ErrorResponse($exception);
        }
    }

    public function buscaUsuario($id)
    {
        try {
            DB::beginTransaction();

            $usuario = $this->usuarioRepository->find($id);

            DB::commit();

            return new JsonResponse($usuario, JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return new ErrorResponse($exception);
        }
    }
    
    public function salvaUsuario(UsuarioRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $usuario = $this->usuarioRepository->create($data);

            DB::commit();

            return new JsonResponse($usuario, JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return new ErrorResponse($exception);
        }
    }
    
    /**
     * updates a usuario
     * @param UsuarioRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function atualizaUsuario($id, UsuarioRequest $request)
    {
        $usuario = $this->usuarioRepository->find($id);
        if (!$usuario) {
            return new JsonResponse(['message' => 'Usuario não encontrado.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = $request->all();

        try {
            DB::beginTransaction();

            $usuario = $this->usuarioRepository->update($data, $id);
            $usuario = $this->usuarioRepository->find($id);

            DB::commit();

            return new JsonResponse($usuario, JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return new ErrorResponse($exception);
        }
    }

    public function deletaUsuario($id)
    {
        try {
            DB::beginTransaction();

            $usuario = $this->usuarioRepository->find($id);

            if (!$usuario) {
                return new JsonResponse(['message' => 'Usuario não encontrado.'], JsonResponse::HTTP_NOT_FOUND);
            }
            
            $this->usuarioRepository->delete($id);

            DB::commit();

            return new JsonResponse($usuario, JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return new ErrorResponse($exception);
        }
    }
}
