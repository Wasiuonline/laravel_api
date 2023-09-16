<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeesTest extends TestCase
{
    public function test_employees_record_found(): void
    {
        $response = $this->get('/api/employees/3');
        $response->assertSee("email");
        $response->assertStatus(200);
    }
    public function test_employees_record_found_2(): void
    {
        $response = $this->get('/api/employees/3');
        $response->assertDontSee("Employee not found");
        $response->assertStatus(200);
    }
    public function test_employees_record_not_found(): void
    {
        $response = $this->get('/api/employees/10');
        $response->assertSee("Employee not found");
        $response->assertStatus(404);
    }
    /*public function text_employee_record_viewed(){
        $employee = [ 
            "name" => "Ola",
            "email" => "ola@gmail.com"
        ];
        $response = $this->get('/api/employees');
        $response->assertViewHas('post', function($collection) use($employee){
            $collection->contains($employee);
        });
        $response->assertStatus(200);
    }*/
}
