<?php
namespace App\Helpers;

class Pager
{
    private $totalPages;
    private $recordsPerPage;
    private $urlTemplate;
    public function __construct($totalPages, $recordsPerPage, $urlTemplate)
    {
        $this->totalPages = $totalPages;
        $this->recordsPerPage = $recordsPerPage;
        $this->urlTemplate = $urlTemplate;
    }
    
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    public function getLinkForPage($page)
    {
        return str_replace("{page}", $page, $this->urlTemplate);
    }
}
