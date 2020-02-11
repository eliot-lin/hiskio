<?php

namespace Hiskio\Shoppingcart\Http\Controllers;

use App\Http\Controllers\Controller;
use Hiskio\Shoppingcart\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

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
        $redis = Redis::connection('cache');

        $redis->set('foo', 'bar');

        return $redis->get('foo');
    }
}
