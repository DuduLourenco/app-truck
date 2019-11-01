@extends('layouts.app')

@section('titulo')
Viagens
@endsection

@section('css')

@endsection

@if(!Session::get('logado'))
<script>
	window.location = '{{url('usuarios/login')}}';
</script>
@endif


@section('conteudo')

@extends('layouts.menu')

<div class="container-login100" style="align-items: stretch">
	<div class="wrap-login100 p-b-30 p-t-45" style="width: 640px">
		<form id="form" class="login100-form validate-form" method="post" action="{{ url('viagens/cadastrar') }}">
			{{ csrf_field() }}
			<span class="login100-form-title p-b-40">
				Próximas Viagens
			</span>

			<div class="text-center p-t-25 p-b-15">
				<span class="txt2" id="spanViagem">
				</span>
			</div>

			<div class="row">
				<table id="tabelaViagem" class="container-login100-form-btn">
				</table>
			</div>

			



			<input type="hidden" name="idUsuario" id="idUsuario"
				value="@if (Session::has('usuario')){{Session::get('usuario')->id}}@endif">

		</form>
	</div>
</div>



@endsection

@section('importacoes')
<script src="{{ asset('js/viagem/lista.js') }}"></script>
<script
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQCnq0A9TueU4DKWoAtSONIXX-6kFLxys&libraries=places,directions&callback=initMap"
	async defer></script>
@endsection