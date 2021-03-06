<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    <title>Cart</title>
</head>
<body>
    <button id="addBtn">新增商品</button>

    <form id="add" action="add" method="post" style="display:none">
        @csrf
        <input type="text" name="name" placeholder="Insert Item Name">
        <input type="text" name="price" placeholder="Insert Item Price">
        <input type="text" name="amount" placeholder="Insert Item Amount">
        <input type="submit" value="新增商品">
    </form>

    <button id="updateBtn">更新商品</button>

    <table id="update" border="1" style="display:none; width: 50%; text-align:center;  margin-left:auto; margin-right:auto; margin-bottom: 30px;">
        <tr>
            <td style="width: 3%">商品名稱</td>
            <td style="width: 3%">價格</td>
            <td style="width: 3%">庫存</td>
            <td style="width: 3%">操作</td>
        </tr>
        @foreach ($carts as $cart)
            <tr>
                <form action="update" method="post">
                    　<td>{{ $cart->name }}</td>
                    　<td>{{ $cart->price }}</td>
                    　<td><input type="text" name="amount" value="{{ $cart->amount }}" style="color:cornflowerblue; font-size: 15px;text-align:center; width:100%"></td>
                    　<td><input name="id" value="{{ $cart->id }}" style="display:none"><input type="submit" value="更新"></td>
                </form>
        　  </tr>
        @endforeach
    </table>

    <table border="1" style="width: 50%; display: block; text-align:center;  margin-left:auto; margin-right:auto; margin-bottom: 30px;">
    　<tr>
        　<td style="width: 1%"></td>
        　<td style="width: 3%">商品名稱</td>
        　<td style="width: 3%">價格</td>
        　<td style="width: 3%">庫存</td>
        　<td style="width: 3%">操作</td>
    　</tr>
        @foreach ($carts as $cart)
            <tr>
                <form action="del" method="post">
                    　<td><input id="{{ $cart->id }}" type="checkbox" name="id" value="{{ $cart->id }}" onchange="cache(this)"></td>
                    　<td>{{ $cart->name }}</td>
                    　<td>{{ $cart->price }}</td>
                    　<td>{{ $cart->amount }}</td>
                    　<td><input name="id" value="{{ $cart->id }}" style="display:none"><input type="submit" value="刪除"></td>
                </form>
        　  </tr>
        @endforeach
    </table>

    <hr size="3px" align="center" width="100%">
    
    <div>
        <div style="text-align:center; color:cadetblue; font-size: 24px;margin-bottom: 30px;">購物車</div>
        <table border="1" style="width: 50%; display: block; text-align:center;  margin-left:auto; margin-right:auto; margin-bottom: 30px;">
            <thead>
                <tr>
                    <td style="width: 1%"></td>
                    <td style="width: 3%">商品名稱</td>
                    <td style="width: 3%">價格</td>
                    <td style="width: 3%">庫存</td>
                </tr>
            </thead>
            <tbody id="cartbody">
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        document.getElementById("addBtn").onclick = function() { 
            $status = document.getElementById("add").style.display == "block" ? "none" : "block";
            document.getElementById("add").style.display = $status; 
        }

        document.getElementById("updateBtn").onclick = function() { 
            $status = document.getElementById("update").style.display == "block" ? "none" : "block";
            document.getElementById("update").style.display = $status; 
        }

        $(document).ready(function() {
            cache(true);
        });

        function cache ($this) {
            $.ajax({
                type: "POST", 
                url: "/cache", 
                dataType: "json", 
                data: { 
                    checked: $this.checked, 
                    id: $this.id
                },
                success: function(data) {
                    var trHTML = '';

                        $.each(data, function (i, cart) {
                            for (i = 0; i < cart.length; i++) {
                                trHTML +=
                                    '<tr>' +
                                        '<td></td>' + 
                                        '<td>' + cart[i].name + '</td>' +
                                        '<td>' + cart[i].price + '</td>' +
                                        '<td>' + cart[i].amount + '</td>' +
                                    '</tr>';
                            }
                        });
                    
                    trHTML +=
                        '<tr>' +
                            '<td>總和</td>' + 
                            '<td></td>' + 
                            '<td>' + data.sum + '</td>' +
                            '<td></td>' + 
                        '</tr>';

                    $('#cartbody').html(trHTML);
                },
                error: function(jqXHR) {
                    console.log(jqXHR);
                }
            })
        }
    </script>
</body>
</html>

