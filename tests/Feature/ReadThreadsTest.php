<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;


    public function setUp():void
    {
        parent::setUp();
       $this->thread= factory('App\Thread')->create();
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
        $response =$this->get('/threads/'.$this->thread->id);
        $response->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function a_user_can_read_replies_that_assoc_with_thread()
    {
      $reply= factory('App\Reply')->create(['thread_id' => $this->thread->id]);

      $response=$this->get('/threads/'.$this->thread->id);
      $response->assertSee($reply->body);


    }
}
