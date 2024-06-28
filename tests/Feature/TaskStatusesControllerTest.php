<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TaskStatusesControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed');
    }

    public function testIndex()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('task_statuses.create'));
        $response->assertStatus(200);
    }

    public function testCreateForbidden()
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertStatus(403);
    }

    public function testStore()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('task_statuses.create'))
            ->post(route('task_statuses.store'), [
                'name' => 'name status'
            ]);

        $response->assertRedirect(route('task_statuses.index'));

        $response2 = $this->get(route('task_statuses.index'));
        $response2->assertSeeText('name status');
    }

    public function testEdit()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('task_statuses.edit', $status));
        $response->assertStatus(200);
    }

    public function testEditForbidden()
    {
        $status = TaskStatus::factory()->create();
        $response = $this->get(route('task_statuses.edit', $status));
        $response->assertStatus(403);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $newStatusName = 'changed name status';
        $response = $this
            ->actingAs($user)
            ->from(route('task_statuses.edit', $status))
            ->patch(route('task_statuses.update', $status), [
                'name' => $newStatusName
            ]);

        $response->assertRedirect(route('task_statuses.index'));
        $response2 = $this->get(route('task_statuses.index'));
        $response2->assertSeeText($newStatusName);
    }

    public function testDelete()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('task_statuses.destroy', $status));
        $response->assertRedirect(route('task_statuses.index'));

        $response2 = $this->get(route('task_statuses.index'));
        $response2->assertDontSeeText($status->name);
    }

    public function testDeleteForbidden()
    {
        $status = TaskStatus::factory()->create();
        $response = $this->delete(route('task_statuses.destroy', $status));
        $response->assertStatus(403);
    }
}
