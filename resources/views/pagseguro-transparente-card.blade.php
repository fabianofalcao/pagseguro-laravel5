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
    {!! Form::open(['id' => 'form_card']) !!}
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
            <label for="cardCVV">Código de segurança (3 digitos)</label>
            {!! Form::text('cardCVV', null, ['class' => 'form-control', 'placeholder' => 'Código de segurança', 'required']) !!}
        </div>

        <div class="form-group">
            {!! Form::hidden('cardBrand', null) !!}
            {!! Form::hidden('cardToken', null) !!}
            <button type="submit" class="btn btn-default btn-buy">Enviar agora</button>
        </div>
    {!! Form::close() !!}
    <div class="preloader" style="display: none">Preloader...</div>
    <div class="message" style="display: none"></div>
</div>

    <!-- jquery 3.3.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <!-- URL Pagseguro transparente -->
    <script src="{{ config('pagseguro.url_transparente_js_sandbox') }}"></script>

    <script>
        $(function(){
            setSessionId();
            
            $('#form_card').submit(function(){
                getBrand();
                startPreloader('Eviando dados...');
                createCredCardToken();
                return false;
            })

        });

        
        function setSessionId(){
            startPreloader('Carregando a sessão... Aguarde!');
            var data = $('#form_card').serialize();
            $.ajax({
                url: "{{route('pagseguro.code.transparente')}}",
                method: 'POST',
                data: data
            }).done(function(code){
                //console.log(code);
                PagSeguroDirectPayment.setSessionId(code);
            }).fail(function(){
                alert('Falha na requisição...');
            }).always(function(){
                endPreloader();
            });
        }

        function getBrand(){
            PagSeguroDirectPayment.getBrand({
                cardBin: $("input[name='cardNumber']").val().replace(/ /g, ''),
                success: function(response){
                    console.log('success getbrand');
                    console.log(response);
                    $("input[name='cardBrand']").val(response.brand.name);
                },
                error: function(response){
                    console.log('error getbrand');
                    console.log(response);     
                },
                complete: function(response){
                   
                }
            });
        }

        function createCredCardToken() {
            PagSeguroDirectPayment.createCardToken({
                cardNumber: $("input[name='cardNumber']").val().replace(/ /g, ''),
                brand: $("input[name='cardBrand']").val(),
                cvv: $("input[name='cardCVV']").val(),
                expirationMonth: $("input[name='cardExpiryMonth']").val(),
                expirationYear: $("input[name='cardExpiryYear']").val(),
                success: function(response){
                    console.log('success createCredCardToken');
                    console.log(response);
                    $("input[name='cardToken']").val(response.card.token);

                    createTransactionCard();
                },
                error: function(response){
                    console.log('error createCredCardToken');
                    console.log(response);     
                },
                complete: function(response){
                   endPreloader();
                }
            });
        }

        function createTransactionCard() {
            startPreloader('Processando solicitação... Aguarde!');
            var senderHash = PagSeguroDirectPayment.getSenderHash();
            var data = $('#form_card').serialize()+"&senderHash="+senderHash;
            $.ajax({
                url: "{{route('pagseguro.card.transaction')}}",
                method: 'POST',
                data: data
            }).done(function(code){
                $('.message').html('Código da transação: '+code);
                $('.message').show();
            }).fail(function(){
                alert('Falha na requisição...');
            }).always(function(){
                endPreloader();
            });
        }

        function startPreloader(msgPreloader) {
            if(msgPreloader != '')
                $('.preloader').html(msgPreloader);
            $('.preloader').show();
            $('.btn-buy').addClass('disabled');
        }
        
        function endPreloader() {
            $('.preloader').hide();
            $('.btn-buy').removeClass('disabled');
        }
    </script>
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>