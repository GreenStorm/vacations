<?php

    $vacDates = "06/11/2013 - 06/17/2013";
    $startDate = strtok($vacDates, "-");
    $endDate = $startDate;
    $endDate = strtok("-");
    
    $startDate= str_replace('/','-',$startDate);
    $endDate = str_replace('/','-',$endDate);
    $endDate = ltrim($endDate);
    $startDate = rtrim($startDate);
    $startDate = substr($startDate,-4)."-"."$startDate";
    $startDate = substr($startDate,0,strlen($startDate)-5);
    $endDate = substr($endDate,-4)."-"."$endDate";
    $endDate = substr($endDate,0,strlen($endDate)-5);
    
    
    echo "$startDate"."kkk";
    echo "$endDate";
?>