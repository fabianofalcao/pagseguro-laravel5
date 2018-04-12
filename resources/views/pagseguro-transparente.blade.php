<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout Transparente PagSeguro</title>
</head>
<body>
    {!! Form::open(['id' => 'form']) !!}
    {!! Form::close() !!}
    <a href="" class="btn-finished">Finalizar Compra!</a>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ config('pagseguro.url_transparente_js_sandbox') }}"></script>
    <script>
        $(function(){
            $('.btn-finished').click(function() {
                setSessionId();

               return false; 
            });
        });

        function setSessionId(){
            var data = $('#form').serialize();
            $.ajax({
                url: "{{route('pagseguro.code.transparente')}}",
                method: 'POST',
                data: data
            }).done(function(data){
                PagSeguroDirectPayment.setSessionId(data);
            }).fail(function(){
                alert('Falha na requisição...');
            });
        }
    </script>
</body>
</html>