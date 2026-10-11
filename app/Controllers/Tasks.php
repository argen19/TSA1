<?php

namespace App\Controllers;

use App\Models\TaskModel;

class Tasks extends BaseController
{
    public function index(): string
    {
        return view('tasks/index', ['tasks' => (new TaskModel())->allByDate()]);
    }
}
