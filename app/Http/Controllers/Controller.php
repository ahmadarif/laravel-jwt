<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $validator
     * @return Response
     */
    public function responseValidation($validator) {
        return response([
            'message' => 'Validation error',
            'erros' => $validator->errors()
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param ModelNotFoundException $e
     * @return Response
     */
    public function responseModelNotFound(ModelNotFoundException $e) {
        return response([
            'message' => 'Model not found',
            'erros' => $e->getMessage()
        ], Response::HTTP_NOT_FOUND);
    }

}