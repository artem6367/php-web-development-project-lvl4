<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskStatusesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $this->get('/task_statuses')
            ->assertStatus(200);
    }

    public function testCreate()
    {
        $user = User::factory()->create();

        $this->get('/task_statuses/create')
            ->assertStatus(403);

        $this->actingAs($user)
            ->get('/task_statuses/create')
            ->assertStatus(200);
    }

    public function testStore()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from('/task_statuses/create')
            ->post('/task_statuses', [
                'name' => 'name status'
            ])->assertRedirect('/task_statuses');

        $this->get('/task_statuses')
            ->assertSeeText('name status');
    }

    public function testEdit()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $this->get("/task_statuses/{$status->id}/edit")
            ->assertStatus(403);

        $this->actingAs($user)
            ->get("/task_statuses/{$status->id}/edit")
            ->assertStatus(200);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $newStatusName = 'changed name status';
        $this
            ->actingAs($user)
            ->from("/task_statuses/{$status->id}/edit")
            ->patch("/task_statuses/{$status->id}", [
                'name' => $newStatusName
            ])->assertRedirect('/task_statuses');

        $this->get('/task_statuses')
            ->assertSeeText($newStatusName);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $this->delete("/task_statuses/{$status->id}")
            ->assertStatus(403);

        $task = Task::factory()->create(['status_id' => $status->id]);

        $this->actingAs($user)
            ->delete("/task_statuses/{$status->id}")
            ->assertRedirect('/task_statuses');

        $this->get('/task_statuses')->assertSeeText($status->name);

        $task->delete();

        $this->actingAs($user)
            ->delete("/task_statuses/{$status->id}")
            ->assertRedirect('/task_statuses');

        $this->get('/task_statuses')
            ->assertDontSeeText($status->name);
    }
}
