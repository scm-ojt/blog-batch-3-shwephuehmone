<?php

namespace App\Imports;

use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CategoryImport implements ToCollection, WithHeadingRow, WithValidation
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
                Category::create([
                    'name' => $row['name'],
                ]);
            } elseif ($row['action'] == 'update') {
                $category = Category::findorfail($row['id']);
                $category-> name = $row['name'];
                $category->save();
            } elseif ($row['action'] == 'delete') {
                Category::where('id', $row['id'])->delete();
            }
        }
    }
    
    public function rules(): array
    {
        return
        [
            '*.name' => 'required',
            '*.action' => 'required'
        ];
    }
}