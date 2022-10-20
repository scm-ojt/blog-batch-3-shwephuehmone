<?php

namespace App\Imports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PostImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Post([
            'user_id' => $row['user_id'],
            'image'     => $row['image'],
            'title'     => $row['title'],
            'body'     => $row['body'],
            'created_at' => $row->created_at->format('Y-m-d'),
            'updated_at' => $row->updated_at->format('Y-m-d'),
        ]);
    }
}