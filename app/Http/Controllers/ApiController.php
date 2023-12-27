<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\ConvertRequest;
use App\Http\Requests\Api\RatesRequest;
use App\Services\Api\ConvertService;
use App\Services\Api\RatesService;
use App\Traits\ApiResponse;
use Exception;

class ApiController extends Controller
{
    use ApiResponse;

    public function rates(RatesRequest $request)
    {
        $data = $request->validated();

        try {
            $result = (new RatesService())->rates($data);
        }
        catch (Exception $e) {
            return $this->sendError($e->getMessage(), 403);
        }
        
        return $this->sendResponse($result, 200);
    }

    public function convert(ConvertRequest $request)
    {
        $data = $request->validated();
        
        try {
            $result = (new ConvertService())->convert($data);
        }
        catch (Exception $e) {
            return $this->sendError($e->getMessage(), 403);
        }
        
        return $this->sendResponse($result, 200);
    }        
}
