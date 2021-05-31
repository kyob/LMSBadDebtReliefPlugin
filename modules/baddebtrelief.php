<?php

function getFirstYear()
{
    $db = LMSDB::getInstance();
    $firstYear = $db->GetOne('SELECT MIN( TIME ) FROM cash');
    return $firstYear;
}

function badDebtRelief($year)
{
    $db = LMSDB::getInstance();
    $overdue_in_days = 90;

    for ($i = 1; $i <= 12; $i++) {
        $month = sprintf("%02d", $i);
        $query = "SELECT d.id AS docid, cu.id AS customerid, d.name AS contractor, d.address AS address, d.ten AS tax_id, 
        to_timestamp(d.cdate)::date AS date_of_invoice, 
        to_timestamp(d.cdate+(d.paytime*86400))::date AS date_of_payment, 
       round(((extract(epoch FROM now())-(d.sdate+(d.paytime*86400)))/86400)) AS days_after_payment_deadline, 
   d.fullnumber AS invoice_number, 
   abs(round(ca.value-(ca.value*(t.value/100)),2)) AS net, 
   abs(round((ca.value*(t.value/100)),2)) AS vat, t.label AS vat_rate, 
   abs(ca.value) AS gross 
   FROM documents d 
   LEFT JOIN customers cu ON d.customerid = cu.id 
   LEFT JOIN cash ca ON d.id = ca.docid 
   LEFT JOIN taxes t ON ca.taxid = t.id 
   WHERE cu.type=1 AND d.closed=0 AND cu.deleted=0 AND d.type=1 
   AND ((((extract(epoch FROM now())-(d.sdate + d.paytime*86400)))/86400)>$overdue_in_days) 
   AND extract('year' from to_timestamp(d.cdate)) = $year
   AND extract('month' from to_timestamp(d.cdate)) = $month
   ORDER BY t.label";
        $report[$i] = $db->GetAll($query);
    }
    return $report;
}

$SMARTY->assign('baddebtrelief', 0);

if ($_GET['year'] > 0) {
    $SMARTY->assign('report', badDebtRelief($_GET['year']));
}

$SMARTY->assign('firstYear', date("Y", getFirstYear()));
$SMARTY->assign('currentYear', date("Y", time()));
$SMARTY->display('baddebtrelief.html');
