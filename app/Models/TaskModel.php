<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['title', 'status', 'task_date', 'created_at'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    // The assessment schema deliberately has no updated_at column.
    protected $updatedField = '';

    public function forDate(string $date): array
    {
        // SQL WHERE filtering: past and future records never enter this result.
        return $this->where('task_date', $date)->orderBy('id', 'ASC')->findAll();
    }

    public function allByDate(): array
    {
        // A stable tie-breaker keeps tasks on the same date in a consistent order.
        return $this->orderBy('task_date', 'ASC')->orderBy('id', 'ASC')->findAll();
    }
}
