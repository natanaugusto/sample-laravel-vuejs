<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test the WhereLike Builder Macro with the User Model
 */
class BuilderWhereLikeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testWhereLikeTest()
    {
      $user = factory(User::class)->create();
      $search = User::whereLike(['email', 'name'], substr($user->name, 0, 3))->first();
      $this->assertEquals($user->toArray(), $search->toArray());
    }
}
