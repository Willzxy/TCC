<?php

namespace App\Controllers;

require_once '../MinhaFramework/Controllers/action.php';
require_once '../App/Models/tb_usuarios.php';

require '../MinhaFramework/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Models\tb_usuarios;
use MF\Action;

class AuthController extends Action {
    public function cadastrar(){
        $debug = $this->validarDados($_POST['nome'], $_POST['senha'], $_POST['email']);

        $classe = new tb_usuarios();
        $classe->__set('email', $_POST['email']);

        $verificar_email = $classe->verificar_email();
        if(!$debug){
            $this->redirect('/?login=1');
            
        }elseif($verificar_email){
            $this->redirect('/?login=2');

        }else{
            $senhaMD5 = md5($_POST['senha']);
            $classe->__set('nome', $_POST['nome']);
            $classe->__set('senha', $senhaMD5);
            $classe->cadastrar();

            session_start();
            $_SESSION['autenticado'] = true;

            $this->AtualizarDadosNaSecao($classe);

            $this->redirect('/timeline');
        }
    }

    public function autenticar(){
        $senhaMD5 = md5($_POST['senha']);

        $classe = new tb_usuarios();

        $classe->__set('email', $_POST['email']);
        $classe->__set('senha', $senhaMD5);

        $autenticado = $classe->autenticar();

        if($autenticado){
            session_start();
            $_SESSION['autenticado'] = true;
            $_SESSION['administrador'] = false;
            $this->AtualizarDadosNaSecao($classe);

            if($_SESSION['administrador'] === 1){
                echo ' você é um administrador';
                $this->redirect('/admin');
            }else {
                echo 'você não é um administrador';
                $this->redirect('/timeline');
            }
        }else {
            $this->redirect('/?login=3');
        }
    }

    public function EnviarEmail($email, $usuario, $conteudo){
        $mail = new PHPMailer(true);
    
        try {
            // Configurações do servidor
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';    // Servidor SMTP do Gmail
            $mail->SMTPAuth   = true;                // Ativar autenticação SMTP
            $mail->Username   = 'myfriendcircletcc@gmail.com'; // Seu endereço de e-mail Gmail
            $mail->Password   = 'wkad qcyx nrmc kxmy';         // Sua senha do Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS
            $mail->Port       = 587;                 // Porta para TLS
    
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
    
            // Remetente
            $mail->setFrom('myfriendcircletcc@gmail.com', 'Serviço de Supor My Friend Circle');
    
            // Destinatário
            $mail->addAddress($email, $usuario);
    
            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Solicitação para redefinir sua senha';
    
            $mail->Body    = $conteudo;
            $mail->AltBody = '<a href="localhost:8080/" id="textcolor" class="btn">Redefinir Senha</a>';
    
            // Enviar o e-mail
            $mail->send();
        } catch (Exception $e) {
            echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
        }
    }

    public function recuperarsenha(){
        $classe = new tb_usuarios();

        if(isset($_POST['tokenValidado'])){
            $senha = $_POST['senha'];
            $id = $classe->buscarID($_SESSION['email']);

            $classe->__set('id', $id);
            $classe->__set('senha', $senha);
            $classe->atualizarSenha();

            $this->redirect('/');
        }else if(isset($_GET['token'])){
            $token = $_GET['token'];

            if($classe->verificarToken($token)){
                $this->render('index.redefinirSenha');
            }else {

                $this->redirect('/');
            }
        }else {
            $classe->__set('email', $_POST['email']);

            $verificar_email = $classe->verificar_email();

            if($verificar_email){
                $id = $classe->buscarID($_POST['email']);
                $dados = $classe->BuscarDados($id);

                $classe->__set('id', $dados['id']);

                $tokenTamanho = 200;
                $token = substr(bin2hex(random_bytes($tokenTamanho / 2)), 0, $tokenTamanho);

                $_SESSION['token'] = $token;
                $_SESSION['email'] = $dados['email'];

                $classe->atualizartoken($token);

                $this->EnviarEmail($_POST['email'], $dados['nome'], $this->layout_return('EmailRedefinirSenha'));
                $this->redirect('/?login=3&erro=1');
            } else {

                $this->redirect('/');
            }
        }
    }

    public function AtualizarDadosNaSecao($classe){
        $id = $classe->buscarID($_POST['email']);
        $dados = $classe->BuscarDados($id);

        $_SESSION['nome'] = $dados['nome'];
        $_SESSION['sobremim'] = $dados['sobremim'];
        $_SESSION['email'] = $dados['email'];
        $_SESSION['administrador'] = $dados['administrador'];
    }

    public function validarDados($nome, $senha, $email){
        $debug = true;

        $nome = str_replace(' ', '', $nome);
        $email = str_replace(' ', '', $email);

        if($nome == '' || $email == ''){
            $debug = false;
        }

        if(strlen($senha) > 32) {
            $debug = false;
        }

        if(strlen($nome) > 120) {
            $debug = false;
        }

        if(strlen($email) > 200) {
            $debug = false;
        }

        return $debug;
    }


    public function sair(){
        session_start();
        session_destroy();

        $this->redirect('/');
    }
}