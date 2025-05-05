<?php  include_once("assets/fonksiyonlar.php");

$tercih=$_POST["tercih"];

function txtOlustur($baglanti) {
	$dosyaAd=date("d.m.Y");			
	header('Content-Encoding: UTF-8');
	header('Content-Type: text/plain; charset=utf-8');
	header('Content-disposition: attachment; filename='.$dosyaAd.'.txt');
	echo "\xEF\xBB\xBF"; // bom

	$al=$baglanti->prepare("select * from bulten");
	$al->execute();	
		
		while ($sonuc=$al->fetch(PDO::FETCH_ASSOC)) :		
		echo $sonuc["mail"]."\r\n"; 		
		endwhile;		

}



function excelolustur($baglanti,$filename='cikti',$satir=array(),$data=array())

{
	
	header('Content-Encoding: UTF-8');
	header('Content-Type: text/plain; charset=utf-8');
	header('Content-disposition: attachment; filename='.$filename.'.xls');
	echo "\xEF\xBB\xBF"; // bom
	
	
	$sayim=count($satir);
	
	echo '<table border="1"><th style="background-color:#000000"><font color="#FDFDFD">MAİL LİSTESİ</font></th><tr>';	
	
	foreach ($satir as $v) :
	
	echo '<th style="background-color:#FFA500">'.trim($v).'</th>';
	
	endforeach;
	
	echo '</tr>';
	
	
	foreach ($data as $val) :
	echo '<tr>';
	
			for ($i=0; $i < $sayim; $i++) :			
			echo '<td>'.$val[$i].'</td>'; 
			endfor;
			echo '</tr>';
	
	
	endforeach;	
	
	echo '</table>';
	

	
	

	
	}
/// fonksiyon bitti


$baslik=array();
$maildata=array();

$baslik=array('Mail Adresi');


			$al=$baglanti->prepare("select * from bulten");
			$al->execute();	
		
		while ($sonuc=$al->fetch(PDO::FETCH_ASSOC)) :			
		@$maildata[]=array($sonuc["mail"]);		
		endwhile;
				 	 


if ($tercih=="txt") :

txtOlustur($baglanti);

else:

excelolustur($baglanti,date("d.m.Y"),$baslik,$maildata);

endif;


?>