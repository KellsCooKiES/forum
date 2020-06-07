<?php

namespace Tests\Unit;

use \App\Reply;
use \App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use \Tests\TestCase;

class ChannelTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    public function a_chanel_consists_of_threads()
    {
     $channel = factory('App\Channel')->create();
     $thread = factory('App\Thread')->create(['channel_id'=>$channel->id]);

       $this->assertTrue($channel->threads->contains($thread));
    }
}
