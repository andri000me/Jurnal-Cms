<?php
$tanggal=date('d-m-Y');
$tanggal1=date('Y-m-d');
$jam = date('H:i');
$modul = MD5("penelitian");
$id=$_GET[pel];
if($_GET[pel]==1){
	$kd="DOSEN";
}else if($_GET[pel]==2){
	$kd="MAHASISWA";
}else if($_GET[pel]==3){
	$kd="DOSEN";	
}else{
	$kd="MAHASISWA";
}
$batas = 20;
	$halaman = $_GET[halaman];
	if (empty($halaman))
	{
		$posisi = 0;
		$halaman = 1;
	}	
	else
	{
		$posisi = ($halaman - 1) * $batas;
	}

	switch($_GET[act])
	{
		default:


		if($id<=2){
			echo "<h3>LIST PENELITIAN $kd</h3><p align=right>";
		}else if($id==3){
			echo "<h3>JOURNAL FIP</h3><p align=right>";
		}else{
			echo "<h3>PENELITIAN $kd</h3><p align=right>";
		}


		echo"<font color=green><b>Tanggal : $tanggal <blink><font color=red> Jam $jam</blink></font></b></center>";
		echo "<form action=?".MD5("modul")."=$modul&act=tambah&pel=$id method=post id=tombol>";
		if($_SESSION[aksesid]==0){
				
				if($id<=2){
					echo"<input type=submit value='ADD PENELITIAN $kd' class='btn btn-success'>";
				}else if($id==3){
					echo"<input type=submit value='ADD JURNAL FIP' class='btn btn-success'>";
				}else{
					echo"<input type=submit value='ADD PENELITIAN $kd' class='btn btn-success'>";
				}

		}else if($_SESSION[aksesid]==1){
			
				if($id==1){
					echo"<input type=submit value='ADD PENELITIAN $kd' class='btn btn-success'>";
				}else if($id==3){
					echo"<input type=submit value='ADD JURNAL FIP' class='btn btn-success'>";
				}


		}else{
			
				if($id==2){
					echo"<input type=submit value='ADD PENELITIAN $kd' class='btn btn-success'>";
				}else if($id==4){
					echo"<input type=submit value='ADD PENELITIAN $kd' class='btn btn-success'>";
				}

		}
				


			echo"</form>";
		echo "<p><table class='table table-striped table-bordered bootstrap-datatable datatable responsive'>
				<tr>
					<th>No</th>
					<th><center>Kode Penelitian</th>
					<th><center>Judul Penelitian</th>
					<th><center>Waktu</th>
					<th><center>Penulis</th>
					<th><center>Download File</th>";
					if($_GET[pel]==3 AND $_SESSION[aksesid]!=2){
					echo"<th><center>Upload Cover</th>
						<th><center>Add Jurnal</th>";
					}else{

					}
					echo"<th><center>Delete</th>
				</tr>";
		$sqlx = mysql_query("select*from penelitian where id_pel='$_GET[pel]' LIMIT $posisi, $batas");
		$no = 1;
		while ($datax = mysql_fetch_array($sqlx))
		{
		
			echo "<tr>
				<td width=5%; align=center>$no</td>
				<td>$datax[pel_kode]</td>
				<td>$datax[pel_judul]</td>
				<td>$datax[pel_waktu]</td>
				<td>$datax[pel_penulis]</td>
				<td><a href='./modul/files/$datax[file]'><center><img src=image/page_white_put.png></a></td>";
				if($_GET[pel]==3 AND $_SESSION[aksesid]!=2){
				echo"<td>";
						if(empty($datax[pel_cover]) or $datax[pel_cover]=="no-cover.png")
								{
								echo"<a href=?modul=uploads&act=edit&id=$datax[id_m]><center><img src=image/webcam.png><br>File Belum Ada";
								}else{
									echo"<center><img src='./modul/file/$datax[pel_cover]' width=80px height=100px>";
									}
									echo"</a></td>";
				
				
						echo"<td align=center width=4%><a href='?".MD5("modul")."=$modul&act=listjurnal&pel=$id&jurnal=$datax[id_m]'><img src=image/book_next.png border=0></a></td>";
					}else{

					}
				
				echo "<td align=center width=4%><a href=./modul/xpenelitian.php?".MD5("modul")."=$modul&act=delete&id=$datax[id_m] onClick=\"return confirm('Delete Jurnal')\"><img src=image/del.png border=0></a></td>
				</tr>";
			$no++;
		} 
		echo "</table>";

		$sql1 = mysql_query("SELECT*from penelitian WHERE id_pel='$_GET[pel]'");
		$jumlah = mysql_num_rows($sql1);
			$jmlhalaman = ceil($jumlah / $batas);
			
			echo "<div id=paging>";
			if ($halaman > 1) 
				{
				$previous = $halaman - 1;
				echo "<A HREF=$_SERVER[PHP_SELF]?modul=$modul&halaman=1> << First</A><A HREF=$_SERVER[PHP_SELF]?modul=$modul&halaman=$previous> < Previous</A>  ";
				}
				else{
					echo "<< First | < Previous | ";
				}

			$angka = ($halaman > 4 ? "  " : " "); //Ternary operator
				for ($i=$halaman;$i<($halaman);$i++) {
					if ($i > 1)
						continue;
					$angka .= "<A HREF=$_SERVER[PHP_SELF]?modul=$modul&halaman=$i>$i</A> ";
				}
			// Angka tengah
				$angka .= " <b>$halaman</b> ";
			for ($i=$halaman+1;$i<($halaman+8);$i++) {
				if ($i > $jmlhalaman)
					break;
			$angka .= "<A HREF=$_SERVER[PHP_SELF]?modul=$modul&halaman=$i>$i</A> ";
			}

			// Angkat akhir
				$angka .= ($halaman+2<$jmlhalaman ? "
				<A HREF=$_SERVER[PHP_SELF]?modul=$modul&halaman=$jmlhalaman>$jmlhalaman</A> " : " ");
			echo "$angka";

// Link ke halaman berikutnya (Next)
			if ($halaman < $jmlhalaman) {
				$next = $halaman + 1;
				echo "<A HREF=$_SERVER[PHP_SELF]?modul=$modul&halaman=$next> Next > </A>
				<A HREF=$_SERVER[PHP_SELF]?modul=$modul&halaman=$jmlhalaman> Last >> </A> ";
}else{
	echo "Next > | Last >>";
}

		break;

		case "tambah":
			echo "<h3>INPUT PENELITIAN $kd</h3>";
			echo "<form action=./modul/proses.php method=post onSubmit=\"return validuser(this)\" enctype='multipart/form-data'>";
			echo "<table class='table table-striped table-bordered bootstrap-datatable datatable responsive'>
				<tr>
				<tr><td>Kode Penelitian</td><td><input type=text name=kode size=50></td></tr>
				<tr><td>Judul Penelitian</td><td><input type=text name=judul size=100></td></tr>
				<tr><td>Penulis</td><td><input type=text name=penulis size=50></td></tr>
				<tr><td>Keterangan</td><td><textarea name=keterangan cols=100 rows=3></textarea></td></tr>";
//========================================================================================================================

				echo"<tr><td>Tanggal Penelitian</td><td><select name=t>";
				for($i=1;$i<=31;$i++)
					{
						if($i<=9){
						echo"<option>0$i</option>";
						}else{
						echo"<option>$i</option>";
						}
					}
				echo"</select>";
				echo"<select name=m>";
				
						echo"<option value='01'>Januari</option>";
						echo"<option value='02'>Februari</option>";
						echo"<option value='03'>Maret</option>";
						echo"<option value='04'>April</option>";
						echo"<option value='05'>Mei</option>";
						echo"<option value='06'>Juni</option>";
						echo"<option value='07'>Juli</option>";
						echo"<option value='08'>Agustus</option>";
						echo"<option value='09'>September</option>";
						echo"<option value='10'>Oktober</option>";
						echo"<option value='11'>November</option>";
						echo"<option value='12'>Desember</option>";
								
				echo"</select>";
				echo"<select name=thn>";
				for($i=2014;$i<=2020;$i++)
					{
						echo"<option>$i</option>";
					}				
				echo"</select>";
				echo"</td></tr>
				<tr><td>File Journal</td><td><input name=data_upload type=file></td></tr>
				<tr><td>Abstrak</td><td><textarea name=abstrak class='ckeditor' id='content'></textarea></td></tr>
				
				<input type=hidden name=kd_pel value='$id'>";
				
				echo"<tr><td align=right colspan=2 id=tombol><input type=submit value=Save class='btn btn-info' onClick=\"return confirm('Pastikan seluruh data sudah terisi semua')\">
                                <input type=button class='btn btn-danger' value=Cancel onClick=\"self.history.back()\">
			      </form>
				</table>";
		break;

//=============================================================================================================================================================
		case"listjurnal":
		$sqlx = mysql_query("select*from penelitian where id_m='$_GET[jurnal]'");
		$datax = mysql_fetch_array($sqlx);
			echo"
			<table class='table table-striped table-bordered bootstrap-datatable datatable responsive'>
				<tr>
					<td rowspan=5 width=25%><center><img src='modul/file/$datax[pel_cover]' width=150px height=200px></td>
					<td>Kode Jurnal</td>
					<td>: $datax[pel_kode]</td>
				</tr>
				<tr>
					<td>Judul Jurnal</td>
					<td>: $datax[pel_judul]</td>
				</tr>
				<tr>
					<td>Tanggal</td>
					<td>: $datax[pel_waktu]</td>
				</tr>
				<tr>
					<td></td>
					<td>";echo "<form action=?".MD5("modul")."=$modul&act=addtambah&pel=$id&jurnal=$_GET[jurnal] method=post id=tombol><input type=submit value='Tambah Jurnal' class='btn btn-success'></form>"; echo"</td>
				</tr>

			</table>

			<table class='table table-striped table-bordered bootstrap-datatable datatable responsive'>
				<tr>
					<th>No</th>
					<th><center>Kode Jurnal</th>
					<th><center>Judul Jurnal</th>
					<th><center>Waktu</th>
					<th><center>Penulis</th>
					<th><center>Download File</th>
					<th><center>Delete</th>
				</tr>";
		$sql = mysql_query("select*from jurnal_pel where id_penelitian='$datax[id_m]'");
		$no = 1;
		while ($data = mysql_fetch_array($sql))
		{
		
			echo "<tr>
				<td width=5%; align=center>$no</td>
				<td>$data[pel_kode]</td>
				<td>$data[pel_judul]</td>
				<td>$data[pel_waktu]</td>
				<td>$data[pel_penulis]</td>
				<td><a href='./modul/files/$data[file]'><center><img src=image/page_white_put.png></a></td>";
				echo "<td align=center width=4%><a href=./modul/xpenelitian.php?".MD5("modul")."=$modul&act=deletex&id=$data[id_m] onClick=\"return confirm('Delete Jurnal')\"><img src=image/del.png border=0></a></td>
				</tr>";
			$no++;
		} 

		echo"</table>";
		break;
//=============================================================================================================================================================
	case "addtambah":
			echo "<h3>TAMBAH JURNAL</h3>";
			echo "<form action=./modul/proses-jurnal.php method=post onSubmit=\"return validuser(this)\" enctype='multipart/form-data'>";
			echo "<table class='table table-striped table-bordered bootstrap-datatable datatable responsive'>
				<tr>
				<tr><td>Kode Penelitian</td><td><input type=text name=kode size=50></td></tr>
				<tr><td>Judul Penelitian</td><td><input type=text name=judul size=100></td></tr>
				<tr><td>Penulis</td><td><input type=text name=penulis size=50></td></tr>
				<tr><td>Keterangan</td><td><textarea name=keterangan cols=100 rows=3></textarea></td></tr>";
//========================================================================================================================

				echo"<tr><td>Tanggal Penelitian</td><td><select name=t>";
				for($i=1;$i<=31;$i++)
					{
						if($i<=9){
						echo"<option>0$i</option>";
						}else{
						echo"<option>$i</option>";
						}
					}
				echo"</select>";
				echo"<select name=m>";
				
						echo"<option value='01'>Januari</option>";
						echo"<option value='02'>Februari</option>";
						echo"<option value='03'>Maret</option>";
						echo"<option value='04'>April</option>";
						echo"<option value='05'>Mei</option>";
						echo"<option value='06'>Juni</option>";
						echo"<option value='07'>Juli</option>";
						echo"<option value='08'>Agustus</option>";
						echo"<option value='09'>September</option>";
						echo"<option value='10'>Oktober</option>";
						echo"<option value='11'>November</option>";
						echo"<option value='12'>Desember</option>";
								
				echo"</select>";
				echo"<select name=thn>";
				for($i=2014;$i<=2020;$i++)
					{
						echo"<option>$i</option>";
					}				
				echo"</select>";
				echo"</td></tr>
				<tr><td>File Journal</td><td><input name=data_upload type=file></td></tr>
				<tr><td>Abstrak</td><td><textarea name=abstrak class='ckeditor' id='content'></textarea></td></tr>
				
				<input type=hidden name=kd_pel value='$_GET[jurnal]'>";
				
				echo"<tr><td align=right colspan=2 id=tombol><input type=submit value=Save class='btn btn-info' onClick=\"return confirm('Pastikan seluruh data sudah terisi semua')\">
                                <input type=button class='btn btn-danger' value=Cancel onClick=\"self.history.back()\">
			      </form>
				</table>";
		break;
		
	}

	

?>
