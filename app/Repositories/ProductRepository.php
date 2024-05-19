<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class ProductRepository implements RepositoryInterface
{
    public static function GetByField($field, $value)
    {
        return (new self)->query()->where($field, $value)->get();
    }

    private function query(): Builder
    {
        $query = Product::query();
        return $query;
    }

    public static function FindById($id)
    {
        return (new self)->query()->where('id', $id)->first();
    }

    static function NewItem($data, $addProductCreatorId = true)
    {
        return Product::create($data);
    }

    static function UpdateItem($data, $id)
    {
        $record = (new self)->FindByField("id", $id);
        if (!$record) return null;

        foreach ($data as $key => $value) {
            $record->{$key} = $value;
        }
        $record->save();

        return $record->id;
    }

    public static function FindByField($field, $value)
    {
        return (new self)->query()->where($field, $value)->first();
    }


    public static function Index()
    {
        return app(Pipeline::class)
            ->send(
                (new self)->query()
            )
            ->thenReturn()
            ->orderByDesc('created_at')
            ->get();
    }

    public static function Search($request)
    {
        $query = (new self)->query();
        if (!empty($request->title)) $query->where('title', 'LIKE', '%' . trim($request->title) . '%');
        if (!empty($request->brand)) $query->where('brand', 'LIKE', '%' . trim($request->brand) . '%');

        return $query
            ->orderByDesc('id')
            ->paginate(env('PAGINATE'));
    }

    //Permission

    static function Builder(): Builder
    {
        return (new self)->query()->select('*');
    }

    static function Remove($id)
    {
        $record = (new self)->FindByField("id", $id);
        if (!$record) return null;
        return $record->delete();
    }

}
