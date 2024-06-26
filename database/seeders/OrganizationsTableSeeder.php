<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    public function run(): void
    {
        Factory::factory(Organization::class, 10)->create();
    }
}
