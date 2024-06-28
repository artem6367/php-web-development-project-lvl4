<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TasksControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $this->get('/tasks')
            ->assertStatus(200);
    }

    public function testCreate()
    {
        $user = User::factory()->create();

        $this->get('/tasks/create')
            ->assertStatus(403);

        $this->actingAs($user)
            ->get('/tasks/create')
            ->assertStatus(200);
    }

    public function testStore()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $this->from('/tasks/create')
            ->post('/tasks', [
                'name' => 'newTask',
                'description' => 'newDescription',
                'status_id' => $status->id,
            ])->assertStatus(403);


        $this->actingAs($user)
            ->from('/tasks/create')
            ->post('/tasks', [
                'name' => 'newTask',
                'description' => 'newDescription',
                'status_id' => $status->id,
            ])->assertRedirect('/tasks');

        $this->get('/tasks')
            ->assertSeeText('newTask');
    }

    public function testShow()
    {
        $task = Task::factory()->create();

        $this->get("/tasks/{$task->id}")
            ->assertSeeText($task->name);
    }

    public function testEdit()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $this->get("/tasks/{$task->id}/edit")
            ->assertStatus(403);

        $this->actingAs($user)->get("/tasks/{$task->id}/edit")
            ->assertStatus(200);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $task = Task::factory()->create();

        $this->from("/tasks/{$task->id}/edit")
            ->patch("/tasks/{$task->id}", [
                'name' => 'changedTask',
                'description' => 'changedDescription',
                'status_id' => $status->id,
            ])->assertStatus(403);

        $this->actingAs($user)
            ->from("/tasks/{$task->id}/edit")
            ->patch("/tasks/{$task->id}", [
                'name' => 'changedTask',
                'description' => 'changedDescription',
                'status_id' => $status->id,
            ])->assertRedirect('/tasks');

        $this->get('/tasks')
            ->assertSeeText('changedTask');
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $myTask = Task::factory()->create(['created_by_id' => $user->id]);
        $otherTask = Task::factory()->create();

        $this->delete("/tasks/{$myTask->id}")
            ->assertStatus(403);

        $this->actingAs($user)
            ->delete("/tasks/{$otherTask->id}")
            ->assertStatus(403);

        $this->actingAs($user)
            ->delete("/tasks/{$myTask->id}")
            ->assertRedirect('/tasks');
    }
}
