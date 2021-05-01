<?php

namespace App\Exports;

use App\Products;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return ["Article ID", "DB ID", "Title", "Slug", "Category", "Brand", "Model", "Model number", "Size", "Measure", "Estimated price", "Additional Info", "Floor type", "Floor type 2", "Supplier", "Color", "Description"];
    }

    public function collection()
    {
        $products = Products::where('article_code','!=',NULL)->latest('article_code')->first();

        if($products)
        {
            $article_code = $products->article_code;
        }
        else
        {
            $article_code = 999;
        }

        $to_increment = Products::where('article_code','=',NULL)->get();

        foreach ($to_increment as $key)
        {
            $article_code = $article_code + 1;

            $key->article_code = $article_code;
            $key->save();
        }

        return Products::leftjoin('categories','categories.id','=','products.category_id')->leftjoin('brands','brands.id','=','products.brand_id')->leftjoin('models','models.id','=','products.model_id')->select('products.article_code','products.id','products.title','products.slug','categories.cat_name','brands.cat_name as brand_name','models.cat_name as model_name','products.model_number','products.size','products.measure','products.estimated_price','products.additional_info','products.floor_type','products.floor_type2','products.supplier','products.color','products.description')->orderBy('products.article_code','Asc')->get();
    }
}
