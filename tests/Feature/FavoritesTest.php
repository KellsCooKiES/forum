<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;



   /**
    * @test
    */
    public function an_auth_user_can_fav_any_reply()
    {
        $this->actingAs(factory('App\User')->create());
        $reply = factory('App\Reply')->create();

        $this->post('/replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);


    }

    /**
     * @test
     */
    public function guest_can_not_fav_anything()
    {
        $this->post('/replies/1/favorites')
            ->assertRedirect('/login');
    }
    /**
     * @test
     */
    public function an_auth_user_may_only_fav_once()
    {
        $this->actingAs(factory('App\User')->create());
        $reply = factory('App\Reply')->create();

        $this->post('/replies/' . $reply->id . '/favorites');
        $this->post('/replies/' . $reply->id . '/favorites');
        $this->post('/replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }
    /**
    * @test
     */
        public function an_auth_user_can_unfav_any_reply()
        {
            $this->actingAs(factory('App\User')->create());

            $reply = factory('App\Reply')->create();

            $reply->favorite();

            $this->delete('/replies/' . $reply->id . '/favorites');

            $this->assertCount(0, $reply->favorites);


        }
}
