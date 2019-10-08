<?php 
//connection
$db=new PDO('mysql:host=localhost;dbname=pagination','root','');
//limit(səhifədəki məlumat sayı)
$limit=5;

//page(hansı səhifədə olduğumuzu bilmək üçün)
$page=isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
if ($page<=0) {
	$page=1;
}
//all_data(db-dəki ümümi məlumat sayı)
$all_data=$db->query('SELECT count(id) as allsum FROM pagination')->fetch(PDO::FETCH_ASSOC)['allsum'];


//page_num(ümumi neçə səhifə olduğunu bilmək üçün)
$page_num=ceil($all_data/$limit);

//start_num(neçədən başladığını bilmək üçün)
$start_num=($page * $limit)-$limit;

//select
$myquery=$db->query('SELECT * FROM pagination ORDER BY id DESC LIMIT '. $start_num . ' , ' . $limit)->fetchall(PDO::FETCH_ASSOC);
foreach ($myquery as $query) {
	echo $query['ad'].' '.$query['id'].'<br>';
}
$sag=$page+3;
$sol=$page-3;
if ($page<=3) {
	$sag=7;
}
if ($page>=$page_num) {
	$sol=$page_num-6;
}
echo '<div class="mypage">';
echo '<a href="index.php?page=' .($page>1 ? $page-1 : 1). '">Previous</a>';
for($i=$sol;$i<=$sag;$i++){
	if ($i>0 && $i<=$page_num) {
		echo '<a '.($i==$page ? 'class="active"' : '').' href="index.php?page='.$i.'">'.$i.'</a>';
	}
}
echo '<a href="index.php?page=' .($page<$page_num ? $page+1 : $page_num). '">Next</a>';
echo '</div>';

?>

<style>
	.mypage a{
		display: inline-block;
		padding: 10px;
		margin-right: 5px;
		background-color: skyblue;
		text-decoration: none;
		border-radius: 10px;

	}
	.mypage a.active{
		background-color: black;
		color: white;
	}

</style>