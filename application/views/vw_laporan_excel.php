<?php
 
 header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=$title.xlsx");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");
 
 ?>
 
 <table border="1" width="100%">
 
      <thead>
 
           <tr>
 
                <th>Judul</th>
 
                <th>Penulis</th>

 
           </tr>
 
      </thead>
 
      <tbody>
 
           <?php $i=1; foreach($buku as $buku) { ?>
 
           <tr>
 
                <td><?php echo $buku->nama_agen; ?></td>
                <td><?php echo $buku->jenis_agen; ?></td>

 
           </tr>
 
           <?php $i++; } ?>
 
      </tbody>
 
 </table>