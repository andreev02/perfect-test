<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\ConvertRequest;
use App\Http\Requests\Api\RatesRequest;
use App\Services\Api\ConvertService;
use App\Services\Api\RatesService;
use App\Traits\ApiResponse;

class ApiController extends Controller
{
    use ApiResponse;

    public function rates(RatesRequest $request)
    {
        $data = $request->validated();

        $result = (new RatesService())->rates($data);
        
        if (is_null($result)) {
            return $this->sendError('Invalid token', 403);
        }

        return $this->sendResponse($result, 200);
    }

    public function convert(ConvertRequest $request)
    {
        $data = $request->validated();
        
        $result = (new ConvertService())->convert($data);
        
        if (is_null($result)) {
            return $this->sendResponse('Invalid token', 403);
        }

        return $this->sendResponse($result, 200);
    }        
}
