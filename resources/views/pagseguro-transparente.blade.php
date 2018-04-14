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
    <a href="" class="btn-finished">Pagar com boleto bancário</a>
    <div class="payment_methods"></div>

    
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
            }).done(function(code){
                PagSeguroDirectPayment.setSessionId(code);
                //getPaymentMethods();
                paymentBillet();
            }).fail(function(){
                alert('Falha na requisição...');
            });
        }

        function getPaymentMethods(){
            
            PagSeguroDirectPayment.getPaymentMethods({
                success: function(response){
                    console.log(response);
                    if(response.error == false){
                        $.each(response.paymentMethods, function(key, value){
                            $('.payment_methods').append(key+'<br/>');
                        });
                    }
                },
                error: function(response){
                    console.log(response);
                },
                complete: function(response){
                },
            });
        }

        function paymentBillet(){
            var sendHash = PagSeguroDirectPayment.getSenderHash();
            var data = $('#form').serialize()+"&sendHash="+sendHash;
            $.ajax({
                url: "{{route('pagseguro.billet')}}",
                method: 'POST',
                data: data
            }).done(function(url){
                console.log(url);
                location.href=url;
            }).fail(function(){
                alert('Falha na requisição...');
            });
        }
    </script>
</body>
</html>