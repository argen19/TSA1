<?php

namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\I18n\Time;

class Pages extends BaseController
{
    public function index(): string
    {
        // One application-local date drives both the query and the page label.
        $today = Time::today(config('App')->appTimezone)->toDateString();

        return view('pages/index', [
            'today' => $today,
            'tasks' => (new TaskModel())->forDate($today),
        ]);
    }

    public function about(): string
    {
        return view('pages/about');
    }
}
