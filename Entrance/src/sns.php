<?php
require(__DIR__."/../../env.php");

$stmt = $sql->prepare("
SELECT
	a.*,
	s.ICON AS `SERVICE_ICON`,
	s.NAME AS `SERVICE_NAME`,
	s.URL AS `SERVICE_URL`
FROM
	`SNS_ACCOUNT` AS a
JOIN
	`SNS_SERVICE` AS s ON a.SERVICE = s.ID
");
$stmt->execute();
$account_list = $stmt->fetchAll();
?>

<TABLE>
	<?php
		foreach ($account_list as $account) {
			if ($account["OBSOLETE"] == 1) continue;
			$service_icon = "/Asset/SNS/".$account["SERVICE_ICON"].".png";
			$service_name = $account["SERVICE_NAME"];
			$name = $account["NAME"];
			$url = $account["SERVICE_URL"];

			$url = str_replace("\$UID", $account["UID"], $url);

			?>
			<TR>
				<TD>
					<IMG SRC="<?=$service_icon?>">
				</TD>
				<TD>
					<?php
					if ($url == null) {
						echo $service_name.$name;
					} else {
						?>
						<A HREF="<?=$url?>" TARGET="_blank">
							<?=$service_name?><?=$name?>
						</A>
						<?php
					}
					?>
				</TD>
				<TD>
					<?=htmlspecialchars($account["UID"])?>
				</TD>
			</TR>
			<?php
		}
	?>
</TABLE>

<HR>
廃止済みアカウント
<TABLE>
	<?php
		foreach ($account_list as $account) {
			if ($account["OBSOLETE"] == 0) continue;
			$service_icon = "/Asset/SNS/".$account["SERVICE_ICON"].".png";
			$service_name = $account["SERVICE_NAME"];
			$name = $account["NAME"];
			$url = $account["SERVICE_URL"];

			$url = str_replace("\$UID", $account["UID"], $url);

			?>
			<TR>
				<TD>
					<IMG SRC="<?=$service_icon?>">
				</TD>
				<TD>
					<?php
					if ($url == null) {
						echo $service_name.$name;
					} else {
						?>
						<A HREF="<?=$url?>" TARGET="_blank">
							<?=$service_name?><?=$name?>
						</A>
						<?php
					}
					?>
				</TD>
				<TD>
					<?=htmlspecialchars($account["UID"])?>
				</TD>
			</TR>
			<?php
		}
	?>
</TABLE>