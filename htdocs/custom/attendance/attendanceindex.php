<?php
/* Copyright (C) 2001-2005 Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2015 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2012 Regis Houssin        <regis.houssin@inodbox.com>
 * Copyright (C) 2015      Jean-François Ferry	<jfefe@aternatik.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 *	\file       attendance/attendanceindex.php
 *	\ingroup    attendance
 *	\brief      Home page of attendance top menu
 */

// Load Dolibarr environment
$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) {
	$res = @include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
}
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp = empty($_SERVER['SCRIPT_FILENAME']) ? '' : $_SERVER['SCRIPT_FILENAME']; $tmp2 = realpath(__FILE__); $i = strlen($tmp) - 1; $j = strlen($tmp2) - 1;
while ($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i] == $tmp2[$j]) {
	$i--;
	$j--;
}
if (!$res && $i > 0 && file_exists(substr($tmp, 0, ($i + 1))."/main.inc.php")) {
	$res = @include substr($tmp, 0, ($i + 1))."/main.inc.php";
}
if (!$res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php")) {
	$res = @include dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php";
}
// Try main.inc.php using relative path
if (!$res && file_exists("../main.inc.php")) {
	$res = @include "../main.inc.php";
}
if (!$res && file_exists("../../main.inc.php")) {
	$res = @include "../../main.inc.php";
}
if (!$res && file_exists("../../../main.inc.php")) {
	$res = @include "../../../main.inc.php";
}
if (!$res) {
	die("Include of main fails");
}

require_once DOL_DOCUMENT_ROOT.'/core/class/html.formfile.class.php';

// Load translation files required by the page
$langs->loadLangs(array("attendance@attendance"));

$action = GETPOST('action', 'aZ09');

$now = dol_now();
$max = getDolGlobalInt('MAIN_SIZE_SHORTLIST_LIMIT', 5);

// Security check - Protection if external user
$socid = GETPOST('socid', 'int');
if (isset($user->socid) && $user->socid > 0) {
	$action = '';
	$socid = $user->socid;
}

// Security check (enable the most restrictive one)
//if ($user->socid > 0) accessforbidden();
//if ($user->socid > 0) $socid = $user->socid;
//if (!isModEnabled('attendance')) {
//	accessforbidden('Module not enabled');
//}
//if (! $user->hasRight('attendance', 'myobject', 'read')) {
//	accessforbidden();
//}
//restrictedArea($user, 'attendance', 0, 'attendance_myobject', 'myobject', '', 'rowid');
//if (empty($user->admin)) {
//	accessforbidden('Must be admin');
//}


/*
 * Actions
 */

// None


/*
 * View
 */

$form = new Form($db);
$formfile = new FormFile($db);
date_default_timezone_set('Asia/Kolkata'); 

function checkUser(){
	global $user;
	global  $db;
	$userid = $user->id;
	$date = date('Y-m-d');
	$get = $db->query("SELECT * FROM user_attendance WHERE userid = '$userid' and date = '$date' ");
	if($get->num_rows){
		$row = $get->fetch_object();
		if($row->checkout != ''){
			return ['status'=>2,'msg'=>'Checked In','data'=>$row];
		}else{
			return ['status'=>1,'msg'=>'Already checked out.','data'=>$row];
		}
	}else{
		return ['status'=>0,'msg'=>'Not Checked In Yet.','data'=>[]];
	}
}
if(isset($_GET['action'])){
	if($_GET['action']  == 'checkin'){
		$userid = $user->id;
		$date = date('Y-m-d');
		$checkin = date('h:i A');
		$chk = $db->query("SELECT * FROM user_attendance WHERE userid = '$userid' and date = '$date'");
		if(!$chk->num_rows){
			$sql = "INSERT INTO `user_attendance` (`userid`,`date`,`checkin`,`checkout`) 
			VALUES ('$userid','$date','$checkin',null)";
			$ins = $db->query($sql);
			if($ins){
				echo '<script>alert("Checked IN Successfully.");window.history.back();</script>';
			}else{
				echo '<pre>';print_r($db->error);exit;
			}
		}else{
			echo '<script>alert("Already checked in.");window.history.back();</script>';
		}
	}
	elseif($_GET['action'] == 'checkout'){
		$userid = $user->id;
		$date = date('Y-m-d');
		$checkout = date('h:i A');
		$chk = $db->query("SELECT * FROM user_attendance WHERE userid = '$userid' and date = '$date' and checkout IS NULL ");
		if($chk->num_rows){
			$sql = "UPDATE `user_attendance` SET checkout = '$checkout' WHERE userid = '$userid' and date = '$date'";
			$ins = $db->query($sql);
			if($ins){
				echo '<script>alert("Checked OUT Successfully.");window.history.back();</script>';
			}else{
				echo '<pre>';print_r($db->error);exit;
			}
		}else{
			echo '<script>alert("Already checked out.");window.history.back();</script>';
		}
	}
}
llxHeader("", $langs->trans("AttendanceArea"), '', '', 0, 0, '', '', '', 'mod-attendance page-index');

print load_fiche_titre($langs->trans("AttendanceArea"), '', 'attendance.png@attendance');

print '<div class="fichecenter"><div class="fichethirdleft">';


