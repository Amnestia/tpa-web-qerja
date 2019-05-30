<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountrySeeder::class);
        $this->call(CitySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ProsSeeder::class);
        $this->call(ConsSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(SalaryPeriodSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(PeriodSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(SalarySeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(FollowSeeder::class);
        $this->call(HelpfulSeeder::class);
        $this->call(JobSeeder::class);
        // $this->call(Seeder::class);
    }
}
