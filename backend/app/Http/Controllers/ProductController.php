<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $service;

    /**
     * Constructor function.
     *

     * @param ProductService $service
     */
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * Products list.
     *
     * This endpoint show all products with their comments.
     *
     *
     * @authenticated
     * @responseFile status=200 docs/responses/product/index.success.json

     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  ProductResource::collection($this->service->getAll());
    }
}
