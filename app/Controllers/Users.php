<?php

namespace App\Controllers;

class Users extends BaseController
{
    public function index(): string
    {
        $data['users'] = [
            ['username' => 'admin01', 'full_name' => 'Kim Cortez', 'role' => 'Administrator'],
            ['username' => 'cashier01', 'full_name' => 'Ellimac Key', 'role' => 'Cashier'],
            ['username' => 'cashier02', 'full_name' => 'Camille Ye', 'role' => 'Cashier'],
            ['username' => 'manager01', 'full_name' => 'Thea Maine', 'role' => 'Store Manager'],
            ['username' => 'staff01', 'full_name' => 'Ali Rain', 'role' => 'Sales Staff'],
        ];

        return view('users/index', $data);
    }
}
