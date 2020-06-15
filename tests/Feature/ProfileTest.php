<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;



class ProfileTest extends TestCase
{
    use DatabaseMigrations;
/**
 * @test
 */
    public function a_user_has_a_profile()
    {
        $user = factory('App\User')->create();
        $this->withoutExceptionHandling()->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }

    /**
     * @test
     */
    public function profiles_display_all_users_threads()
    {
        $user = factory('App\User')->create();
        $thread = factory('App\Thread')->create(['user_id'=>$user->id]);
        $this->get("/profiles/{$user->name}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
