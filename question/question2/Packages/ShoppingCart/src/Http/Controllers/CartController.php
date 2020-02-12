<?php

namespace Hiskio\Shoppingcart\Http\Controllers;

use App\Http\Controllers\Controller;
use Hiskio\Shoppingcart\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

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

        return redirect(route('cart'));
    }

    public function cache(Request $request)
    {
        if ($request->checked == 'true') {
            Cache::remember($request->id, 60, function() use ($request) {
                return Cart::find($request->id)->toArray();
            });
        } else {
            Cache::forget($request->id);
        }

        $sum = 0;

        foreach($request->ids as $cartId) {
            $data[] = Cache::get($cartId);

            $sum += data_get(Arr::last($data), 'price');
        }
        
        return response()->json(['data' => $data, 'sum' => $sum]);
    }
}
