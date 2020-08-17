<?php

namespace App\Http\Services;

use App\Model\Category;

class CategoryService
{
    public function showAllCategories()
    {
        $categories = Category::all();
        return $categories;
    }

    public function createCategory($data)
    {
        $category = new Category([
            'name' => $data->get('name')
        ]);
        $category->save();

        return $category;
    }

    public function getCategoryById($id)
    {
        $category = Category::find($id);
        return $category;
    }

    public function updateCategoryById($data, $id)
    {
        $category = Category::find($id);
        $category->name = $data->get('name');
        $category->save();

        return $category;
    }

    public function deleteCategoryById($id)
    {
        try {
            $category = Category::find($id);
            $category->delete();

            return $category;
        } catch (Exception $e) {
            console.log($e);
            return null;
        }
    }

    public function searchCategory($query)
    {
        return DB::table('categories')
            ->where('name', 'like', '%'.$query.'%')
            ->get();
    }
}