/* BEGIN MODULEBUILDER DRAFT MYOBJECT
// Draft MyObject
if (isModEnabled('attendance') && $user->hasRight('attendance', 'read')) {
	$langs->load("orders");

	$sql = "SELECT c.rowid, c.ref, c.ref_client, c.total_ht, c.tva as total_tva, c.total_ttc, s.rowid as socid, s.nom as name, s.client, s.canvas";
	$sql.= ", s.code_client";
	$sql.= " FROM ".MAIN_DB_PREFIX."commande as c";
	$sql.= ", ".MAIN_DB_PREFIX."societe as s";
	$sql.= " WHERE c.fk_soc = s.rowid";
	$sql.= " AND c.fk_statut = 0";
	$sql.= " AND c.entity IN (".getEntity('commande').")";
	if ($socid)	$sql.= " AND c.fk_soc = ".((int) $socid);

	$resql = $db->query($sql);
	if ($resql)
	{
		$total = 0;
		$num = $db->num_rows($resql);

		print '<table class="noborder centpercent">';
		print '<tr class="liste_titre">';
		print '<th colspan="3">'.$langs->trans("DraftMyObjects").($num?'<span class="badge marginleftonlyshort">'.$num.'</span>':'').'</th></tr>';

		$var = true;
		if ($num > 0)
		{
			$i = 0;
			while ($i < $num)
			{

				$obj = $db->fetch_object($resql);
				print '<tr class="oddeven"><td class="nowrap">';

				$myobjectstatic->id=$obj->rowid;
				$myobjectstatic->ref=$obj->ref;
				$myobjectstatic->ref_client=$obj->ref_client;
				$myobjectstatic->total_ht = $obj->total_ht;
				$myobjectstatic->total_tva = $obj->total_tva;
				$myobjectstatic->total_ttc = $obj->total_ttc;

				print $myobjectstatic->getNomUrl(1);
				print '</td>';
				print '<td class="nowrap">';
				print '</td>';
				print '<td class="right" class="nowrap">'.price($obj->total_ttc).'</td></tr>';
				$i++;
				$total += $obj->total_ttc;
			}
			if ($total>0)
			{

				print '<tr class="liste_total"><td>'.$langs->trans("Total").'</td><td colspan="2" class="right">'.price($total)."</td></tr>";
			}
		}
		else
		{

			print '<tr class="oddeven"><td colspan="3" class="opacitymedium">'.$langs->trans("NoOrder").'</td></tr>';
		}
		print "</table><br>";

		$db->free($resql);
	}
	else
	{
		dol_print_error($db);
	}
}
END MODULEBUILDER DRAFT MYOBJECT */


print '</div><div class="fichetwothirdright">';


/* BEGIN MODULEBUILDER LASTMODIFIED MYOBJECT
// Last modified myobject
if (isModEnabled('attendance') && $user->hasRight('attendance', 'read')) {
	$sql = "SELECT s.rowid, s.ref, s.label, s.date_creation, s.tms";
	$sql.= " FROM ".MAIN_DB_PREFIX."attendance_myobject as s";
	$sql.= " WHERE s.entity IN (".getEntity($myobjectstatic->element).")";
	//if ($socid)	$sql.= " AND s.rowid = $socid";
	$sql .= " ORDER BY s.tms DESC";
	$sql .= $db->plimit($max, 0);

	$resql = $db->query($sql);
	if ($resql)
	{
		$num = $db->num_rows($resql);
		$i = 0;

		print '<table class="noborder centpercent">';
		print '<tr class="liste_titre">';
		print '<th colspan="2">';
		print $langs->trans("BoxTitleLatestModifiedMyObjects", $max);
		print '</th>';
		print '<th class="right">'.$langs->trans("DateModificationShort").'</th>';
		print '</tr>';
		if ($num)
		{
			while ($i <span $num)
			{
				$objp = $db->fetch_object($resql);

				$myobjectstatic->id=$objp->rowid;
				$myobjectstatic->ref=$objp->ref;
				$myobjectstatic->label=$objp->label;
				$myobjectstatic->status = $objp->status;

				print '<tr class="oddeven">';
				print '<td class="nowrap">'.$myobjectstatic->getNomUrl(1).'</td>';
				print '<td class="right nowrap">';
				print "</td>";
				print '<td class="right nowrap">'.dol_print_date($db->jdate($objp->tms), 'day')."</td>";
				print '</tr>';
				$i++;
			}

			$db->free($resql);
		} else {
			print '<tr class="oddeven"><td colspan="3" class="opacitymedium">'.$langs->trans("None").'</td></tr>';
		}
		print "</table><br>";
	}
}
*/



print '</div>';
$chk = checkUser();
echo '
<style>
.text-bold{font-weight:bold;}
.text-danger{color:red;}
.text-center{text-align:center;}
.w-100{width:100%;}
.text-end{float:right;}
</style>
<div class="box divboxtable boxdraggable" id="boxto_42">
<table summary="boxtable42" width="100%" class="noborder boxtable">
	<tbody>
		<tr class="liste_titre box_titre">
			<th>
				<div class=" maxwidth250onsmartphone w-100">Welcome to attendance module.
					<p class="text-end">Date : <span class="text-bold">'.date('d-m-Y').'</span></p>
				</div>
			</th>
		</tr>
';
if($chk['status'] == 0){
	echo '<tr class="oddeven">
	<td class="center">
			<a href="?action=checkin" class="button button-save reposition">Check IN</a>
	</td>
</tr>';
}elseif($chk['status'] == 1){
	echo'<tr class="oddeven">
				<td class="center">
					Checked IN : <span class="text-bold">'.date('h:i A',strtotime($chk['data']->checkin)).'</span><br>
						
					<a onclick="return confirm('."'Are you sure ? '".')" href="?action=checkout" class="button button-save reposition ">Check OUT</a>
				</td>
			</tr>';
}else{
	echo'<tr class="oddeven">
				<td class="center">
						Checked IN : <span class="text-bold">'.date('h:i A',strtotime($chk['data']->checkin)).'</span><br>
						Checked OUT: <span class="text-bold">'.date('h:i A',strtotime($chk['data']->checkout)).'</span>
				</td>
			</tr>';
}
echo '</tbody>
</table>
</div>
';
echo '</div>';

// End of page
llxFooter();
$db->close();
