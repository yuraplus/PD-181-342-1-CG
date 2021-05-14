<?php 

require "../libs/db.php";

$alldata = R::findAll('statistics', 'club = ?', array($_POST['club']));
$bigarray = array();
$datenow = date('d.m.Y');
$datemonthago = date("d.m.Y", mktime(0, 1, date('s'), date('m') - 1, date('d'), date('Y')));
$lastday = date("t", strtotime("-1 month"))+1; 
for ($i = 0; $i<$lastday; $i++) {
	$sumSpent = 0;
	$sumCpf = 0;
	$sumSubs = 0;
	$sumCpccount = 0;
	$sumCpc = 0;
	$sumRk = 0;
	$sumCtr = 0;
	foreach ($alldata as $key) {
		$datekey = date('d.m.Y', strtotime($key->updatedate));
		if ($datekey == $datemonthago) {
			$sumSpent = $sumSpent + $key->spent;
			$sumCpf = $sumCpf + $key->cpf;
			$sumSubs = $sumSubs + $key->subs;
			$sumCpccount = $sumCpccount + $key->cpccount;
			$sumCpc = $sumCpc + $key->cpc;
			$sumRk = $sumRk + $key->activeads;
			$sumCtr = $sumCtr + $key->ctr;
		}
	}
	$darray = array(
		'spent' => $sumSpent,
		'cpf' => $sumCpf,
		'subs' => $sumSubs,
		'cpccount' => $sumCpccount,
		'cpc' => $sumCpc,
		'rk' => $sumRk,
		'ctr' => $sumCtr,
	);
	$array = array(
		'label' => date('d.m', strtotime($datemonthago)),
		'data' => $darray,
	);
	$datemonthago = date('d.m.Y', strtotime($datemonthago)+86400);
	$stack = array($array);
	$bigarray = array_merge($bigarray, $stack);
}
echo json_encode($bigarray);
?>