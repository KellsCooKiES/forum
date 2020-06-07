<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;


use mysql_xdevapi\Session;
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

    $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
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
/**
 * @test
 */
    public function a_thread_requires_a_title()
    {

        $this->publishThread(['title'=> null])->assertSessionHasErrors('title');

    }
    /**
     * @test
     */
    public function a_thread_requires_a_body()
    {

        $this->publishThread(['body'=> null])->assertSessionHasErrors('body');

    }/**
 * @test
 */
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel',2)->create();
        $this->publishThread(['channel_id'=> null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id'=> 999])
            ->assertSessionHasErrors('channel_id');

    }

    public function publishThread( $overrides=[])
    {
        $this->actingAs(factory('App\User')->create());
        $thread = factory('App\Thread')->make($overrides);

      return  $this->post('/threads',$thread->toArray());

    }


}
