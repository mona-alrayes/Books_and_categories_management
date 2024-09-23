<?php

namespace App\Services;
use App\Models\Book;
use Exception;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;


class CategoryService
{

    /**
     * Method to get all categories
     *
     * @throws Exception
     *
     * @retrun array of categories
     *
     */
    public function getAll(): array
    {
        try {
            $categories = Category::paginate(5);
            return [
                'data' => $categories->items(), // The items on the current page
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total(),
            ];
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve categories: ' . $e->getMessage());
        }
    }


    /**
     * @param array $data of data of category to store
     *
     * @return Category
     *
     * @throws Exception
     *
     */
    public function store(array $data): Category
    {
        try {
            $category = Category::create($data);

            if (!$category) {
                throw new Exception('Failed to create the category.');
            }

            return $category;
        } catch (Exception $e) {
            throw new Exception('Category creation failed: ' . $e->getMessage());
        }
    }


    /**
     * Store a category
     *
     * @param string $id of the category
     *
     * @return Category the category associated
     *
     * @throws Exception
     *
     */
    public function show(string $id): Category
    {
        try {
            return Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception('Category not found: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve Category: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing category.
     *
     * @param array $data
     *
     * @param string $id
     * The ID of the category to update.
     *
     * @return Category
     * The updated category resource.
     *
     * @throws \Exception
     * Throws an exception if the category is not found or update fails.
     */
    public function update(array $data, string $id): Category
    {
        try {
            $category = Category::findOrFail($id);
            $category->update(array_filter($data));
            return $category;
        } catch (ModelNotFoundException $e) {
            throw new Exception('Category not found: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Failed to update Category: ' . $e->getMessage());
        }
    }

    /**
     * Delete a category by its ID.
     *
     * @param string $id
     * The ID of the category to delete.
     *
     * @return string
     * A message confirming the successful deletion.
     *
     * @throws \Exception
     * Throws an exception if the category is not found or deletion fails.
     */
    public function delete(string $id): string
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return "Category deleted successfully.";
        } catch (ModelNotFoundException $e) {
            throw new Exception('Category not found: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Failed to delete Category: ' . $e->getMessage());
        }
    }

    /**
     * Show SoftDeleted categories
     *
     * @return LengthAwarePaginator of Categories
     *
     * @throws Exception
     *
     */
    public function showDeleted(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        try {
            return Category::onlyTrashed()->paginate(5);
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve trashed Category: ' . $e->getMessage());
        }
    }
    /**
     * @throws Exception
     */
    public function restoreDeleted(string $id): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder
    {
        try {
            $category = Category::onlyTrashed()->where('id', $id)->firstOrFail();
            $category->restore();
            return $category;
        }catch (ModelNotFoundException $e) {
            throw new Exception('Category not found: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Failed to restore category: ' . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function ForceDelete(string $id):string
    {
        try{
            $category = Category::onlyTrashed()->where('id', $id)->firstOrFail();
            $category->forceDelete();
            return "Category deleted Forever from database successfully.";
        }catch (ModelNotFoundException $e) {
            throw new Exception('Category not found: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Failed to restore category: ' . $e->getMessage());
        }
    }
}
