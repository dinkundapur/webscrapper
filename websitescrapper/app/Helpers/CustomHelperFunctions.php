<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\Config;
use DB;

class CustomHelperFunctions {

    /**
     * Created By : Dinesh
     * Purpose    : Creates Pagination string details. Eg: Showing 5 to 10 of 25 entries
     * Created on : May 23 2018
     */
    public static function getPaginationString($results) {
        $total = $results->total();
        if ($total > 0) {
            $perPage = $results->perPage();
            if ($total > $perPage) {
                $currentPage = $results->currentPage();
                $showingFirst = ((($perPage * $currentPage) - $perPage) + 1);
                $reminder = ($total - ($perPage * $currentPage));
                if ($reminder >= 0) {
                    $showingSecond = $currentPage * $perPage;
                    return "Showing <b>" . $showingFirst . "</b> to <b>" . $showingSecond . "</b> of <b>" . $total . "</b> entries";
                } else {
                    $showingSecond = $total;
                    return "Showing <b>" . $showingFirst . "</b> to <b>" . $showingSecond . "</b> of <b>" . $total . "</b> entries";
                }
            } else {
                return "Showing <b>1</b> to <b>" . $total . "</b> of <b>" . $total . "</b> entries";
            }
        } else {
            return "";
        }
    }

}
