<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;
   /**
    * @test
    */
    public function an_auth_user_can_create_threads()
    {
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->make();

        $this->post('/threads', $thread->toArray());

        $this->get('/threads/' . $thread->id)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
    /**
     * @test
     */
    public function unauth_user_may_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = factory('App\Thread')->make();

        $this->post('/threads', $thread->toArray());

    }
}
