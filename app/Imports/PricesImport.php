<?php

namespace App\Imports;

use App\Brand;
use App\Category;
use App\estimated_prices;
use App\Model1;
use App\prices;
use App\Products;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PricesImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     *
     */

    public $data = array();

    public function __construct($table_id)
    {
        $this->table_id= $table_id;
    }


    public function collection(Collection $rows)
    {

        foreach ($rows as $i => $key)
        {
            if($i != 0)
            {
                foreach ($rows[$i] as $j => $temp)
                {
                    if($temp)
                    {
                        if($j != 0)
                        {
                            $x = $rows[0][$j];

                            if($x)
                            {
                                $prices = new prices;
                                $prices->table_id = $this->table_id;
                                $prices->x_axis = $x;
                                $prices->y_axis = $y;
                                $prices->value = $temp;
                                $prices->save();

                                $this->data[] = $prices->id;
                            }
                        }
                        else
                        {
                            $y = $temp;
                        }
                    }
                }
            }
        }

    }

}
