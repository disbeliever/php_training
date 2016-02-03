<?php
class UrlHelper
{
    private static $scriptName = "index.php";

    static function getSortingURL($search, $sort, $dir, $page, $currentSortField)
    {
        $dir = $currentSortField == $sort && $dir == "asc" ? "desc" : "asc";
        return self::$scriptName . "?" .
                     http_build_query(
                         [
                             'searchString' => $search,
                             'sort' => $sort,
                             'dir' => $dir,
                             'page' => $page
                         ]
                     );
    }

    static function getSortDirGlyph($sort, $dir, $currentSortField)
    {
        if ($sort == $currentSortField) {
            return $dir == 'desc' ? '&#8593;' : '&#8595;';
        }
    }

    /**
     * Generates template URL for Pager
     * @param string $search what we're searching for
     * @param string $sort what field to sort on
     * @param string $dir sorting direction ('desc' or 'asc')
     * @param string $page page number
     */
    static function getPagerURL($search, $sort, $dir, $page)
    {
        return self::$scriptName . "?" .
                     http_build_query(
                         [
                             'searchString' => $search,
                             'sort' => $sort,
                             'dir' => $dir,
                         ]) . "&page={page}";
    }
}
