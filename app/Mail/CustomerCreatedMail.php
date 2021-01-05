<?php

namespace App\Mail;

class CustomerCreatedMail
{
    public function html($attributes)
    {
        return '
            Bem-Vindo ao portal <b>Sweet Media</b>! <br>
            <b>E-Mail:</b> ' . $attributes['customer']->email . ' <br>
            <b>Senha:</b> ' . $attributes['password'] . '<br>
            Por questões de segurança, recomendamos que <b>altere sua senha</b> após o primeiro acesso.
        ';
    }
}
