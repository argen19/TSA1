<?php

namespace App\Controllers;

class Customers extends BaseController
{
    public function index(): string
    {
        $data['customers'] = [
            ['full_name' => 'Edzel Arce', 'email' => 'edzelarce@gmail.com', 'phone' => '09216799439'],
            ['full_name' => 'Nadine Carino', 'email' => 'ccarino@gmail.com', 'phone' => '09195235035'],
            ['full_name' => 'Jp Robes', 'email' => 'jprobes@gmail.com', 'phone' => '09195062310'],
            ['full_name' => 'Arby Puno', 'email' => 'arbypuno@gmail.com', 'phone' => '09247882574'],
            ['full_name' => 'Denzel Gavin', 'email' => 'denzelgavin@gmail.com', 'phone' => '09255872685'],
        ];

        return view('customers/index', $data);
    }
}
