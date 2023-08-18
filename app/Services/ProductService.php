<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductService
{
    /**
     * ვარგისიანობის თარიღის დადგენა
    */

    private function getExpiryDate($manufacture, $expiryDate)
    {
        $duration = explode(' ', $expiryDate);
        $number = intval($duration[0]);
        $unit = $duration[1];
        $unit = strtolower($unit);

        switch ($unit) {
            case substr($unit, 0, 3) === 'day':
                $manufacture->addDays($number);
                break;
            case substr($unit, 0, 5) === 'month':
                $manufacture->addMonths($number);
                break;
            case substr($unit, 0, 4) === 'year':
                $manufacture->addYears($number);
                break;
            default:
                throw new \Exception('Invalid expiry date format.');
        }

        return $manufacture;
    }

    /**
     * პროდუქტის შექმნა
    */

    public function create($request)
    {
        $manufacture_date = Carbon::createFromFormat('Y/m/d', $request['manufacture_date']);

        $expiry_date = $this->getExpiryDate(clone $manufacture_date,$request['expiry_date']);

        $product = new Product();

        $product->name = $request['name'];
        $product->unique_code = $request['unique_code'];
        $product->quantity = $request['quantity'] ?? 0;
        $product->type = $request['type'];
        $product->manufacture_date = $manufacture_date;
        $product->expiry_date = $expiry_date;
        $product->added_by = auth()->id();

        if($product->save())
        {
            return true;
        }
    }

    /**
     * პროდუქტის განახლება
    */

    public function update($product,$request)
    {

        $setManufacture = isset($request['manufacture_date']) ? $request['manufacture_date'] : $product->manufacture_date;

        $manufacture_date = date("Y/m/d", strtotime($setManufacture));

        $setExpiry = isset($request['expiry_date']) ? $request['expiry_date'] : $product->expiry_date;

        if(is_object($manufacture_date))
        {
            $expiry_date = $this->getExpiryDate(clone $manufacture_date,$setExpiry);
        }

        $product->name = $request['name'] ?? $product->name;
        $product->quantity = $request['quantity'] ?? $product->quantity;
        $product->type = $request['type'] ?? $product->type;
        $product->manufacture_date = $manufacture_date;
        $product->expiry_date = isset($expiry_date) ? $expiry_date : $setExpiry;

        if($product->update())
        {
            Log::info("პროდუქტი განახლებულია მომხმარებლის მიერ აიდით:  " . auth()->id());
            return true;
        }
    }
}
