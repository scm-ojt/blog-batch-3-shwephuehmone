<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PostExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return Post::where('title', 'like', '%' .$this->keyword. '%')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'user_id',
            'image',
            'title',
            'body'
        ];
    }
}