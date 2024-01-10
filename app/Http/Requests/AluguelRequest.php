<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use App\Models\AluguelModel;

class AluguelRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'dt_aluguel_ini' => 'required|date_format:Y-m-d H:i:s|max:150',
            'dt_aluguel_fim' => 'required|date_format:Y-m-d H:i:s|max:150',
            'livro_id' => 'required|exists:livros,id',
            'usuario_id' => 'required|exists:usuarios,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Erro de validação',
                'errors' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $dtAluguelIni = $this->input('dt_aluguel_ini');
            $dtAluguelFim = $this->input('dt_aluguel_fim');
            $livroId = $this->input('livro_id');
            $usuarioId = $this->input('usuario_id');

            $dataFormatadaIni = date('Y-m-d H:i:s', strtotime($dtAluguelIni));


            $aluguelExistente = AluguelModel::where('livro_id', $livroId)
                ->where(function ($query) use ($dataFormatadaIni) {
                    $query->where('dt_aluguel_ini', '<=', $dataFormatadaIni)
                        ->where('dt_aluguel_ini', '>', $dataFormatadaIni);
                })
                ->exists();

                if ($aluguelExistente) {
                    $validator->errors()->add('dt_aluguel_ini', 'Livro já alocado nesta data e hora.');
                }
        });
    }
}
