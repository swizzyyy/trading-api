<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $model = 'App\Models\Product'; //მიმდინარე ინსტანციის მოდელი Product::class


    public function checkAvailability(Request $request): JsonResponse
    {
        $request->validate(['unique_code' => 'required'],['unique_code' => ':attribute სავალდებულოა']);

            $code = $request->unique_code;

            $product = $this->model::where('unique_code',$code)->select('quantity','type')->first();

            if(is_null($product) || !isset($product))
            {
                throw new GeneralException('პროდუქტი არ მოიძებნა', 404);
            }

            return response()->json(['quantity' => $product->quantity, 'type' => $product->type]);
    }

    public function checkSuitability(Request $request): JsonResponse
    {
            $request->validate(['unique_code' => 'required'],['unique_code' => ':attribute სავალდებულოა']);

            $code = $request->unique_code;

            $product = $this->model::where('unique_code',$code)->select('expiry_date','manufacture_date')->first();

            if(is_null($product) || !isset($product))
            {
                throw new GeneralException('პროდუქტი არ მოიძებნა', 404);
            }

            $expiryDate = Carbon::parse($product->expiry_date);
            $manufactureDate = Carbon::parse($product->manufacture_date);

            $data = [
                "დღე" => $expiryDate->diffInDays($manufactureDate),
                "თვე" => $expiryDate->diffInMonths($manufactureDate),
                "წელი" => $expiryDate->diffInYears($manufactureDate),
            ];

            return response()->json(['title' => 'ვარგისიანობა','expiry_date' => $data]);
    }
}
