<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Gasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class UsuariosController extends Controller
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function loginView()
    {
        $list_usuarios = Usuario::all();
        return view('usuario.login', [
            'usuarios' => $list_usuarios
        ]);
    }

    public function relatorioView()
    {
        return view('usuario.relatorio');
    }

    public function gastosView()
    {
        return view('usuario.gastos');
    }


    public function listarViagensByCpf($cpf)
    {

        $usuario = $this->findByCpf($cpf);
        return $usuario->listViagens()->getQuery()->orderBy('dtPrazo')->get([
            'dsOrigemLat',
            'dsOrigemLng',
            'dsDestinoLat',
            'dsDestinoLng',
            'dsDistancia',
            'dsTempo',
            'dtPrazo',
            'hrPrazo',
            'dsGastos',
            'dsValor',
            'dsLucro',
            'dsStatus',
            'idUsuario',
            'idVeiculo'
        ]);


    }

    public function listarGastosByCpf($cpf)
    {

        $usuario = $this->findByCpf($cpf);
        return $usuario->listGastos()->getQuery()->orderBy('dtGasto')->get([
            'dsTipo',
            'dsValor',
            'idUsuario',
            'dtGasto'
        ]);


    }


    public function cadastrarGasto(Request $request)
    {
        $date = date('Y-m-d h:i:s', time());
        $usuario = $this->findByCpf($request->cpfUsuario);
        
        $gasto = new Gasto();
        $gasto->dsTipo = $request->dsTipo;
        $gasto->dsValor = $request->dsValor;
        $gasto->idUsuario = $usuario->id;
        $gasto->dtGasto = $request->dtGasto;
        $gasto->save();
        try {
            $gasto->save();
        } catch (\Exception $e) {
            return redirect("usuarios/gastos")->with("message", "Erro ao registrar gasto");
        }
        return redirect("usuarios/gastos")->with("message", "Gasto cadastrado com sucesso!");
    }

    public function alterarView(){
        return view('usuario.alterar');
    }

    public function alterar(Request $request){
        
        $usuario = Usuario::find($request->idUsuario);
        $usuario->nmUsuario = $request->nmUsuario;
        $usuario->cdCpfUsuario = $request->cdCpfUsuario;
        $usuario->dtNascimentoUsuario = $request->dtNascimentoUsuario;
        $usuario->nrTelefoneUsuario = $request->nrTelefoneUsuario;
        $usuario->dsEmailUsuario = $request->dsEmailUsuario;
        $usuario->nmSenhaUsuario = $request->nmSenhaUsuario;
        $request->session()->put('usuario', $usuario);
        try {
            $usuario->update();
        } catch (\Exception $e) {
            return redirect("/")->with("message", "Erro ao alterar Usuário!");
        }
        return redirect("/")->with("message", "Usuário alterado com sucesso!");
    }

    public function alterarCofrinho(Request $request){
        $input=$request->all();
        $usuario = $this->findByCpf($input['usuario']);
        $usuario->dsValorCofrinho = $usuario->dsValorCofrinho+$input['valor'];
        $request->session()->put('usuario', $usuario);
        try {
            $usuario->update();
        } catch ( Exception $e) {
            return redirect("usuarios/cofrinho")->with("message", "Erro ao alterar cofrinho!");
        }
        return redirect("usuarios/cofrinho")->with("message", "Cofrinho alterado com sucesso!");

    }



    public function cadastroView()
    {
        return view('usuario.cadastro');
    }

    public function entrar(Request $request)
    {
        $usuario = $this->findByCpf($request->cdCpfUsuario);
        if ($usuario && ( $usuario->nmSenhaUsuario == $request->nmSenhaUsuario )) {
            $request->session()->put('usuario', $usuario);
            $request->session()->put('logado', true);

            $veiculos = $usuario->listVeiculos()->getQuery()->count();
            if ($veiculos > 0) {
                return redirect("/");
            } else {
                return redirect("/veiculos/cadastro")->with("message", "Recomendado: cadastre ao menos um veículo para utilizar o sistema!");;
            }
        } else {
            return redirect("usuarios/login")->with("message", "CPF ou Senha Incorretos!");
        }
    }

    public function verificaLogado(Request $request)
    {

        if ($request->session()->get('logado')) {
            echo "0";
        } else {
            echo "1";
        }
    }


    public function cadastrar(Request $request)
    {
        $validacao = $this->validacao($request->all());
        if ($validacao->fails()) {
            return redirect()->back()
                ->withErrors($validacao->errors())
                ->withInput($request->all());
        }

        $usuario = new Usuario();
        $usuario->nmUsuario = $request->nmUsuario;
        $usuario->cdCpfUsuario = $request->cdCpfUsuario;
        $usuario->dtNascimentoUsuario = $request->dtNascimentoUsuario;
        $usuario->nrTelefoneUsuario = $request->nrTelefoneUsuario;
        $usuario->dsEmailUsuario = $request->dsEmailUsuario;
        $usuario->nmSenhaUsuario = $request->nmSenhaUsuario;
        $usuario->dsValorCofrinho = 0;

        try {
            $usuario->save();
        } catch (\Exception $e) {
            return redirect("usuarios/login")->with("message", "Erro ao cadastrar Usuário!");
        }
        return redirect("usuarios/login")->with("message", "Usuário cadastrado com sucesso!");
    }

    public function findByCpf($cdCpfUsuario)
    {
        return $this->usuario->where('cdCpfUsuario', $cdCpfUsuario)->first();
    }

    public function cofrinhoView(Request $request)
    {   
        $usuario = Usuario::find($request->session()->get('usuario')->id);
        $request->session()->put('usuario', $usuario);
        return view('usuario.cofrinho');
    }

    public function validacao($data)
    {
        $regras = [
            'nmUsuario' => 'required|min:5',
            'cdCpfUsuario' => 'required',
            'dtNascimentoUsuarioNF' => 'required',
            'nrTelefoneUsuario' => 'required',
            'dsEmailUsuario' => 'required',
            'nmSenhaUsuario' => 'required|min:8',
            'nmSenhaUsuarioC' => 'required'
        ];

        $mensagens = [
            'nmUsuario.min' => 'O Nome precisa ter ao menos 5 letras',
            'nmUsuario.required' => 'Entre com o Nome',

            'cdCpfUsuario.required' => 'Entre com o CPF',
            'dtNascimentoUsuarioNF.required' => 'Entre com a Data de Nascimento',
            'nrTelefoneUsuario.required' => 'Entre com o Número de Telefone',
            'dsEmailUsuario.required' => 'Entre com o E-mail',
            'nmSenhaUsuario.required' => 'Entre com a Senha',
            'nmSenhaUsuario.min' => 'A Senha precisa ter ao menos 8 letras',

            'nmSenhaUsuarioC.required' => 'Entre com a Confirmação da Senha',
        ];

        return Validator::make($data, $regras, $mensagens);
    }
}
