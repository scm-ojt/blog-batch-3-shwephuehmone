<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CategoryExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function __construct($keyword)
    {
        $this->keyword = $keyword;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Category::where('name', 'like', '%' .$this->keyword. '%')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'created_at',
            'updated_at',
            'action'
        ];
    }
}