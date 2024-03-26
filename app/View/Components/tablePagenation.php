<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class tablePagenation extends Component
{
    public $table;
    public $headers;
    public $url;
    public $pagenation;

    public function __construct(
        string $table,
        array $headers = [],
        string $url = "",
        bool $pagenation = false 

    ) {
        $this->table = $table;
        $this->headers = $headers;
        $this->url = $url;
        $this->pagenation = $pagenation;
    }

    public function render(): View|Closure|string
    {
        return view('components.table-pagenation');
    }
}
