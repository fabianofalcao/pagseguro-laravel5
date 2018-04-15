<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PagSeguro Transparente Cartão</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Pagar com cartão</h1>
    {!! Form::open([]) !!}
        <div class="form-group">
            <label for="cardNumber">Número do cartão</label>
            {!! Form::text('cardNumber', null, ['class' => 'form-control', 'placeholder' => 'Número do cartão', 'required']) !!}
        </div>

        <div class="form-group">
            <label for="cardExpiryMonth">Mês de expiração</label>
            {!! Form::text('cardExpiryMonth', null, ['class' => 'form-control', 'placeholder' => 'Mês de expiração', 'required']) !!}
        </div>

        <div class="form-group">
            <label for="cardExpiryYear">Ano de expiração</label>
            {!! Form::text('cardExpiryYear', null, ['class' => 'form-control', 'placeholder' => 'Ano de expiração', 'required']) !!}
        </div>

        <div class="form-group">
            <label for="cardCVC">Código de segurança (3 digitos)</label>
            {!! Form::text('cardCVC', null, ['class' => 'form-control', 'placeholder' => 'Código de segurança', 'required']) !!}
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-default">Enviar agora</button>
        </div>
    {!! Form::close() !!}
</div>

    <!-- jquery 3.3.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <!-- URL Pagseguro transparente -->
    <script src="{{ config('pagseguro.url_transparente_js_sandbox') }}"></script>

    <script>
        $(function(){
            setSessionId();


        });

        function setSessionId(){
            var data = $('#form').serialize();
            $.ajax({
                url: "{{route('pagseguro.code.transparente')}}",
                method: 'POST',
                data: data
            }).done(function(code){
                PagSeguroDirectPayment.setSessionId(code);
            }).fail(function(){
                alert('Falha na requisição...');
            });
        }

        function getBrand(){
            PagSeguroDirectPayment.getBrand({
                cardNumber: $("input[name='cardNumber']").val().replace(/ /g, '');
                seccess: function(response){

                },
                error: function(response){

                },
                complete: function(response){

                }
            });
        }
    </script>
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>