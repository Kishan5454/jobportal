<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobType;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // JobType::truncate();
        // Insert job types
        $jobTypes = ['Remote', 'Part time', 'Full Time','On Site','Hybrid'];
        foreach ($jobTypes as $jobType) {
            JobType::create(['jobtype_name' => $jobType]);
        }
    }
}
