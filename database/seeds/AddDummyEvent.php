<?php

use Illuminate\Database\Seeder;
use App\Registration;

class AddDummyEvent extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title'=>'Пациент 1', 'start_date'=>'2019-02-26', 'end_date'=>'2019-02-26'],
            ['title'=>'Пациент 2', 'start_date'=>'2019-02-26', 'end_date'=>'2019-02-26'],
            ['title'=>'Пациент 3', 'start_date'=>'2019-02-26', 'end_date'=>'2019-02-26'],
            ['title'=>'Пациент 4', 'start_date'=>'2019-02-26', 'end_date'=>'2019-02-26'],
        ];
        foreach ($data as $key => $value) {
            Registration::create($value);
        }
    }
}
