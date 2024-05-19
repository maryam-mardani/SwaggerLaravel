<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class UserRepository implements RepositoryInterface
{
    private function query(): \Illuminate\Database\Eloquent\Builder
    {
        return User::query();
    }

    public static function FindByField($field, $value)
    {
        return (new self)->query()->where($field, $value)->first();
    }
    public static function FindById($id)
    {
        return (new self)->query()->where('id', $id)->first();
    }

    public static function FindByFields($params)
    {
        $query = (new self)->query();
        foreach($params as $key=>$value){
            $query=$query->where($key, $value);
        }
        return $query->first();
    }


    static function NewItem($data): \Illuminate\Database\Eloquent\Model
    {
        return User::create($data);
    }
    static function UpdateItem($data, $id): int
    {
        $record = (new self )->FindByField("id",$id);
        foreach ($data as $key=>$value){
            $record->{$key}=$value;
        }
        return $record->save();
    }


    public static function Index()
    {
        return app(Pipeline::class)
            ->send(
                (new self)->query()
            )
            ->thenReturn()
            ->orderByDesc('created_at')
            ->paginate(env("PAGINATE"));
    }

    public static function GetAll()
    {
        return (new self)->query()->get();
    }

    static function Remove($id)
    {
        $record = (new self )->FindByField("id",$id);
        return $record ->delete();
    }

    static function Builder() : Builder {
        return User::query()->select('*');
    }


}
