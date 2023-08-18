<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use App\Http\Requests\CreateProductValidation;
use App\Http\Requests\UpdateProductValidation;

class ProductsResource extends Controller
{
    protected $productService;

    //ProductNotFoundExeption აღწერილია Handler კლასის render მეთოდში
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * პროდუქტის დამატება.
     */
    public function store(CreateProductValidation $request)
    {
            //ვალიდური მონაცემების დამუშავება და ბაზაში შენახვა
            $createResult = $this->productService->create($request);

            if(!$createResult)
            {
                throw new GeneralException('პროდუქტის დამატებისას წარმოიშვა შეცდომა.',500);
            }

            return response()->json(['status' => 'success','message' => 'პროდუქტი წარმატებით დაემატა!'],201);
    }

    /**
     * პროდუქტის განახლება.
     */
    public function update(Product $product,UpdateProductValidation $request)
    {
            //ვალიდური მონაცემების დამუშავება და განახლება სერვისის დახმარებით
           $updateResult = $this->productService->update($product, $request);

            if(!$updateResult)
            {
                throw new GeneralException('მოხდა შეცდომა პროდუქტის განახლებისას', 500);
            }

            return response()->json(['status' => 'success','message' => 'პროდუქტი წარმატებით განახლდა!'],201);

    }
}
