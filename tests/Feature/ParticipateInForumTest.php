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

    /**
     * @test
     */
    public function unauth_user_cannot_delete_reply()
    {


       $reply = factory('App\Reply')->create();

       $this->delete('/replies/{$reply->id}')
           ->assertRedirect('login');

       $this->actingAs(factory('App\User')->create())
           ->delete("/replies/{$reply->id}")
           ->assertForbidden();

    }
    /**
     * @test
     */
    public function auth_user_can_delete_a_reply()
    {
        $user= factory('App\User')->create();
        $reply = factory('App\Reply')->create(['user_id'=>$user->id]);
        $this->actingAs($user)
        ->delete("/replies/{$reply->id}")->assertStatus(302);
        $this->assertDatabaseMissing('replies',['id'=> $reply->id]);


    }

    /**
     * @test
     */
    public function auth_users_can_update_replies()
    {
        $updatedReply = 'You been changed';
        $this->actingAs($user = factory('App\User')->create());
        $reply = factory('App\Reply')->create(['user_id' => $user->id]);
        $this->patch('/replies/' . $reply->id, ['body' => $updatedReply]);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }
    /**
     * @test
     */
    public function unauth_user_cannot_update_reply()
    {
        $reply = factory('App\Reply')->create();

        $this->patch('/replies/{$reply->id}')
            ->assertRedirect('login');

        $this->actingAs(factory('App\User')->create())
            ->patch("/replies/{$reply->id}")
            ->assertForbidden();

    }
}
