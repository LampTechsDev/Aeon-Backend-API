<?php 

namespace App\Facade;

use App\Http\Components\Classes\PDFParser as PDFParserClasse;
use Illuminate\Support\Facades\Facade;

class PDFParser extends Facade{
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return PDFParserClasse::class;
    }
}