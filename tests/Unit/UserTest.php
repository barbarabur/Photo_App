<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Photo;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Profile_pic;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_mass_assignment()
    {
        $user = User::create([
            'name'=> 'Lola',
            'email'=> 'lola@lola.com',
            'password'=> bcrypt('password'),
            'role' => 'client'
        ]);

        $this->assertDatabaseHas('users', ['email' => 'lola@lola.com']);
    }

    public function test_user_has_one_profile()
    {
        $user = User::factory()->create();
        $pic = Profile_pic::factory()->for($user)->create();

        $this->assertInstanceOf(Profile_pic::class, $user->profile_pic);
        $this->assertEquals($user->id, $user->profile_pic->user_id);
    }

    public function test_user_has_many_orders() {
        $user = User::factory()->hasOrders(2)->create();
        $this->assertCount(2, $user->orders);
    }

    public function test_user_has_many_photos() {
        $user = User::factory()->hasPhotos(3)->create();
        $this->assertCount(3, $user->photos);
    }
    public function test_user_has_many_comments()
    {
        $user = User::factory()->hasComments(4)->create();
        $this->assertCount(4, $user->comments);
    }

    public function test_user_has_many_likes()
    {
        $user = User::factory()->hasLikes(5)->create();
        $this->assertCount(5, $user->likes);
    }

    public function test_user_has_many_LikedOn()
    {
        $user = User::factory()->create();
        Like::factory()->count(2)->create([
            'liekable_id'=>$user->id,
            'likeable_type'=>User::class,
        ]);
        $this->assertCount(2, $user->LikedOn);

    }

    public function user_has_role_method()
    {
        $user = new User(['role'=>'photographer']);
        $this->assertTrue($user->hasRole('photographer'));
        $this->assertFalse($user->hasRole('Client'));
    }

}
