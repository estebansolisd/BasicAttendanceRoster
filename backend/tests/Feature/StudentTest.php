<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_should_return_students()
    {
        $this->seed();
        $response = $this->get('/api/students');

        $response->assertJsonStructure([
            [
                "student_id",
                "first_name",
                "last_name",
                "email",
                "attendance",
            ],
        ]);
    }
}
