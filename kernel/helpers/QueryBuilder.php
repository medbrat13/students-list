<?php

namespace StudentsList\Kernel\Helpers;

class QueryBuilder
{
    public function select(array $values): string
    {
        $col = $values[0] ?? '';
        $table = $values[1] ?? '';
        if ($values[3]) {
            $searchBy = "WHERE ";
            foreach ($values[3] as $value) {
                $searchBy .= "$value LIKE \"$values[2]\" OR ";
            }
            $searchBy = rtrim($searchBy, 'OR ');
        } else {
            $searchBy = '';
        }

        $orderBy = $values[4] ? "ORDER BY $values[4]" : '';
        $orderDir = $values[5] ?? '';
        $limit = $values[6] ? "LIMIT $values[6]" : '';
        $offset = $values[7] ? "OFFSET $values[7]" : '';

        $str = "SELECT $col FROM $table $searchBy $orderBy $orderDir $limit $offset";
        return $str;
    }
}