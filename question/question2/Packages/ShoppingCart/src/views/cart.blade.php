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
                    　<td><input id="{{ $cart->id }}" type="checkbox" name="id" value="{{ $cart->id }}" onchange="ifChecked(this)"></td>
                    　<td>{{ $cart->name }}</td>
                    　<td>{{ $cart->price }}</td>
                    　<td>{{ $cart->amount }}</td>
                    　<td><input type="submit" value="刪除" /></td>
                </form>
        　  </tr>
        @endforeach
    </table>

    <hr size="3px" align="center" width="100%">
    
    <div>
        <table border="1" style="width: 50%; display: block; text-align:center;  margin-left:auto; margin-right:auto; margin-bottom: 30px;">
            <tr>
                <td style="width: 1%"></td>
                <td style="width: 3%">商品名稱</td>
                <td style="width: 3%">價格</td>
                <td style="width: 3%">庫存</td>
            </tr>
        </table>
    </div>

    <script type="text/javascript">
        document.getElementById("addBtn").onclick = function() { 
            $status = document.getElementById("add").style.display == "block" ? "none" : "block";
            document.getElementById("add").style.display = $status; 
        }

        function ifChecked ($this) {
            $.ajax({
                type: "POST", 
                url: "/cache", 
                dataType: "json", 
                data: { 
                    checked: $this.checked, 
                    id: $this.id
                },
                success: function(data) {
                    console.log(data);
                },
                error: function(jqXHR) {
                    console.log(jqXHR);
                }
            })
        }
    </script>
</body>
</html>

