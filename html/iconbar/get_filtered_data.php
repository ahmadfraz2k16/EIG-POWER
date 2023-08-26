<?php
include 'C:/xampp/htdocs/latest_Dash/backend/functions.php';
// get_filtered_data.php

// Include your database connection code here

if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];



    $HydroSubCategoryQueries = array(
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'HYDEL' AND Time BETWEEN '$startDate' AND '$endDate'",
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'IPPS HYDEL HYDEL' AND Time BETWEEN '$startDate' AND '$endDate'"

    );
    // $HydroSubCategoryQueries = array(
    // "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'HYDEL'",
    // "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'IPPS HYDEL HYDEL'"
    // );
    $HydroSubCategoryNames = array(
    "Private",
    "Public"
    );
    generateCategoryCardnew("HYDRO", count($HydroSubCategoryQueries), $HydroSubCategoryQueries, "mdi mdi-water text-info ", $HydroSubCategoryNames);

    $RenewableSubCategoryQueries = array(
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'SOLAR' AND Time BETWEEN '$startDate' AND '$endDate'",
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'WIND' AND Time BETWEEN '$startDate' AND '$endDate'",
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'IPPS BAGASSE BAGASSE' AND Time BETWEEN '$startDate' AND '$endDate'"
    );
    $RenewableSubCategoryNames = array(
    "Solar",
    "Wind",
    "Bagasse"
    );
    generateCategoryCardnew("RENEWABLE", count($RenewableSubCategoryQueries), $RenewableSubCategoryQueries, "mdi mdi-tree text-success", $RenewableSubCategoryNames);

    $NuclearSubCategoryQueries = array(
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'NUCLEAR' AND Time BETWEEN '$startDate' AND '$endDate'"
    );
    $NuclearSubCategoryNames = array(
    "Nuclear"
    );
    generateCategoryCardnew("NUCLEAR", count($NuclearSubCategoryQueries), $NuclearSubCategoryQueries, "mdi mdi-radioactive text-danger ", $NuclearSubCategoryNames);

    $ThermalSubCategoryQueries = array(
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel IN ('GENCOS Gas', 'GENCOS Coal', 'GENCOS RLNG') AND Time BETWEEN '$startDate' AND '$endDate'",
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel IN ('IPPS FOSSIL FUEL Gas', 'IPPS FOSSIL FUEL Coal', 'IPPS FOSSIL FUEL FO', 'IPPS FOSSIL FUEL RLNG') AND Time BETWEEN '$startDate' AND '$endDate'"
    );
    $ThermalSubCategoryNames = array(
    "Gencos",
    "IPPS"
    );
    generateCategoryCardnew("THERMAL", count($ThermalSubCategoryQueries), $ThermalSubCategoryQueries, "mdi mdi-fire text-warning ", $ThermalSubCategoryNames);



    // Generate your SQL queries with the provided date range

    // Execute the queries, fetch data, and prepare the cards HTML

    // Return the HTML content as response
    // echo $cardsHtml;
} else {
echo "Invalid parameters";
}