<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\AddProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\PaginateResource;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

use function App\Helpers\failedResponse;
use function App\Helpers\successResponse;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     ** path="/api/product",
     *   tags={"Product"},
     *   security={{"bearerAuth":{}}},
     *   summary="Product List",
     *   @OA\Parameter(name="page",in="query",description="Current Page (default: 1)",@OA\Schema(type="integer", default=1)),
     *   @OA\Parameter(name="title",in="query",description="Title",@OA\Schema(type="string")),
     *   @OA\Parameter(name="brand",in="query",description="Brand",@OA\Schema(type="string")),
     *   @OA\Response(response=200,description="Success"),
     *   @OA\Response(response="401", description="unauthorized",@OA\JsonContent()),
     *   @OA\Response(response=500,description="internal server error",@OA\JsonContent()),
     *   @OA\Response(response=404,description="not found"),
     *)
     **/
    public function index(Request $request)
    {
        $data = ProductRepository::Search($request);
        return successResponse(new PaginateResource($data, ProductResource::collection($data)));
    }

    /**
     * @OA\Post(
     *     path="/api/product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="An example resource",@OA\JsonContent()),
     *     @OA\Response(response="401", description="unauthorized",@OA\JsonContent()),
     *     @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *     required={"title","brand"},
     *     @OA\Property(property="title",type="string"),
     *     @OA\Property(property="brand",type="string"),
     *   )))
     * )
     */

    public function store(AddProductRequest $request)
    {
        $item = ProductRepository::NewItem($request->validated());
        return successResponse($item);
    }


    /**
     * @OA\Put(
     *     path="/api/product/{id}",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="An example resource",@OA\JsonContent()),
     *     @OA\Response(response="401", description="unauthorized",@OA\JsonContent()),
     *     @OA\Response(response=404,description="not found"),
     *     @OA\Parameter(name="id",in="path",required=true, @OA\Schema(type="string")),
     *     @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *     required={},
     *     @OA\Property(property="title",type="string"),
     *     @OA\Property(property="brand",type="string"),
     *  )))
     * )
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $data = ProductRepository::UpdateItem($request->validated(), $id);
        if ($data) {
            return successResponse(new ProductResource($data));
        }
        return failedResponse( 404);
    }

    /**
     * @OA\Delete(
     ** path="/api/product/{id}",
     *   tags={"Product"},
     *   summary="remove product",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="id",in="path",required=false, @OA\Schema(type="string")),
     *   @OA\Response(response=200,description="Success"),
     *   @OA\Response(response=404,description="not found"),
     *)
     **/
    public function destroy(string $id)
    {
        $data = ProductRepository::Remove($id);
        if ($data) {
            return successResponse([]);
        }
        return failedResponse( 404);
    }
}
