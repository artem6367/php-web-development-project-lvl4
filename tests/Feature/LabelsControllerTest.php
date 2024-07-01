<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\TaskLabel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $this->get('/labels')
            ->assertStatus(200);
    }

    public function testCreate()
    {
        $user = User::factory()->create();

        $this->get('/labels/create')
            ->assertStatus(403);

        $this->actingAs($user)
            ->get('/labels/create')
            ->assertStatus(200);
    }

    public function testStore()
    {
        $user = User::factory()->create();

        $this->from('/labels/create')
            ->post('/labels', [
                'name' => 'new label',
                'description' => 'description new label',
            ])->assertStatus(403);

        $this->actingAs($user)
            ->from('/labels/create')
            ->post('/labels', [
                'name' => 'new label',
                'description' => 'description new label',
            ])->assertRedirect('/labels');

        $this->get('/labels')
            ->assertSeeText('new label');
    }

    public function testEdit()
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();

        $this->get("/labels/{$label->id}/edit")
            ->assertStatus(403);

        $this->actingAs($user)
            ->get("/labels/{$label->id}/edit")
            ->assertStatus(200);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();

        $this->from('/labels')
            ->patch("/labels/{$label->id}", [
                'name' => 'updated label name',
                'description' => 'updated label description',
            ])->assertStatus(403);

        $this->actingAs($user)
            ->from('/labels')
            ->patch("/labels/{$label->id}", [
                'name' => 'updated label name',
                'description' => 'updated label description',
            ])->assertRedirect('/labels');

        $this->get('/labels')
            ->assertSeeText('updated label name');
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();

        $this->from('/labels')
            ->delete("/labels/{$label->id}")
            ->assertStatus(403);

        $taskLabel = TaskLabel::factory()->create(['label_id' => $label->id]);

        $this->actingAs($user)
            ->from('/labels')
            ->delete("/labels/{$label->id}")
            ->assertRedirect('/labels');

        $this->get('/labels')
            ->assertSeeText($label->description);

        $taskLabel->delete();

        $this->actingAs($user)
            ->from('/labels')
            ->delete("/labels/{$label->id}")
            ->assertRedirect('/labels');

        $this->get('/labels')
            ->assertDontSeeText($label->description);
    }
}
