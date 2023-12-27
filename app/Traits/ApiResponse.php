<?php

namespace App\Traits;

trait ApiResponse
{
	public function sendResponse($result, $code = 200) {

		return self::makeResponse($result, $code);
	}

	public function sendError($error, $code = 403) {

		return self::makeError($error, $code);
	}

	public static function makeResponse($data, $code)
	{
		$res = [
			'status' => 'success',
			'code'    => $code,
		];

        if (!empty($data)) {
			$res['data'] = $data;
		}

        return response()->json($res, $code);
	}

	public static function makeError($message, $code)
	{
		$res = [
			'status' => 'error',
            'code' => $code,
			'message' => $message,
		];

		return response()->json($res, $code);
	}
}