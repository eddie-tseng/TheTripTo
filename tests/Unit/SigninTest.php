<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Entities\User;

class SigninTest extends TestCase
{
    use RefreshDatabase;

    public function testSignin_PositiveTest()
    {
        factory(User::class)->create([
            'account' => 'test@mail.com',
            'photo' => 'img/user/test.jpg'
           ]);

        $this->post('/sign-in', [
            'account' => 'test@mail.com',
            'password' => '88888888',
            ])
            ->assertRedirect('/')
            ->assertSessionHas('user_id', 1)
            ->assertSessionHas('photo', url('img/user/test.jpg'));
    }


    public function testSignin_NegativeTest()
    {
        factory(User::class)->create([
            'account' => 'test@mail.com',
            'photo' => 'img/user/test.jpg'
           ]);

        //account fail
        $this->post('/sign-in', [
            'account' => 't@mail.com',
            'password' => '88888888',
            ])
            ->assertRedirect('/')
            ->assertSessionHasErrors();

        //password fail
        $this->post('/sign-in', [
            'account' => 'test@mail.com',
            'password' => '8',
            ])
            ->assertRedirect('/')
            ->assertSessionHasErrors();
    }
}
