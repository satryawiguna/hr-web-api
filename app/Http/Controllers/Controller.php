<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as WebBaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends WebBaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Info(
     *     version="1.0.0",
     *     title="SmartBiz OpenApi",
     *     description="SmartBiz swagger OpenApi description",
     *     @OA\Contact(
     *          email="admin@smartbiz.id"
     *     ),
     *     @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     *
     * @OA\Server(
     *     url=L5_SWAGGER_CONST_HOST,
     *     description="SmartBiz OpenApi host server"
     * )
     *
     * @OA\SecurityScheme(
     *     securityScheme="apiKey",
     *     type="apiKey",
     *     name="Authorization",
     *     in="header"
     * )
     */
}
