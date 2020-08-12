<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EmployerSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(FloorSeeder::class);
        $this->call(NoSeeder::class);
        $this->call(AreaNoSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ElectricitySeeder::class);
        $this->call(StallSeeder::class);
        $this->call(StallElectricitySeeder::class);    
        $this->call(StallWaterSeeder::class);
        $this->call(InvoiceSeeder::class);
        $this->call(ReceiptSeeder::class);
        $this->call(InvoiceReceiptSeeder::class);
    }
}
