<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;


    private $thread;

    public function setUp(): void
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /**
     * @test
     */
    public function a_user_can_browser_threads()
    {
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);

    }

    /**
     * @test
     */
    public function a_user_can_read_a_single_thread()
    {
        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function a_user_can_read_replies_that_assoc_with_thread()
    {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $response = $this->get($this->thread->path());
        $response->assertSee($reply->body);
    }

    /**
     * @test
     */
    public function a_user_can_filter_the_threads_according_to_a_tag()
    {

        $channel = factory('App\Channel')->create();
        $threadInChannel = factory('App\Thread')->create(['channel_id' => $channel->id]);
        $threadNotInChannel = factory('App\Thread')->create();

        $this->withoutExceptionHandling()->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /**
     * @test
     */
    public function a_user_can_filter_threads_by_a_username()
    {
        $this->actingAs(factory('App\User')->create(['name' => 'SpiderMan']));
        $threadBySpiderMan = factory('App\Thread')->create(['user_id' => auth()->id()]);

        $threadNotBySpiderMan = factory('App\Thread')->create();
        $this->get('/threads?by=SpiderMan')
            ->assertSee($threadBySpiderMan->title)
            ->assertDontSee($threadNotBySpiderMan->title);
    }

    /**
     * @test
     */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies=$this->thread;
        factory('App\Reply',2)->create(['thread_id'=>$threadWithTwoReplies->id]);

        $threadWithThreeReplies= factory('App\Thread')->create();
        factory('App\Reply',3)->create(['thread_id'=>$threadWithThreeReplies->id]);

        $threadWithNoReplies= factory('App\Thread')->create();

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
