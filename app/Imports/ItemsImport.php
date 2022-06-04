<?php

namespace App\Imports;

use App\Brand;
use App\Category;
use App\estimated_prices;
use App\items;
use App\Model1;
use App\product;
use App\Products;
use App\retailers_requests;
use App\sub_categories;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Auth;

class ItemsImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     *
     */

    public $data = array();

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        $suppliers = retailers_requests::where('retailer_id',$user_id)->where('status',1)->where('active',1)->pluck('supplier_id');

        if($row[1] && $row[3] && $row[6] && $row[7])
        {
            if($row[2])
            {
                $sub_categories = explode(',', $row[2]);
            }
            else
            {
                $sub_categories = [];
            }

            if($row[9])
            {
                $related_products = explode(',', $row[9]);
            }
            else
            {
                $related_products = [];
            }

            $category = Category::where('cat_name', $row[1])->first();
            $sub_categories = sub_categories::whereIn('cat_name', $sub_categories)->pluck('id')->toArray();

            if(count($sub_categories) == 0)
            {
                $sub_categories = NULL;
            }
            else
            {
                $sub_categories = implode(",",$sub_categories);
            }

            $related_products = product::whereIn('title', $related_products)->whereIn('user_id',$suppliers)->where('deleted_at',NULL)->pluck('id')->toArray();

            if(count($related_products) == 0)
            {
                $related_products = NULL;
            }
            else
            {
                $related_products = implode(",",$related_products);
            }

            if($category)
            {
                if($row[0])
                {
                    $check = items::where('id',$row[0])->where('user_id',$user_id)->first();

                    if(!$check)
                    {
                        $check1 = items::leftjoin('categories', 'categories.id', '=', 'items.category_id')->where('items.user_id',$user_id)->where('items.title', $row[3])->where('categories.cat_name', $row[1])->select('products.*')->first();

                        if(!$check1)
                        {
                            $check = new items;
                            $check->user_id = $user_id;
                            $check->category_id = $category->id;
                            $check->sub_category_ids = $sub_categories;
                            $check->cat_name = $row[3];
                            $check->description = $row[8];
                            $check->rate = $row[6];
                            $check->sell_rate = $row[7];
                            $check->products = $related_products;
                            $check->product_id = $row[4];
                            $check->supplier = $row[5];
                            $check->excel = 1;
                            $check->save();

                            $this->data[] = $check->id;
                        }
                        else
                        {
                            $check1->user_id = $user_id;
                            $check1->category_id = $category->id;
                            $check1->sub_category_ids = $sub_categories;
                            $check1->cat_name = $row[3];
                            $check1->description = $row[8];
                            $check1->rate = $row[6];
                            $check1->sell_rate = $row[7];
                            $check1->products = $related_products;
                            $check1->product_id = $row[4];
                            $check1->supplier = $row[5];
                            $check1->excel = 1;
                            $check1->save();

                            $this->data[] = $check1->id;
                        }
                    }
                    else
                    {
                        $check->user_id = $user_id;
                        $check->category_id = $category->id;
                        $check->sub_category_ids = $sub_categories;
                        $check->cat_name = $row[3];
                        $check->description = $row[8];
                        $check->rate = $row[6];
                        $check->sell_rate = $row[7];
                        $check->products = $related_products;
                        $check->product_id = $row[4];
                        $check->supplier = $row[5];
                        $check->excel = 1;
                        $check->save();

                        $this->data[] = $check->id;
                    }

                }
                else {

                    $item = new items;
                    $item->user_id = $user_id;
                    $item->category_id = $category->id;
                    $item->sub_category_ids = $sub_categories;
                    $item->cat_name = $row[3];
                    $item->description = $row[8];
                    $item->rate = $row[6];
                    $item->sell_rate = $row[7];
                    $item->products = $related_products;
                    $item->product_id = $row[4];
                    $item->supplier = $row[5];
                    $item->excel = 1;
                    $item->save();
                }
            }
        }
    }
}
