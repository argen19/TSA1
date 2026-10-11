<?php

use App\Database\Seeds\TaskSeeder;
use App\Models\TaskModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/** Tests use the isolated in-memory SQLite tests group, never the live database. */
final class TaskManagementTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $namespace = 'App';
    protected $seed = TaskSeeder::class;
    protected $refresh = true;

    public function testSeedMeetsRequiredCountsAndDates(): void
    {
        $this->assertSame(8, $this->db->table('tasks')->countAllResults());
        $this->assertSame(1, $this->db->table('users')->countAllResults());
        $dates = $this->db->table('tasks')->select('task_date')->distinct()->get()->getResultArray();
        $this->assertCount(3, $dates);
        $this->assertContains(Time::today(config('App')->appTimezone)->toDateString(), array_column($dates, 'task_date'));
    }

    public function testWelcomeOnlyShowsToday(): void
    {
        $response = $this->get('/');
        $response->assertOK();
        $response->assertSee('Check the team task schedule');
        $response->assertSee('Prepare the daily progress report');
        $response->assertSee('Review and verify pending tasks');
        $response->assertDontSee('Organize the shared project files');
        $response->assertDontSee('Plan the next team meeting');
        $this->assertCount(3, (new TaskModel())->forDate(Time::today(config('App')->appTimezone)->toDateString()));
    }

    public function testTaskListShowsEveryTaskInDateOrder(): void
    {
        $tasks = (new TaskModel())->allByDate();
        $this->assertCount(8, $tasks);
        $dates = array_column($tasks, 'task_date');
        $sorted = $dates;
        sort($sorted);
        $this->assertSame($sorted, $dates);

        $response = $this->get('/tasks');
        $response->assertOK();
        foreach ($tasks as $task) {
            $response->assertSee($task['title']);
        }
    }

    public function testProfileReadsSingleDemoUser(): void
    {
        $this->db->table('users')->where('username', 'admin01')->update(['full_name' => 'Changed Demo Name']);
        $response = $this->get('/profile');
        $response->assertOK();
        $response->assertSee('Changed Demo Name');
        $response->assertSee('admin01');
        $response->assertSee('kim.cortez@gmail.com');
    }

    public function testAboutIdentifiesDeveloper(): void
    {
        $response = $this->get('/about');
        $response->assertOK();
        $response->assertSee('Edzel Kim Arce');
        $response->assertSee('ECARCE');
    }

    public function testSeederCanBeRepeatedWithoutDuplicateRecords(): void
    {
        $this->seed(TaskSeeder::class);
        $this->seed(TaskSeeder::class);
        $this->assertSame(8, $this->db->table('tasks')->countAllResults());
        $this->assertSame(1, $this->db->table('users')->countAllResults());
    }

    public function testSeederRefreshesSampleDates(): void
    {
        $title = 'Prepare the daily progress report';
        $this->db->table('tasks')->where('title', $title)->update(['task_date' => '2000-01-01']);
        $this->seed(TaskSeeder::class);
        $this->seeInDatabase('tasks', ['title' => $title, 'task_date' => Time::today(config('App')->appTimezone)->toDateString()]);
    }

    public function testTodayCanBeEmptyWhileFullListStillHasTasks(): void
    {
        $this->db->table('tasks')->where('id >', 0)->update(['task_date' => '2000-01-01']);
        $response = $this->get('/');
        $response->assertOK();
        $response->assertSee('No tasks scheduled for today.');
        $this->assertCount(8, (new TaskModel())->allByDate());
    }

    public function testEmptyDatabaseHasUsefulEmptyStates(): void
    {
        $this->db->table('tasks')->where('id >', 0)->delete();
        $this->db->table('users')->where('id >', 0)->delete();
        $list = $this->get('/tasks');
        $list->assertOK();
        $list->assertSee('No tasks have been recorded yet.');
        $profile = $this->get('/profile');
        $profile->assertOK();
        $profile->assertSee('No profile available.');
    }

    public function testTaskOutputEscapesHtml(): void
    {
        $model = new TaskModel();
        $id = $model->insert([
            'title' => '<script>alert("task")</script>',
            'task_date' => Time::today(config('App')->appTimezone)->toDateString(),
        ]);
        $this->assertNotFalse($id);
        $this->assertSame('pending', $model->find($id)['status']);
        $response = $this->get('/');
        $response->assertOK();
        $body = (string) $response->response()->getBody();
        $this->assertStringNotContainsString('<script>alert("task")</script>', $body);
        $this->assertStringContainsString('&lt;script&gt;', $body);
    }
}
