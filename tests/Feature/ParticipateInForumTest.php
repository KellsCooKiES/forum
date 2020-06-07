<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function unauth_user_may_not_add_replies()
    {


        $this->post('/threads/1/replies',[])->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function an_auth_user_may_participate_in_thr_forum()
    {
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply=factory('App\Reply')->make();

        $this->post('/threads/'.$thread->id.'/replies',$reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /**
     * @test
     */
    public function a_reply_requires_a_body()
    {
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->make(['body' => null]);

      $this->post('/threads/'.$thread->id.'/replies',$reply->toArray())
          ->assertSessionHasErrors('body');
    }
}
