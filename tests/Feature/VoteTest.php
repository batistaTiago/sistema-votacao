<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\DocumentStatus;
use App\Models\User;
use App\Models\Vote;
use Tests\TestCase;
class VoteTest extends TestCase
{

    /** @test */
    public function basic_vote_registry()
    {

        $document = factory(Document::class)->create([
            'document_status_id' => DocumentStatus::DOC_STATUS_EM_VOTACAO
        ]);

        $post_data = factory(Vote::class)->raw([
            'document_id' => $document->id,
        ]);

        $this->assertEquals(0, Vote::count());

        $response = $this->post(route('api.register-vote'), $post_data, $this->headers);

        $this->assertEquals(1, Vote::count());

        $vote = Vote::first();

        foreach ($post_data as $key => $value) {
            $this->assertEquals($value, $vote->$key);
        }

        $response->assertStatus(200);
    }

    /** @test */
    public function an_user_can_not_vote_twice_on_the_same_document()
    {
        $document = factory(Document::class)->create([
            'document_status_id' => DocumentStatus::DOC_STATUS_EM_VOTACAO
        ]);

        $post_data = factory(Vote::class)->raw([
            'document_id' => $document->id,
        ]);

        $this->assertEquals(0, Vote::count());

        $response = $this->post(route('api.register-vote'), $post_data, $this->headers);
        $response->assertStatus(200);

        $this->assertEquals(1, Vote::count());

        $response = $this->post(route('api.register-vote'), $post_data, $this->headers);

        $this->assertEquals(1, Vote::count());

        $vote = Vote::first();

        foreach ($post_data as $key => $value) {
            $this->assertEquals($value, $vote->$key);
        }

        $response->assertStatus(200);
    }

    /** @test */
    public function an_user_can_only_vote_on_documents_open_for_voting()
    {
        $document = factory(Document::class)->create([
            'document_status_id' => DocumentStatus::DOC_STATUS_VISTA
        ]);

        $post_data = factory(Vote::class)->raw([
            'document_id' => $document->id,
        ]);

        $this->assertEquals(0, Vote::count());

        $response = $this->post(route('api.register-vote'), $post_data, $this->headers);
        $response->assertStatus(200);

        $this->assertEquals(0, Vote::count());

    }

    /** @test */
    public function vote_registry_validation_document_id_is_required()
    {
        $user = factory(User::class)->create();

        $post_data = [
            'session_id' => 1,
            'user_id' => $user->id,
            'vote_category_id' => 1,
        ];

        $this->assertEquals(0, Vote::count());

        $response = $this->post(route('api.register-vote'), $post_data, $this->headers);
        $response->assertStatus(422);

        $this->assertEquals(0, Vote::count());

    }

    /** @test */
    public function vote_registry_validation_session_id_is_required()
    {
        $user = factory(User::class)->create();

        $post_data = [
            'document_id' => 1,
            'user_id' => $user->id,
            'vote_category_id' => 1,
        ];

        $this->assertEquals(0, Vote::count());

        $response = $this->post(route('api.register-vote'), $post_data, $this->headers);
        $response->assertStatus(422);

        $this->assertEquals(0, Vote::count());

    }

    /** @test */
    public function vote_registry_validation_user_id_is_required()
    {
        $user = factory(User::class)->create();

        $post_data = [
            'document_id' => 1,
            'session_id' => 1,
            'vote_category_id' => 1,
        ];

        $this->assertEquals(0, Vote::count());

        $response = $this->post(route('api.register-vote'), $post_data, $this->headers);
        $response->assertStatus(422);

        $this->assertEquals(0, Vote::count());

    }

    /** @test */
    public function vote_registry_validation_vote_category_id_is_required()
    {
        $user = factory(User::class)->create();

        $post_data = [
            'document_id' => 1,
            'session_id' => 1,
            'user_id' => $user->id,
        ];

        $this->assertEquals(0, Vote::count());

        $response = $this->post(route('api.register-vote'), $post_data, $this->headers);
        $response->assertStatus(422);

        $this->assertEquals(0, Vote::count());

    }
}
