<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use RuntimeException;

class TaskSeeder extends Seeder
{
    public function run()
    {
        if ($this->db->table('users')->countAllResults() > 1) {
            throw new RuntimeException('The TSA1 users table must contain exactly one demo user. Use a dedicated assessment database; this seeder will not delete existing users.');
        }

        $timezone = config('App')->appTimezone;
        $today = Time::today($timezone);
        $createdAt = Time::now($timezone)->toDateTimeString();
        $samples = [
            ['Review yesterday\'s progress', 'completed', -1],
            ['Organize the shared project files', 'completed', -1],
            ['Check the team task schedule', 'completed', 0],
            ['Prepare the daily progress report', 'in progress', 0],
            ['Review and verify pending tasks', 'pending', 0],
            ['Plan the next team meeting', 'pending', 1],
            ['Update the project documentation', 'pending', 1],
            ['Back up the project database', 'pending', 1],
        ];

        $this->db->transStart();
        foreach ($samples as [$title, $status, $offset]) {
            $date = $today->addDays($offset)->toDateString();
            $existing = $this->db->table('tasks')->where('title', $title)->get()->getRowArray();
            if ($existing === null) {
                $this->db->table('tasks')->insert([
                    'title' => $title,
                    'status' => $status,
                    'task_date' => $date,
                    'created_at' => $createdAt,
                ]);
            } else {
                // Rerunning refreshes only sample dates, preserving status and creation time.
                $this->db->table('tasks')->where('id', $existing['id'])->update(['task_date' => $date]);
            }
        }

        if ($this->db->table('users')->countAllResults() === 0) {
            // Preserve the original project's first demo user name and username.
            $this->db->table('users')->insert([
                'username' => 'admin01',
                'full_name' => 'Kim Cortez',
                'email' => 'kim.cortez@gmail.com',
                'created_at' => $createdAt,
            ]);
        }
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            throw new RuntimeException('Seeding failed; the database transaction was rolled back.');
        }
    }
}
