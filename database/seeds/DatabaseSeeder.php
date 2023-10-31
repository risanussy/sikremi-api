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
        $this->call([
            ProvincesTableSeeder::class,
            CitiesTableSeeder::class,
            
            UsersTableSeeder::class,
            AdministratorsTableSeeder::class,
            // EngineersTableSeeder::class,

            // PartnersTableSeeder::class,
            // PartnerUsersTableSeeder::class,
            // CategoriesTableSeeder::class,
            // BuildingsTableSeeder::class,
            // ProceduresTableSeeder::class,
            // PreventiveProceduresTableSeeder::class,
            // EquipmentsTableSeeder::class,

            // WorkOrdersTableSeeder::class,
            // SchedulesTableSeeder::class,
            // PreventiveSchedulesTableSeeder::class,
            // CorrectiveSchedulesTableSeeder::class,
            // TeamsTableSeeder::class,

            // PreventiveReportsTableSeeder::class,
            // PreventiveReportDetailsTableSeeder::class,
            // CorrectiveReportsTableSeeder::class,
        ]);
    }
}
