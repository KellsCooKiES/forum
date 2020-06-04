<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function unauth_user_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads/1/replies',[]);
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

        $this->get('/threads/'.$thread->id)
            ->assertSee($reply->body);
    }
}
