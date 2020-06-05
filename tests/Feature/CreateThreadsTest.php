<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;


use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;



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
    public function guests_may_not_create_threads()
    {
        $this->get('/threads/create')
            ->assertRedirect('/login');
        $this->post('/threads')
            ->assertRedirect('/login');
    }




}
