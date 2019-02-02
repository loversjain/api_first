<?php
namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

trait apiException{

	public function customExceptionHander($request, $e)
	{
		if($this->isModel($e)){
			return $this->ModelResponse($e);
        }

        if($this->isNotFound($e)){
            return $this->NotFound($e);
        }

        return parent::render($request, $e);

	}

	public function isModel($e)
	{
		return $e instanceof ModelNotFoundException;
	}

	public function isNotFound($e)
	{
		return $e instanceof NotFoundHttpException;
	}

	public function ModelResponse($e)
	{
		return response()->json([
                'errors'=>"Incorroect Model"],
                Response::HTTP_NOT_FOUND);
	}

	public function NotFound($e)
	{
		return response()->json([
                'errors'=>"Incorroect Route"],
                Response::HTTP_NOT_FOUND);
	}
}
