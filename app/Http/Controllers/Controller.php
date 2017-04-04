<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param Request $request
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @throws ValidationException
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * @param ValidationException $e
     * @return Response
     */
    public function responseValidation(ValidationException $e) {
        return response([
            'message' => 'Validation error hahaha',
            'erros' => $e->validator->errors()
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