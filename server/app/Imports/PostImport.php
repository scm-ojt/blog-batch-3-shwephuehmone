<?php

namespace App\Imports;

use App\Models\Post;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PostImport implements ToCollection, WithHeadingRow, WithValidation
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if ($row['action'] == 'create') {
                Post::create([
                    'user_id' => $row['user_id'],
                    'image' => $row['image'],
                    'title' => $row['title'],
                    'body' => $row['body'],
                ]);
            // $cat = categories()->sync($request->categories);
            } elseif ($row['action'] == 'update') {
                $post = Post::find($row['id']);
                $post-> user_id = $row['user_id'];
                $post-> image = $row['image'];
                $post-> title = $row['title'];
                $post-> body = $row['body'];
                $post->save();
            } elseif ($row['action'] == 'delete') {
                Post::where('id', $row['id'])->delete();
            }
        }
    }

    public function rules(): array
    {
        return
        [
            '*.user_id' => 'required',
            '*.image' => 'required',
            '*.title' => 'required',
            '*.body' => ['required','max:225'],
            '*.action' => 'required'
        ];
    }
}