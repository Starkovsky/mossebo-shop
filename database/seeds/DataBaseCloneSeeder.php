<?php

use Illuminate\Database\Seeder;

class DataBaseCloneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $live_database = DB::connection('pgsql-production');
        $all_tables = $live_database->select('
            SELECT table_name 
            FROM information_schema.tables 
            WHERE table_schema = \'public\'
        ');
        //var_dump($live_database) ;


        // Disable All trigers
        foreach ($all_tables as $table) {
            //echo $table->table_name . "\r\n";
            if ($table->table_name != 'migrations') {
                DB::raw('ALTER TABLE' . $table->table_name . ' DISABLE TRIGGER ALL');
                echo "Disable TRIGGER for " . $table->table_name . "\r\n";
            }
        }
        // Get table data from production
        foreach ($all_tables as $table) {
            echo $table->table_name . " start\r\n";
            foreach ($live_database->table($table->table_name)->get() as $data) {
                // Save data to staging database - default db connection
                if ($table->table_name != 'migrations') {
                    DB::table($table->table_name)->insert((array)$data);
                }
            }
            echo $table->table_name . " end\r\n";
        }
    }
}
