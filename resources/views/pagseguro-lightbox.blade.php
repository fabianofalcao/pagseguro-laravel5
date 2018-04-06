<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PagSeguro lightbox</title>
</head>
<body>
    <a href="#" class="btn-buy">Finalizar compra!</a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(function(){
            $(".btn-buy").click(function(){
                $.ajax({
                    url: "{{route('pagseguro.lightbox.code')}}",
                    method: "POST",
                    data: {}
                });
                return false;
            })
        });
    </script>
    <script src="{{config('pagseguro.url_lightbox_sandbox')}}"></script>
</body>
</html>