<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FilamentTable extends Component
{
    public $records;
    public $columns;

    public function __construct($records, $columns)
    {
        $this->records = $records;
        $this->columns = $columns;
    }

    public function render()
    {
        return view('components.filament-table');
    }
}