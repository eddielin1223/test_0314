<head>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
</head>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Recommendation
        </h2>
    </x-slot>

    <table style="border: 1px solid;">
        <tr style="border: 1px solid;">
            <td style="border: 1px solid;">Product Name</td>
            <td style="border: 1px solid;">Type</td>
            <td style="border: 1px solid;">Price</td>
            <td style="border: 1px solid;">Customer Msg</td>
        </tr>
        @foreach($data as $value)
        
        <tr style="border: 1px solid;">
            <td style="border: 1px solid;">{{$value['prod_name']}}</td>
            <td style="border: 1px solid;">{{$value['prod_type']}}</td>
            <td style="border: 1px solid;">{{$value['price']}}</td>
            <td style="border: 1px solid;">{{$value['comment']}}</td>
            <td style="border: 1px solid;"><input id="reply_{{$value['id']}}""></input><button type="button" onclick="reply({{$value['id']}})" style="background-color: #04AA6D; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;">reply</button></td>
        </tr>
        @endforeach
    </table>
    
</x-app-layout>
<script>
   
   function reply(recommId){
        let text = document.getElementById("reply_"+recommId).value;
        $.ajax({

            // 進行要求的網址(URL)
            url: "http://127.0.0.1:8082/api/comment/"+recommId,

            // 要送出的資料 (會被自動轉成查詢字串)
            data: {
                prod_id: recommId,
                content: text
            },

            // 要使用的要求method(方法)，POST 或 GET
            type: 'POST',

            // 資料的類型
            dataType : 'json',
            })
            // 要求成功時要執行的程式碼
            // 回應會被傳遞到回調函式的參數
            .done(function( json ) {
                location.reload()
                console.log('done')
            })
            // 要求失敗時要執行的程式碼
            // 狀態碼會被傳遞到回調函式的參數
            .fail(function( xhr, status, errorThrown ) {
                // alert('fail')
            })
            // 不論成功或失敗都會執行的回調函式
            .always(function( xhr, status ) {
                console.log( '要求已完成!' )
            })

    }
    
</script>
