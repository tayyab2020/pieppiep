<?php

namespace App\Imports;

use App\Brand;
use App\Category;
use App\estimated_prices;
use App\Model1;
use App\Products;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductsImport implements ToModel, WithStartRow
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

    public function incrementSlug($slug,$type) {

        $original = $slug;

        $count = 2;

        if($type == 1)
        {
            while (Category::where('cat_slug',$slug)->exists()) {
                $slug = "{$original}-" . $count++;
            }

            return $slug;
        }

        elseif($type == 2)
        {
            while (Brand::where('cat_slug',$slug)->exists()) {
                $slug = "{$original}-" . $count++;
            }

            return $slug;
        }
        else
        {
            while (Model1::where('cat_slug',$slug)->exists()) {
                $slug = "{$original}-" . $count++;
            }

            return $slug;
        }

    }

    public function model(array $row)
    {

        if($row[2] && $row[4] && $row[5] && $row[6])
        {
            $model_numbers = preg_replace("/,([\s])+/",",",$row[7]);
            $sizes = preg_replace("/,([\s])+/",",",$row[8]);
            $prices = preg_replace("/,([\s])+/",",",$row[10]);

            if($prices)
            {
                $pricesArray = explode(',', $prices);
            }
            else
            {
                $pricesArray = [];
            }

            $colors = preg_replace("/,([\s])+/",",",$row[15]);

            if($row[1])
            {
                $category = Category::where('cat_name',$row[4])->first();

                if(!$category)
                {
                    $cat_slug = Str::slug($row[4], "-");

                    if (Category::where('cat_slug',$cat_slug)->exists()) {
                        $cat_slug = $this->incrementSlug($cat_slug,1);
                    }

                    $category = new Category;
                    $category->cat_name = $row[4];
                    $category->cat_slug = $cat_slug;
                    $category->save();

                }

                $brand = Brand::where('cat_name',$row[5])->first();

                if(!$brand)
                {
                    $brand_slug = Str::slug($row[5], "-");

                    if (Brand::where('cat_slug',$brand_slug)->exists()) {
                        $brand_slug = $this->incrementSlug($brand_slug,2);
                    }

                    $brand = new Brand;
                    $brand->cat_name = $row[5];
                    $brand->cat_slug = $brand_slug;
                    $brand->save();
                }

                $model = Model1::where('cat_name',$row[6])->first();

                if(!$model)
                {
                    $model_slug = Str::slug($row[6], "-");

                    if (Model1::where('cat_slug',$model_slug)->exists()) {
                        $model_slug = $this->incrementSlug($model_slug,3);
                    }

                    $model = new Model1;
                    $model->brand_id = $brand->id;
                    $model->cat_name = $row[6];
                    $model->cat_slug = $model_slug;
                    $model->save();
                }

                $check = Products::where('id',$row[1])->first();

                if(!$check)
                {
                    $check1 = Products::leftjoin('categories', 'categories.id', '=', 'products.category_id')->leftjoin('brands', 'brands.id', '=', 'products.brand_id')->leftjoin('models', 'models.id', '=', 'products.model_id')->where('products.title', 'LIKE', '%' . $row[2] . '%')->where('categories.cat_name', $row[4])->where('brands.cat_name', $row[5])->where('models.cat_name', $row[6])->select('products.*')->first();

                    if(!$check1)
                    {
                        $check = new Products;
                        $check->article_code = $row[0];
                        $check->title = $row[2];
                        $check->slug = $row[3];
                        $check->category_id = $category->id;
                        $check->brand_id = $brand->id;
                        $check->model_id = $model->id;
                        $check->model_number = $model_numbers;
                        $check->size = $sizes;
                        $check->measure = $row[9];
                        $check->estimated_price = $prices;
                        $check->additional_info = $row[11];
                        $check->floor_type = $row[12];
                        $check->floor_type2 = $row[13];
                        $check->supplier = $row[14];
                        $check->color = $colors;
                        $check->description = $row[16];
                        $check->excel = 1;
                        $check->save();

                        foreach ($pricesArray as $x => $price)
                        {
                            $est = new estimated_prices;
                            $est->product_id = $check->id;
                            $est->price = $price;
                            $est->save();
                        }

                        $this->data[] = $check->id;
                    }
                    else
                    {
                        $est = estimated_prices::where('product_id',$check1->id)->get();

                        if(count($est) == 0)
                        {
                            foreach ($pricesArray as $price)
                            {
                                $est = new estimated_prices;
                                $est->product_id = $check1->id;
                                $est->price = $price;
                                $est->save();
                            }
                        }
                        else
                        {
                            if(count($pricesArray) > 0)
                            {
                                foreach ($pricesArray as $x => $price)
                                {
                                    $est_check = estimated_prices::where('product_id',$check1->id)->skip($x)->first();

                                    if($est_check)
                                    {
                                        $est_check->price = $pricesArray[$x];
                                        $est_check->save();
                                    }
                                    else
                                    {
                                        $temp = new estimated_prices;
                                        $temp->product_id = $check1->id;
                                        $temp->price = $pricesArray[$x];
                                        $temp->save();
                                    }
                                }
                            }
                            else
                            {
                                estimated_prices::where('product_id',$check1->id)->delete();
                            }
                        }

                        $check1->article_code = $row[0];
                        $check1->slug = $row[3];
                        $check1->model_number = $model_numbers;
                        $check1->size = $sizes;
                        $check1->measure = $row[9];
                        $check1->estimated_price = $prices;
                        $check1->additional_info = $row[11];
                        $check1->floor_type = $row[12];
                        $check1->floor_type2 = $row[13];
                        $check1->supplier = $row[14];
                        $check1->color = $colors;
                        $check1->description = $row[16];
                        $check1->excel = 1;
                        $check1->save();

                        $this->data[] = $check1->id;
                    }
                }
                else
                {
                    $est = estimated_prices::where('product_id',$check->id)->get();

                    if(count($est) == 0)
                    {
                        foreach ($pricesArray as $price)
                        {
                            $est = new estimated_prices;
                            $est->product_id = $check->id;
                            $est->price = $price;
                            $est->save();
                        }
                    }
                    else
                    {
                        if(count($pricesArray) > 0)
                        {
                            foreach ($pricesArray as $x => $price)
                            {
                                $est_check = estimated_prices::where('product_id',$check->id)->skip($x)->first();

                                if($est_check)
                                {
                                    $est_check->price = $pricesArray[$x];
                                    $est_check->save();
                                }
                                else
                                {
                                    $temp = new estimated_prices;
                                    $temp->product_id = $check->id;
                                    $temp->price = $pricesArray[$x];
                                    $temp->save();
                                }
                            }
                        }
                        else
                        {
                            estimated_prices::where('product_id',$check->id)->delete();
                        }
                    }


                    $check->article_code = $row[0];
                    $check->title = $row[2];
                    $check->slug = $row[3];
                    $check->category_id = $category->id;
                    $check->brand_id = $brand->id;
                    $check->model_id = $model->id;
                    $check->model_number = $model_numbers;
                    $check->size = $sizes;
                    $check->measure = $row[9];
                    $check->estimated_price = $prices;
                    $check->additional_info = $row[11];
                    $check->floor_type = $row[12];
                    $check->floor_type2 = $row[13];
                    $check->supplier = $row[14];
                    $check->color = $colors;
                    $check->description = $row[16];
                    $check->excel = 1;
                    $check->save();

                    $this->data[] = $check->id;
                }

            }
            else {

                $check = Products::leftjoin('categories', 'categories.id', '=', 'products.category_id')->leftjoin('brands', 'brands.id', '=', 'products.brand_id')->leftjoin('models', 'models.id', '=', 'products.model_id')->where('products.title', 'LIKE', '%' . $row[2] . '%')->where('categories.cat_name', $row[4])->where('brands.cat_name', $row[5])->where('models.cat_name', $row[6])->select('products.*')->first();

                if ($check) {

                    $est = estimated_prices::where('product_id',$check->id)->get();

                    if(count($est) == 0)
                    {
                        foreach ($pricesArray as $price)
                        {
                            $est = new estimated_prices;
                            $est->product_id = $check->id;
                            $est->price = $price;
                            $est->save();
                        }
                    }
                    else
                    {
                        if(count($pricesArray) > 0)
                        {
                            foreach ($pricesArray as $x => $price)
                            {
                                $est_check = estimated_prices::where('product_id',$check->id)->skip($x)->first();

                                if($est_check)
                                {
                                    $est_check->price = $pricesArray[$x];
                                    $est_check->save();
                                }
                                else
                                {
                                    $temp = new estimated_prices;
                                    $temp->product_id = $check->id;
                                    $temp->price = $pricesArray[$x];
                                    $temp->save();
                                }
                            }
                        }
                        else
                        {
                            estimated_prices::where('product_id',$check->id)->delete();
                        }
                    }

                    $check->article_code = $row[0];
                    $check->slug = $row[3];
                    $check->model_number = $model_numbers;
                    $check->size = $sizes;
                    $check->measure = $row[9];
                    $check->estimated_price = $prices;
                    $check->additional_info = $row[11];
                    $check->floor_type = $row[12];
                    $check->floor_type2 = $row[13];
                    $check->supplier = $row[14];
                    $check->color = $colors;
                    $check->description = $row[16];
                    $check->excel = 1;
                    $check->save();

                    $this->data[] = $check->id;

                } else {

                    $category = Category::where('cat_name', $row[4])->first();

                    if (!$category) {

                        $cat_slug = Str::slug($row[4], "-");

                        if (Category::where('cat_slug', $cat_slug)->exists()) {
                            $cat_slug = $this->incrementSlug($cat_slug, 1);
                        }

                        $category = new Category;
                        $category->cat_name = $row[4];
                        $category->cat_slug = $cat_slug;
                        $category->save();
                    }

                    $brand = Brand::where('cat_name', $row[5])->first();

                    if (!$brand) {

                        $brand_slug = Str::slug($row[5], "-");

                        if (Brand::where('cat_slug', $brand_slug)->exists()) {
                            $brand_slug = $this->incrementSlug($brand_slug, 2);
                        }

                        $brand = new Brand;
                        $brand->cat_name = $row[5];
                        $brand->cat_slug = $brand_slug;
                        $brand->save();
                    }

                    $model = Model1::where('cat_name', $row[6])->first();

                    if (!$model) {

                        $model_slug = Str::slug($row[6], "-");

                        if (Model1::where('cat_slug', $model_slug)->exists()) {
                            $model_slug = $this->incrementSlug($model_slug, 3);
                        }

                        $model = new Model1;
                        $model->brand_id = $brand->id;
                        $model->cat_name = $row[6];
                        $model->cat_slug = $model_slug;
                        $model->save();
                    }

                    $product = new Products;
                    $product->article_code = $row[0];
                    $product->title = $row[2];
                    $product->slug = $row[3];
                    $product->category_id = $category->id;
                    $product->brand_id = $brand->id;
                    $product->model_id = $model->id;
                    $product->model_number = $model_numbers;
                    $product->size = $sizes;
                    $product->measure = $row[9];
                    $product->estimated_price = $prices;
                    $product->additional_info = $row[11];
                    $product->floor_type = $row[12];
                    $product->floor_type2 = $row[13];
                    $product->supplier = $row[14];
                    $product->color = $colors;
                    $product->description = $row[16];
                    $product->excel = 1;
                    $product->save();

                    $this->data[] = $product->id;

                    foreach ($pricesArray as $x => $price)
                    {
                        $est = new estimated_prices;
                        $est->product_id = $product->id;
                        $est->price = $price;
                        $est->save();
                    }

                    /*return new Products([
                        'title' => $row[1],
                        'slug' => $row[2],
                        'description' => $row[3],
                        'category_id' => $category->id,
                        'brand_id' => $brand->id,
                        'model_id' => $model->id
                    ]);*/
                }
            }
        }
    }
}
