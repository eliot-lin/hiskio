<?php

namespace Hiskio\Shoppingcart\Http\Controllers;

use App\Http\Controllers\Controller;
use Hiskio\Shoppingcart\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $data = Cart::all();

        return view('cart::cart')->with('carts', $data);
    }

    public function add(Request $request)
    {
        Cart::create($request->all());

        return redirect(route('cart'));
    }

    public function del(Request $request)
    {
        Cart::find($request->id)->delete();
        Cache::forget($request->id);

        return redirect(route('cart'));
    }

    public function update(Request $request)
    {
        Cart::find($request->id)->update(['amount' => $request->amount]);
        $item = Cart::find($request->id)->toArray();
        Cache::forget($request->id);
        Cache::put($request->id, $item, 600);

        return redirect(route('cart'));
    }

    public function cache(Request $request)
    {
        try {
            if ($request->checked == 'true') {
                Cache::remember($request->id, 60, function() use ($request) {
                    return Cart::find($request->id)->toArray();
                });
            } else {
                Cache::forget($request->id);
            }
    
            $sum = 0;
            $ids = Cart::all()->pluck('id');
    
            foreach($ids as $cartId) {
                $item = Cache::get($cartId);
                if (!empty($item)) {
                    $data[] = $item; 
    
                    $sum += data_get(Arr::last($data), 'price');
                } 
            }
            
            return response()->json(['data' => $data, 'sum' => $sum]);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
